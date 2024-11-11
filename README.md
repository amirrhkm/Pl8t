# TallyUp - F&B Business Admin Dashboard

## Overview
TallyUp is a comprehensive administrative dashboard designed specifically for F&B businesses, offering integrated modules for staff management, payroll processing, inventory control, and sales tracking.

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
  - Nginx config: `/etc/nginx/sites-available/tallyup-server.conf`
  - PHP-FPM pool: `/etc/php/8.1/fpm/pool.d/laravel.conf`
- **Production URL:** `http://tallyup.click`
- **Database:** Local VPS SSD storage

## Infrastructure Overview
![Infrastructure Diagram](https://github.com/user-attachments/assets/a6e37c6d-3bea-43a0-af2c-b98498f43cd8)

TallyUp operates on a VPS infrastructure with AWS Route 53 managing DNS, directing traffic to Hostinger VPS via A Records. Nginx handles request routing with PHP-FPM managing process execution.

## Development Setup

### Prerequisites
- PHP 8.1+
- Composer 2
- SQLite

### Installation Steps

1. **Clone Repository**
   ```bash
   git clone https://github.com/amirrhkm/tally-up.git
   cd tally-up
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


