# 🍽️ Warung Bali Sangeh - Order System

A modern, mobile-first food ordering system built with Laravel 12 and Tailwind CSS 4. This application provides a seamless ordering experience for restaurant customers with support for dine-in and takeaway orders.

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.0-06B6D4?style=flat&logo=tailwindcss)
![License](https://img.shields.io/badge/License-MIT-green.svg)

---

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Screenshots](#-screenshots)
- [Installation](#-installation)
- [Usage](#-usage)
- [Project Structure](#-project-structure)
- [Theme Documentation](#-theme-documentation)
- [Routes](#-routes)
- [Development](#-development)
- [Contributing](#-contributing)
- [License](#-license)

---

## ✨ Features

### 🛒 Order Management
- **Dine-In & Takeaway Support** - Choose between dining in or taking away
- **Table Management** - Table number assignment for dine-in orders
- **Real-time Cart** - Add, remove, and update items with instant feedback
- **Persistent Cart** - Cart data persists using localStorage

### 💳 Payment System
- **Multiple Payment Methods**
  - QRIS (Quick Response Indonesian Standard)
  - Pay at Cashier
- **Payment Timer** - Countdown timer for QRIS payments
- **Order Confirmation** - QR code and order number for cashier verification

### 🎨 User Interface
- **Mobile-First Design** - Optimized for mobile devices (max-width: 500px)
- **Modern UI/UX** - Clean, intuitive interface with smooth animations
- **Category Navigation** - Sticky navigation with scroll spy
- **Real-time Updates** - Dynamic price calculations and cart updates

### 📱 Additional Features
- **Customer Information** - Name, phone, email capture
- **Order Notes** - Add special instructions to orders
- **Related Menu Suggestions** - Cross-selling recommendations
- **Responsive Images** - Optimized menu item images
- **Profile Management** - User profile and order history

---

## 🛠️ Tech Stack

### Backend
- **Laravel 12** - PHP framework
- **PHP 8.2+** - Server-side language
- **SQLite** - Database (for development)

### Frontend
- **Tailwind CSS 4** - Utility-first CSS framework
- **Vite 7** - Build tool and dev server
- **JavaScript (Vanilla)** - Client-side interactions
- **Outfit Font** - Google Fonts typography

### Tools & Libraries
- **Laravel Sail** - Docker development environment
- **Laravel Pint** - Code style fixer
- **Laravel Tinker** - REPL for Laravel
- **Concurrently** - Run multiple commands simultaneously

---

## 📸 Screenshots

*Coming soon - Add screenshots of your application here*

---

## 🚀 Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- NPM or Yarn

### Quick Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd warung-bali-sangeh
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

   Visit: `http://localhost:8000`

### Alternative: One-Command Setup

```bash
composer setup
```

This runs all setup commands automatically.

### Development Mode

Run the full development stack (server + queue + logs + vite):

```bash
composer dev
```

This starts:
- Laravel development server (port 8000)
- Queue worker
- Application logs (Pail)
- Vite dev server (hot reload)

---

## 📖 Usage

### Customer Flow

1. **Select Order Mode** (`/mode`)
   - Choose between Dine In or Pick Up

2. **Browse Menu** (`/order`)
   - View categorized menu items (Food & Drinks)
   - Add items to cart
   - For dine-in: Enter table number

3. **Review Order** (`/view-order`)
   - Review cart items
   - Adjust quantities
   - Add order notes
   - View payment breakdown

4. **Payment** (`/payment`)
   - Enter customer information
   - Choose payment method (QRIS or Cashier)

5. **Confirmation**
   - **QRIS**: Scan QR code to complete payment (`/qris-confirmation`)
   - **Cashier**: Show QR code to cashier (`/cashier-confirmation`)

---

## 📁 Project Structure

```
warung-bali-sangeh/
├── app/
│   ├── Http/Controllers/      # Application controllers
│   ├── Models/                # Eloquent models
│   └── Providers/             # Service providers
├── database/
│   ├── migrations/            # Database migrations
│   ├── factories/             # Model factories
│   └── seeders/               # Database seeders
├── public/
│   └── images/                # Menu images and assets
├── resources/
│   ├── css/                   # Tailwind CSS files
│   ├── js/                    # JavaScript files
│   └── views/                 # Blade templates
│       ├── welcome.blade.php           # Landing page
│       ├── mode.blade.php              # Order mode selection
│       ├── order.blade.php             # Menu browsing
│       ├── view-order.blade.php        # Cart review
│       ├── payment.blade.php           # Payment page
│       ├── qris-confirmation.blade.php # QRIS payment
│       ├── cashier-confirmation.blade.php # Cashier payment
│       └── profile.blade.php           # User profile
├── routes/
│   └── web.php                # Web routes
├── tests/                     # PHPUnit tests
├── theme.md                   # Theme documentation
└── README.md                  # This file
```

---

## 🎨 Theme Documentation

Complete theme documentation is available in [`theme.md`](theme.md).

### Key Colors

| Color | Hex | Usage |
|-------|-----|-------|
| Primary Orange | `#f05a28` | Buttons, CTAs, brand |
| Primary Hover | `#d94a1c` | Button hover states |
| Red Accent | `#ef4444` | Active nav, add buttons |
| Background | `#f3f4f6` | Page background |
| Text Dark | `#1b1b18` | Headings, primary text |

### Typography
- **Font Family**: Outfit (Google Fonts)
- **Weights**: 300, 400, 500, 600, 700

For complete documentation, see [`theme.md`](theme.md).

---

## 🛣️ Routes

| Route | View | Description |
|-------|------|-------------|
| `/` | `welcome.blade.php` | Landing page |
| `/mode` | `mode.blade.php` | Select order mode |
| `/order` | `order.blade.php` | Browse menu & add to cart |
| `/view-order` | `view-order.blade.php` | Review cart & order details |
| `/payment` | `payment.blade.php` | Payment method selection |
| `/qris-confirmation` | `qris-confirmation.blade.php` | QRIS payment confirmation |
| `/cashier-confirmation` | `cashier-confirmation.blade.php` | Cashier payment confirmation |
| `/profile` | `profile.blade.php` | User profile |

### Query Parameters

- `?mode=dinein|takeaway` - Order mode
- `?table=<number>` - Table number for dine-in

---

## 💻 Development

### Running Tests

```bash
composer test
# or
php artisan test
```

### Code Style

Format code with Laravel Pint:

```bash
./vendor/bin/pint
```

### Build for Production

```bash
npm run build
```

### Clear Caches

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🎯 Key Features Implementation

### Cart Management
- Implemented using JavaScript and localStorage
- Persists across page navigations
- Real-time price calculations

### Payment Flow
- Two payment methods: QRIS and Cashier
- Customer information validation
- Dynamic order type handling

### Responsive Design
- Mobile-first approach (max-width: 500px)
- Touch-friendly interfaces
- Smooth transitions and animations

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Use Laravel best practices
- Write meaningful commit messages
- Add tests for new features

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👥 Credits

Built with ❤️ using:
- [Laravel](https://laravel.com) - The PHP Framework
- [Tailwind CSS](https://tailwindcss.com) - Utility-first CSS Framework
- [Vite](https://vitejs.dev) - Next Generation Frontend Tooling
- [Heroicons](https://heroicons.com) - Beautiful hand-crafted SVG icons

---

## 📞 Support

For support, email support@example.com or open an issue in the repository.

---

**Last Updated**: December 19, 2025
