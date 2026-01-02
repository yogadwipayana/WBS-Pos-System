#!/bin/bash

# Deployment script for Laravel Application
# Usage: ./deploy.sh

set -e

echo "🚀 Starting Laravel deployment..."

# Create necessary directories
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage bootstrap/cache

# Check if .env file exists
if [ ! -f .env ]; then
    echo "❌ Error: .env file not found!"
    echo "Please copy .env.example to .env and configure it:"
    echo "  cp .env.example .env"
    echo "  nano .env"
    exit 1
fi

# Load environment variables
export $(grep -v '^#' .env | xargs)

# Check required variables
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "❌ Error: APP_KEY not set in .env"
    echo "Please generate an APP_KEY:"
    echo "  php artisan key:generate"
    exit 1
fi

# Check database configuration
if [ -z "$DB_HOST" ]; then
    echo "❌ Error: DB_HOST not configured in .env"
    echo "Please set your external MySQL host"
    exit 1
fi

if [ -z "$DB_DATABASE" ] || [ -z "$DB_USERNAME" ] || [ -z "$DB_PASSWORD" ]; then
    echo "❌ Error: Database credentials not fully configured in .env"
    exit 1
fi

echo "📋 Configuration:"
echo "  Database: $DB_DATABASE @ $DB_HOST:${DB_PORT:-3306}"
echo "  App Environment: ${APP_ENV:-production}"
echo "  Domain: ${DOMAIN:-localhost}"

# Update nginx configuration with domain if provided
if [ ! -z "$DOMAIN" ]; then
    echo "🔧 Updating nginx configuration with domain..."
    # Check if template exists, otherwise use current config as template
    if [ ! -f docker/nginx-proxy.conf.template ]; then
        cp docker/nginx-proxy.conf docker/nginx-proxy.conf.template
    fi
    # Always generate from template to avoid multiple replacements
    sed "s/yourdomain.com/$DOMAIN/g" docker/nginx-proxy.conf.template > docker/nginx-proxy.conf
    echo "✅ Nginx configured for $DOMAIN"
else
    echo "⚠️  Warning: DOMAIN not set in .env, using default nginx configuration"
fi

# Create necessary directories on host
echo "📁 Creating directories..."
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Build and start services
echo "🐳 Building Docker images..."
docker compose build --no-cache

echo "🚀 Starting application service..."
docker compose up -d app

echo "⏳ Waiting for application to start..."
sleep 10

# FIX #1: Set permissions inside container (not on host)
echo "🔐 Setting permissions inside container..."
docker compose exec -T app chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/images
docker compose exec -T app chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/images

# Install dependencies (needed because volume mount overwrites container)
echo "📦 Installing Composer dependencies..."
docker compose exec -T app composer install --optimize-autoloader --no-dev

echo "📦 Installing NPM dependencies and building assets..."
docker compose exec -T app npm ci
docker compose exec -T app npm run build
docker compose exec -T app rm -rf node_modules

echo "🔗 Creating storage symlink..."
docker compose exec -T app php artisan storage:link || true

# FIX #4: Clear cache before caching (prevent stale cache issues)
echo "🧹 Clearing old caches..."
docker compose exec -T app php artisan optimize:clear

# Cache for production
echo "⚡ Caching configurations for production..."
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache

# Start all services
echo "🚀 Starting all services..."
docker compose up -d

# FIX #3: Increased wait time for services to be ready
echo "⏳ Waiting for services to start..."
sleep 15

echo "♻️  Reloading nginx..."
docker compose exec nginx nginx -s reload

# Show status
echo ""
echo "✅ Deployment complete!"
echo ""
echo "📊 Service Status:"
docker compose ps
echo ""
echo "🌐 Your site should be available at:"
if [ ! -z "$DOMAIN" ]; then
    echo "   http://$DOMAIN"
else
    echo "   http://localhost"
fi
echo ""
echo "📝 Useful commands:"
echo "   View logs:          docker compose logs -f"
echo "   View app logs:      docker compose logs -f app"
echo "   Laravel commands:   docker compose exec app php artisan [command]"
echo "   Database migration: docker compose exec app php artisan migrate"
echo "   Clear cache:        docker compose exec app php artisan optimize:clear"
echo "   Stop services:      docker compose down"
echo "   Restart:            docker compose restart"
echo ""
echo "⚠️  Note: If you change .env, run: docker compose exec app php artisan optimize:clear"