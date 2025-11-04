## Hotel Human Resources Management System

This Laravel 12 application manages hotel employees, attendance, and payroll calculations. The UI follows the hotel brand palette (`#3338A0`, `#FCC61D`, `#FFFFFF`) and includes dedicated sections for each functional area.

### Features
- Employee CRUD with employment status tracking and pay-rate management.
- Attendance intake with per-employee deduplication and automatic hours-worked calculation.
- Payroll generator that derives gross/net pay from approved attendance for a period.
- MySQL-ready schema (`schema.sql`) for provisioning production databases.

### Prerequisites
- PHP 8.3+
- Composer 2.6+
- Node 18+ (for asset builds, if needed)
- MySQL 8.0+ (or MariaDB 10.5+) with a database named `hotel_hrms`

### Installation
1. Install dependencies:
   ```bash
   composer install
   npm install
   ```
2. Copy and adjust the environment file:
   ```bash
   cp .env .env.local
   ```
   Update `.env.local` (or `.env`) with your MySQL credentials. Default placeholders are:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hotel_hrms
   DB_USERNAME=root
   DB_PASSWORD=password
   ```
3. Generate an application key and run migrations:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```
4. Seed the default administrator account:
   ```bash
   php artisan db:seed
   ```

   Default credentials:
   - Email: `admin@hotel-hrms.test`
   - Password: `password123`

### schema.sql
The root-level `schema.sql` file contains a MySQL DDL script that mirrors all current migrations. Run it directly if you prefer manual schema provisioning:
```bash
mysql -u root -p < schema.sql
```

### Testing
Unit and feature tests use an in-memory SQLite database via `.env.testing`:
```bash
php artisan test
```

### Running the App
```bash
php artisan serve
```
Then browse to `http://localhost:8000` to access the dashboard.

### Authentication
- Login page: `http://localhost:8000/login`
- All HR management routes are protected by the `auth` middleware; sign in with the admin credentials above or create new users in the `users` table.
