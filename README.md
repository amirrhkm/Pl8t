# Admin Dashboard for F&B Business

### Modules included:

1. **Staff** (Employee Management and Role-Based Access Control)
2. **Payroll** (Auto-calculate based on working hours and rate)
3. **Shift** (Working Hours and Schedule)
4. **Inventory** (Stock, Delivery Order and Wastage)
5. **Sales** (POS, Daily Sales Report, Monthly Sales Report, Expenses and EOD)
6. **Report** (Earning and Loss, Stock Turnover, etc.)

### Highlighted Features:

- Assign shift to staff which directly update staff payroll
- Auto-calculate payroll based on working hours and rate
- Track inventory stock, delivery order and wastage
- Sales cash tracking and report
- Dashboard with simple metrics for monitoring overview

### Tech Stack:

- Laravel 11 (PHP 8.1 and Composer 2)
- MySQL
- Blade
- Tailwind CSS
- Nginx & PHP-FPM

### Production Environment:

- Setup Nginx server block in `/etc/nginx/sites-available/tallyup-server.conf`
- Setup PHP-FPM pool in `/etc/php/8.1/fpm/pool.d/laravel.conf`
- Server running on `http://tallyup.click`
- Server hosted on VPS with Hostinger
- DNS and HostedZone managed by AWS Route 53
- Database on VPS local disk (SSD)

## Environment Overview
TallyUp is a VPS service. Domain name is managed by AWS Route 53 with A Record pointing to Hostinger VPS Public IP and Nginx redirect to PHP-FPM for managing process and script execution.

![env-overview](./public/tallyup-env-overview-dark.png)

## Development Environment Setup

To set up the development environment for this project, follow these steps:

### Prerequisites

- PHP 8.1 or higher
- Composer 2
- SQLite

### Installation

1. Clone the repository:
   ```
   git clone https://github.com/amirrhkm/tally-up.git
   cd tally-up
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Create a copy of the `.env.example` file and rename it to `.env`, and make sure to set the correct database configuration to use `sqlite`:
   ```
   cp .env.example .env
   ```
   ```.env
   DB_CONNECTION=sqlite
   ```

4. Run database migrations, to view the database, setup `TablePlus` and import the `database.sqlite` file from the `database` folder:
   ```
   php artisan migrate:fresh
   ```

6. Seed the database with sample data, this will create shift handler for the UI interface (required):
   ```
   php artisan db:seed
   ```

7. Generate a new application key:
   ```
   php artisan key:generate
   ```

8. Start the development server:
    ```
    php artisan serve
    ```

The application should now be accessible at `http://localhost:8000`.
