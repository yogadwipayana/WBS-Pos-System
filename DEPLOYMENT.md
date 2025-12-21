# 🚀 Panduan Deployment Laravel ke VPS Ubuntu

Panduan lengkap untuk deploy aplikasi **WBS Laravel** ke VPS Ubuntu menggunakan Docker dan Nginx (Latest Version).

## 📋 Prasyarat

1. **VPS Ubuntu** (20.04 atau lebih baru)
2. **Domain** (opsional) - Jika ingin menggunakan domain custom
3. **SSH Access** ke VPS dengan sudo privileges
4. **Minimal 2GB RAM** dan 20GB storage
5. **Port terbuka**: 22 (SSH), 80 (HTTP)

## 🛠️ Persiapan VPS

### 1. Update sistem dan install Docker

Jalankan perintah berikut di VPS Anda:

```bash
# Update sistem
sudo apt update && sudo apt upgrade -y

# Install dependencies
sudo apt install -y git curl wget nano ufw

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Install Docker Compose v2
sudo apt install -y docker-compose-plugin

# Atau jika ingin menggunakan Docker Compose standalone
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Add user to docker group
sudo usermod -aG docker $USER

# Apply group changes
newgrp docker

# Verify installation
docker --version
docker compose version
```

### 2. Setup Firewall (Recommended)

```bash
# Configure UFW firewall
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow 22/tcp    # SSH
sudo ufw allow 80/tcp    # HTTP

# Enable firewall
sudo ufw --force enable

# Check status
sudo ufw status
```

### 3. Clone Repository

```bash
# Create directory
cd /var/www
sudo mkdir -p wbs-laravel
sudo chown $USER:$USER wbs-laravel
cd wbs-laravel

# Clone your repository
git clone <your-repository-url> .

# Atau jika sudah ada local, upload via SCP/RSYNC
# rsync -avz --exclude='node_modules' --exclude='vendor' ./ user@vps:/var/www/wbs-laravel/
```

## ⚙️ Konfigurasi

### 1. Setup Environment File

```bash
# Copy .env.example to .env
cp .env.example .env

# Edit .env file
nano .env
```

**Konfigurasi penting di .env:**

```env
# Application
APP_NAME="WBS Laravel"
APP_ENV=production
APP_KEY=                              # Will be generated below
APP_DEBUG=false
APP_URL=http://localhost              # Or http://yourdomain.com if using custom domain

# Database (External MySQL Server)
DB_CONNECTION=mysql
DB_HOST=your-mysql-host.com           # Your external MySQL server hostname or IP
DB_PORT=3306
DB_DATABASE=wbs
DB_USERNAME=laravel
DB_PASSWORD=secure_db_password_here   # CHANGE THIS!

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database

# Server Configuration (Optional)
DOMAIN=yourdomain.com                 # Your domain name (optional, use if you have a domain)
```

> [!IMPORTANT] > **External MySQL Configuration**
>
> -   This deployment uses an **external MySQL database** (not containerized)
> -   Ensure your MySQL server is accessible from the Docker containers
> -   Required: MySQL 5.7+ or MySQL 8.0+
> -   The app container must be able to connect to `DB_HOST:DB_PORT`
>
> **Network Requirements:**
>
> -   If MySQL is on the same server: use host IP or `host.docker.internal`
> -   If MySQL is on different server: ensure firewall allows connections from your VPS
> -   MySQL user must have proper permissions for remote access

> [!NOTE]
> The deployment uses a **dual-nginx architecture**:
>
> -   **Internal nginx** runs inside the app container (via supervisord) for serving PHP-FPM
> -   **External nginx** (latest version) runs in a separate container as reverse proxy
> -   Both work together to provide a production-ready setup
> 
> **Domain Configuration:**
> -   If you set `DOMAIN` in .env, nginx will be configured to accept that domain
> -   The deploy script will automatically update nginx configuration with your domain
> -   You can access via domain name or server IP address
> -   No SSL/HTTPS - HTTP only on port 80

### 2. Generate Application Key

Ada dua cara:

**Cara 1: Generate di local (jika ada PHP + Composer)**

```bash
# Install dependencies
composer install --no-dev

# Generate key
php artisan key:generate

# Copy key yang muncul di .env
```

**Cara 2: Generate manual**

```bash
# Generate base64 encoded key
php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"

# Copy output dan tambahkan ke .env
# APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

### 3. Set Permissions

```bash
# Create necessary directories
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage bootstrap/cache
```

## 🚀 Deploy

### 1. Jalankan Deployment Script

```bash
# Make scripts executable
chmod +x deploy.sh

# Run deployment
./deploy.sh
```

Script akan otomatis:

-   ✅ Validasi konfigurasi (.env, database credentials, APP_KEY)
-   ✅ Update nginx configuration dengan domain Anda (jika DOMAIN di-set)
-   ✅ Build Docker images (with latest Nginx)
-   ✅ Install composer dependencies
-   ✅ Build frontend assets
-   ✅ Run migrations
-   ✅ Cache configurations untuk production
-   ✅ Start semua services

### 2. Verifikasi Deployment

```bash
# Check all containers are running
docker compose ps

# Should show all services healthy/running:
# NAME                STATUS                  PORTS
# laravel-app         Up                     80/tcp, 9000/tcp
# laravel-nginx       Up (healthy)           0.0.0.0:80->80/tcp

# Check logs
docker compose logs -f

# Test application via IP
curl -I http://your-vps-ip

# Or via domain (if configured)
curl -I http://yourdomain.com

# Verify database connection
docker compose exec app php artisan db:show

# Check database connectivity
docker compose exec app php artisan tinker
# Then run: DB::connection()->getPdo();
```

### 3. Akses Aplikasi

Buka browser dan akses:
- Via IP: `http://your-vps-ip`
- Via Domain: `http://yourdomain.com` (jika DOMAIN sudah dikonfigurasi di .env)

## 📊 Database Management

> [!NOTE]
> This setup uses an **external MySQL database**. All database operations should be performed directly on your MySQL server or via the Laravel application.

### Akses Database

```bash
# Via MySQL client from VPS or local machine
mysql -h $DB_HOST -u $DB_USERNAME -p $DB_DATABASE

# Via Laravel tinker from container
docker compose exec app php artisan tinker
# Then: DB::connection()->getPdo();
```

### Database Operations

```bash
# Run migrations
docker compose exec app php artisan migrate

# Run specific migration
docker compose exec app php artisan migrate --path=/database/migrations/2025_12_11_000002_create_bookings_table.php

# Rollback last migration
docker compose exec app php artisan migrate:rollback

# Refresh database (drop all + migrate)
docker compose exec app php artisan migrate:fresh

# Run seeders
docker compose exec app php artisan db:seed

# Run specific seeder
docker compose exec app php artisan db:seed --class=BookingSeeder
```

### Backup Database

> [!NOTE]
> Since you're using an external MySQL database, perform backups on your MySQL server directly or use remote backup tools.

```bash
# Remote backup from VPS
mysqldump -h $DB_HOST -u $DB_USERNAME -p $DB_DATABASE > backup_$(date +%Y%m%d_%H%M%S).sql

# Compress backup
gzip backup_*.sql

# Or backup from MySQL server directly
# On MySQL server:
mysqldump -u root -p wbs > /backups/wbs_backup_$(date +%Y%m%d_%H%M%S).sql
```

### Restore Database

```bash
# Restore from VPS
mysql -h $DB_HOST -u $DB_USERNAME -p $DB_DATABASE < backup.sql

# Or from compressed backup
gunzip < backup.sql.gz | mysql -h $DB_HOST -u $DB_USERNAME -p $DB_DATABASE
```

## 🔧 Perintah Berguna

### Laravel Artisan Commands

```bash
# Run migration
docker compose exec app php artisan migrate

# Run seeder
docker compose exec app php artisan db:seed

# Clear all cache
docker compose exec app php artisan optimize:clear

# Clear specific cache
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear

# Optimize for production
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
docker compose exec app php artisan optimize

# Check routes
docker compose exec app php artisan route:list

# Laravel tinker (REPL)
docker compose exec app php artisan tinker

# Create resources
docker compose exec app php artisan make:controller ControllerName
docker compose exec app php artisan make:model ModelName -m
docker compose exec app php artisan make:migration create_table_name
```

### Docker Commands

```bash
# View logs
docker compose logs -f                    # All services
docker compose logs -f app                # App only
docker compose logs -f nginx              # Nginx only
docker compose logs -f mysql              # MySQL only
docker compose logs --tail=100 app        # Last 100 lines

# Restart services
docker compose restart                    # All services
docker compose restart app                # App only
docker compose restart nginx              # Nginx only

# Stop services
docker compose down                       # Stop all
docker compose down -v                    # Stop and remove volumes (WARNING: deletes data!)

# Rebuild
docker compose build --no-cache          # Rebuild images
docker compose up -d --build             # Rebuild and restart

# Access container shell
docker compose exec app bash             # Laravel container
docker compose exec mysql bash           # MySQL container
docker compose exec nginx sh             # Nginx container

# Check resource usage
docker stats

# Clean up unused resources
docker system prune -a                   # Clean all unused
docker volume prune                      # Clean volumes
```

### Nginx Management

```bash
# Reload nginx configuration
docker compose exec nginx nginx -s reload

# Test nginx configuration
docker compose exec nginx nginx -t

# Check nginx version
docker compose exec nginx nginx -v

# View nginx access logs
docker compose logs nginx --tail=100 -f
```

## 🔄 Update Aplikasi

### Method 1: Using Update Script (Recommended)

```bash
# Run update script (includes backup, pull, rebuild, migrate)
./scripts/update.sh
```

### Method 2: Manual Update

```bash
# 1. Create backup first!
./scripts/backup.sh

# 2. Pull latest changes
git pull origin main

# 3. Put in maintenance mode
docker compose exec app php artisan down

# 4. Stop services
docker compose down

# 5. Rebuild images
docker compose build --no-cache

# 6. Start services
docker compose up -d

# 7. Wait for database
sleep 15

# 8. Run migrations
docker compose exec app php artisan migrate --force

# 9. Clear and cache
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

# 10. Exit maintenance mode
docker compose exec app php artisan up
```

## 🔒 Security Best Practices

### 1. Change Default Passwords

```bash
# Update .env dengan strong passwords
DB_PASSWORD=use_strong_password_here
DB_ROOT_PASSWORD=use_strong_root_password_here
```

### 2. Disable Debug Mode

```env
APP_ENV=production
APP_DEBUG=false
```

### 3. Setup Firewall

```bash
sudo ufw status
sudo ufw enable
```

### 4. Regular Updates

```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Update Docker images
docker compose pull
docker compose up -d
```

### 5. Monitor Logs

```bash
# Setup log monitoring
docker compose logs -f | grep -i "error\|warning\|critical"

# Check Laravel logs
docker compose exec app tail -f storage/logs/laravel.log
```

### 6. Backup Strategy

```bash
# Setup automated backups with cron
crontab -e

# Add daily backup at 2 AM
0 2 * * * cd /var/www/wbs-laravel && ./scripts/backup.sh >> /var/log/backup.log 2>&1

# Weekly cleanup (keep last 30 days)
0 3 * * 0 find /var/www/wbs-laravel/backups -name "*.gz" -mtime +30 -delete
```

## 🐛 Troubleshooting

### Container tidak start

```bash
# Check logs
docker compose logs app

# Check permissions
docker compose exec app ls -la storage/
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache

# Check disk space
df -h

# Check memory
free -h
```

### Database connection error

```bash
# Check if MySQL is running
docker compose ps mysql

# Check MySQL logs
docker compose logs mysql

# Verify credentials in .env
cat .env | grep DB_

# Test connection
docker compose exec app php artisan tinker
# Then run: DB::connection()->getPdo();

# Restart MySQL
docker compose restart mysql
sleep 10
docker compose exec app php artisan migrate
```

### Domain not accessible

```bash
# Check nginx config
docker compose exec nginx nginx -t

# Check domain DNS
nslookup yourdomain.com
dig yourdomain.com

# Check if port 80 is open
sudo ufw status
netstat -tulpn | grep :80

# Check nginx logs
docker compose logs nginx

# Verify domain configuration in .env
cat .env | grep DOMAIN
```

### Permission denied errors

```bash
# Fix storage permissions
docker compose exec app chown -R www-data:www-data /var/www/html/storage
docker compose exec app chmod -R 775 /var/www/html/storage

# Fix bootstrap cache
docker compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
docker compose exec app chmod -R 775 /var/www/html/bootstrap/cache
```

### 502 Bad Gateway

```bash
# Check if app container is running
docker compose ps app

# Check app logs
docker compose logs app

# Check PHP-FPM
docker compose exec app ps aux | grep php-fpm

# Restart services
docker compose restart app
sleep 5
docker compose restart nginx
```

### Disk space full

```bash
# Check disk usage
df -h

# Clean Docker
docker system prune -a -f
docker volume prune -f

# Clean old logs
docker compose exec app php artisan log:clear

# Remove old backups
find backups/ -name "*.gz" -mtime +30 -delete
```

### High memory usage

```bash
# Check resource usage
docker stats

# Optimize Laravel
docker compose exec app php artisan optimize
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache

# Restart services
docker compose restart
```

## 📈 Monitoring & Performance

### Monitor Application

```bash
# Check resource usage
docker stats

# System resources
htop
df -h
free -h

# Network monitoring
netstat -tulpn | grep :80
```

### Application Logs

```bash
# Laravel application logs
docker compose exec app tail -f storage/logs/laravel.log

# Nginx access logs
docker compose logs nginx | grep "GET\|POST"

# MySQL logs
docker compose logs mysql

# All logs with timestamp
docker compose logs -f --timestamps
```

### Performance Optimization

```bash
# Enable opcache (sudah included di php.ini)
docker compose exec app php -i | grep opcache

# Cache everything in production
docker compose exec app php artisan optimize

# Check cache status
docker compose exec app php artisan about

# Clear old sessions
docker compose exec app php artisan session:gc
```

### Health Checks

```bash
# HTTP health check via localhost
curl -I http://localhost

# HTTP health check via domain
curl -I http://yourdomain.com

# Check response time
time curl -s http://yourdomain.com > /dev/null

# Check if site is responding
wget --spider http://yourdomain.com
```

## 🔄 Maintenance Mode

```bash
# Enable maintenance mode
docker compose exec app php artisan down

# With custom message
docker compose exec app php artisan down --message="Under Maintenance"

# With retry time (seconds)
docker compose exec app php artisan down --retry=60

# Disable maintenance mode
docker compose exec app php artisan up

# Or use helper script
./scripts/maintenance.sh up      # Enable
./scripts/maintenance.sh down    # Disable
```

## 📦 Automated Backup Setup

### Setup Cron Jobs

```bash
# Edit crontab
crontab -e

# Add these lines:

# Daily backup at 2 AM
0 2 * * * cd /var/www/wbs-laravel && ./scripts/backup.sh >> /var/log/wbs-backup.log 2>&1

# Weekly cleanup (keep last 30 days)
0 3 * * 0 find /var/www/wbs-laravel/backups -name "*.gz" -mtime +30 -delete
```

### Backup to Remote Storage (Optional)

```bash
# Example: Backup to remote server via rsync
#!/bin/bash
BACKUP_DIR="/var/www/wbs-laravel/backups"
REMOTE_USER="backup"
REMOTE_HOST="backup.example.com"
REMOTE_PATH="/backups/wbs-laravel"

rsync -avz --delete $BACKUP_DIR/ $REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/
```

## 🆘 Support Checklist

Before asking for help, verify:

-   [ ] DNS pointing to correct IP (if using domain): `nslookup yourdomain.com`
-   [ ] Port 80 is open: `sudo ufw status`
-   [ ] .env file configured correctly: `cat .env | grep -v PASSWORD`
-   [ ] APP_KEY is set in .env
-   [ ] Docker services running: `docker compose ps`
-   [ ] Database is accessible from container
-   [ ] Nginx config valid: `docker compose exec nginx nginx -t`
-   [ ] Logs checked: `docker compose logs`
-   [ ] Disk space available: `df -h`
-   [ ] Memory available: `free -h`

## 🎯 Production Checklist

-   [ ] Environment variables configured correctly
-   [ ] APP_KEY generated and set
-   [ ] APP_DEBUG=false
-   [ ] Strong database passwords set
-   [ ] Domain DNS properly configured (if using domain)
-   [ ] Firewall configured and enabled
-   [ ] SSH hardened (key-based auth)
-   [ ] Automated backups configured
-   [ ] Log monitoring setup
-   [ ] Health checks passing
-   [ ] Performance optimized (cache enabled)
-   [ ] Security headers configured
-   [ ] Database migrations completed
-   [ ] Storage permissions correct
-   [ ] Nginx latest version running

## 📝 Catatan Penting

-   **Backup reguler!** Setup cron job untuk backup otomatis
-   **Monitor disk space** karena Docker images dan logs bisa membesar
-   **Update dependencies** secara berkala untuk security patches
-   **Test di staging** sebelum deploy ke production
-   **Database passwords** harus strong dan berbeda dari default
-   **Keep .env secure** - jangan commit ke git!
-   **Update Nginx** image secara berkala untuk security patches

## 🔗 Useful Links

-   [Laravel Documentation](https://laravel.com/docs)
-   [Docker Documentation](https://docs.docker.com/)
-   [Nginx Documentation](https://nginx.org/en/docs/)
-   [MySQL Documentation](https://dev.mysql.com/doc/)
-   [Docker Compose](https://docs.docker.com/compose/)

---

## 🎉 Selamat!

Aplikasi Laravel Anda sekarang sudah running di production dengan:

-   ✅ Docker containerization
-   ✅ Nginx latest version
-   ✅ External MySQL database connection
-   ✅ Production-optimized configuration
-   ✅ Backup & restore capabilities
-   ✅ HTTP access on port 80

**Access your application at:**
-   Via IP: `http://your-vps-ip`
-   Via Domain: `http://yourdomain.com` (if configured)

Untuk bantuan lebih lanjut, cek logs: `docker compose logs -f`
