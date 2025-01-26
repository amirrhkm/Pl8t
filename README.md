# Pl8t: F&B Business Admin Dashboard

## Overview
Pl8t is a comprehensive administrative dashboard designed specifically for F&B businesses, offering integrated modules for staff management, payroll processing, inventory control, and sales tracking.

| **Admin Dashboard** |
|-----------------------|
| ![Admin Dashboard](https://github.com/user-attachments/assets/f7ac6b4f-b135-4f67-bcc9-707cee49b2f0) |

| **Report Dashboard** | **Inventory Dashboard** | **Payroll Dashboard** |
|----------------------|-------------------------|------------------------|
| ![Report Dashboard](https://github.com/user-attachments/assets/b4b37059-3c40-41d7-8d74-af0c42ad6398) | ![Inventory Dashboard](https://github.com/user-attachments/assets/03f53edc-ba1f-4897-9fa4-2a65d5d643a5) | ![Payroll Dashboard](https://github.com/user-attachments/assets/8dc0c402-f450-4001-a0cf-666ada2dc5b6) |

| **Sales Dashboard** | **Shift Dashboard** | **Staff Dashboard** |
|----------------------|---------------------|----------------------|
| ![Sales Dashboard](https://github.com/user-attachments/assets/0825d532-6591-4ec0-b22c-ef62f63b313f) | ![Shift Dashboard](https://github.com/user-attachments/assets/b1c6f77b-e953-4838-aab7-eda0c9941e47) | ![Staff Dashboard](https://github.com/user-attachments/assets/49b33759-d9c6-4180-97aa-784cd1af4397) |

## Core Modules

### 1. Staff Management
- Employee information management
- Role-based access control (RBAC)
- Staff scheduling and shift assignment

### 2. Payroll Processing
- Automated salary calculations
- Working hours integration
- Rate-based compensation management

### 3. Shift Management
- Dynamic schedule creation
- Working hours tracking
- Real-time shift updates

### 4. Inventory Control
- Stock level monitoring
- Delivery order management
- Wastage tracking and reporting

### 5. Sales Management
- Daily sales reporting
- Monthly performance analytics
- Expense tracking
- End-of-day (EOD) reconciliation

### 6. Business Intelligence
- Profit and loss analysis
- Stock turnover metrics
- Performance dashboards
- Custom reporting tools

## Key Features
- Integrated shift-payroll automation
- Real-time inventory tracking
- Comprehensive sales analytics
- Centralized dashboard metrics
- Automated financial calculations

## Technical Architecture

### Technology Stack
- **Backend Framework:** Laravel 11
- **PHP Version:** 8.1
- **Package Manager:** Composer 2
- **Database:** MySQL
- **Frontend:** 
  - Blade templating engine
  - Tailwind CSS
- **Server:** 
  - Nginx
  - PHP-FPM

### Production Environment
- **Domain Management:** AWS Route 53
- **Hosting:** Hostinger VPS
- **Server Configuration:**
  - Nginx config: `/etc/nginx/sites-available/pl8t-server.conf`
  - PHP-FPM pool: `/etc/php/8.1/fpm/pool.d/laravel.conf`
- **Production URL:** `http://pl8t.click`
- **Database:** Local VPS SSD storage

## Infrastructure Overview
![Infrastructure Diagram](https://github.com/user-attachments/assets/a6e37c6d-3bea-43a0-af2c-b98498f43cd8)

Pl8t operates on a VPS infrastructure with AWS Route 53 managing DNS, directing traffic to Hostinger VPS via A Records. Nginx handles request routing with PHP-FPM managing process execution.

## Development Setup

### Prerequisites
- PHP 8.1+
- Composer 2
- SQLite

### Installation Steps

1. **Clone Repository**
   ```bash
   git clone https://github.com/amirrhkm/Pl8t.git
   cd Pl8t
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   Configure SQLite database:
   ```env
   DB_CONNECTION=sqlite
   ```

4. **Database Setup**
   ```bash
   php artisan migrate:fresh
   ```

5. **Seed Initial Data**
   ```bash
   php artisan db:seed
   ```

6. **Application Key**
   ```bash
   php artisan key:generate
   ```

7. **Launch Development Server**
   ```bash
   php artisan serve
   ```

Access the development environment at `http://localhost:8000`

## Database Management
For database visualization and management, use TablePlus and import the `database.sqlite` file from the `database` directory.


