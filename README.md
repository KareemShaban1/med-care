# Medical Care E-Commerce System

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

A comprehensive Medical Care E-Commerce System built with Laravel framework. This application provides a simple solution for managing medical products, orders, categories, and more in a healthcare environment.

## ✨ Features

- **User Authentication & Authorization**
  - Secure login/logout functionality

- **Product Management**
  - Add, edit, and delete medical products
  - Track product inventory
  - Product categorization
  - Product activity logging

- **Order Management**
  - Create and manage orders
  - Order items tracking
  - Order status updates
  - Order history

- **Category Management**
  - Hierarchical category structure
  - Category-based product organization
  - Easy navigation

- **Banner Management**
  - Manage promotional banners
  - Control banner visibility

- **Activity Logging**
  - Track all system activities
  - User action history
  - Audit trail for important operations

- **Multi-language Support**
  - Built-in localization
  - Easy translation management

## 🚀 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Step 1: Clone the Repository

```bash
git clone https://github.com/KareemShaban1/med-care.git
cd medical-care
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Environment Setup

1. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```

2. Generate application key:
   ```bash
   php artisan key:generate
   ```

3. Configure your database in the `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=medical_care
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

### Step 4: Database Setup

1. Run migrations:
   ```bash
   php artisan migrate
   ```

2. Seed the database with initial data:
   ```bash
   php artisan db:seed
   ```

### Step 5: Storage Link

Create a symbolic link from `public/storage` to `storage/app/public`:

```bash
php artisan storage:link
```

### Step 6: Start the Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser to access the application.

## 🔐 Default Admin Credentials

- **Email:** admin@example.com
- **Password:** password


## 🔧 Built With

- [Laravel](https://laravel.com/) - The PHP Framework For Web Artisans
- [Laravel Breeze](https://laravel.com/docs/starter-kits) - Authentication scaffolding
- [Laravel DataTables](https://yajrabox.com/docs/laravel-datatables) - jQuery DataTables API for Laravel
- [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary) - Associate files with Eloquent models
- [Laravel Localization](https://github.com/mcamara/laravel-localization) - Easy localization for Laravel

