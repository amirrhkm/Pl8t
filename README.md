# Staff Payroll and Shift Management System

*outdated details, to-be-updated soon*

This web application is designed to help F&B (Food & Beverage) managers efficiently manage staff schedules, track working hours, and calculate salaries. It's particularly useful for businesses with variable shift patterns and different pay rates for regular hours, overtime, and public holidays.

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
   php artisan migrate
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

Available endpoints currently are:
- `/staff` - Staff Management Module
- `/staff/shift` - Payroll Management Module
- `/shift` - Shift Management Module
