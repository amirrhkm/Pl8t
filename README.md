# Staff Payroll and Shift Management System

This web application is designed to help F&B (Food & Beverage) managers efficiently manage staff schedules, track working hours, and calculate salaries. It's particularly useful for businesses with variable shift patterns and different pay rates for regular hours, overtime, and public holidays.

## Development Environment Setup

To set up the development environment for this project, follow these steps:

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL or MariaDB

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

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Create a copy of the `.env.example` file and rename it to `.env`:
   ```
   cp .env.example .env
   ```

5. Run database migrations:
   ```
   php artisan migrate
   ```

6. Seed the database with sample data (optional):
   ```
   php artisan db:seed
   ```

7. Start the development server:
    ```
    php artisan serve
    ```

The application should now be accessible at `http://localhost:8000`.

## Key Features

1. Staff Management
2. Shift Scheduling
3. Time Tracking
4. Salary Calculation
5. Reporting

## Use Cases for F&B Managers

### 1. Efficient Staff Scheduling

**Scenario:** A restaurant manager needs to create a weekly schedule for 20 staff members across different roles.

**How to use:**
- Access the scheduling module
- View available staff and their preferred working hours
- Drag and drop shifts to assign staff
- The system will alert you to any conflicts or overtime issues

**Benefits:** 
- Reduces time spent on creating schedules
- Helps avoid understaffing or overstaffing situations
- Ensures fair distribution of shifts among staff

### 2. Real-time Shift Tracking

**Scenario:** A cafe manager wants to monitor staff attendance and hours worked in real-time.

**How to use:**
- Staff clock in/out using the system
- Manager can view a live dashboard of who's currently working
- System flags any late arrivals or early departures

**Benefits:**
- Improves accountability
- Helps manage unexpected absences quickly
- Provides accurate data for payroll

### 3. Overtime Management

**Scenario:** A bar manager needs to keep track of overtime hours during a busy holiday season.

**How to use:**
- System automatically calculates regular and overtime hours
- View reports of overtime hours by employee or department
- Set alerts for when staff are approaching overtime thresholds

**Benefits:**
- Ensures compliance with labor laws
- Helps control labor costs
- Provides data for staffing decisions

### 4. Public Holiday Pay Calculation

**Scenario:** A hotel restaurant manager needs to calculate correct pay for staff working on public holidays.

**How to use:**
- Mark shifts as public holidays in the system
- System automatically applies the correct pay rate
- Generate reports showing public holiday hours and pay

**Benefits:**
- Ensures accurate and fair compensation
- Simplifies complex pay calculations
- Helps budget for increased labor costs on holidays

### 5. Payroll Preparation

**Scenario:** An F&B director needs to prepare monthly payroll for all staff across multiple outlets.

**How to use:**
- Access the payroll module at the end of the pay period
- System calculates total hours, including regular, overtime, and holiday pay
- Generate payroll reports for each employee and the entire organization

**Benefits:**
- Dramatically reduces time spent on payroll calculations
- Minimizes errors in salary calculations
- Provides detailed breakdowns for transparency

### 6. Performance Tracking

**Scenario:** A restaurant owner wants to identify top-performing staff and those who might need additional training.

**How to use:**
- Access individual staff reports
- View metrics such as punctuality, hours worked, and shift preferences
- Compare performance across teams or departments

**Benefits:**
- Helps in making informed decisions about promotions or role changes
- Identifies training needs
- Supports fair and data-driven performance reviews

## Conclusion

This F&B Staff Management System streamlines many of the time-consuming tasks involved in managing a food and beverage operation. By automating scheduling, time tracking, and payroll calculations, it allows managers to focus more on customer service, staff development, and overall business growth.