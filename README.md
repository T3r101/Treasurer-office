# Treasurer's Office

A Laravel web application for managing transactions, deposits, user accounts, and generating reports for a Treasurer's Office.

## Features

- **Transactions Management**: Add, edit, view, and delete income and expense transactions with search functionality.
- **Deposits Management**: Manage deposits with full CRUD operations and search.
- **User Management**: Admin panel for managing user accounts with role-based access (Admin/User).
- **Reports**: Generate summary reports and printable reports.
- **Authentication**: Secure login and registration using Laravel Breeze.
- **Modern UI**: Clean, responsive interface built with Tailwind CSS.

## Requirements

- PHP 8.3 or higher
- Composer
- Node.js and npm
- SQLite (or MySQL/PostgreSQL)

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd treasurers-office
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file and configure:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Run database migrations:
   ```bash
   php artisan migrate
   ```

6. Build assets:
   ```bash
   npm run build
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

- Register a new account or login.
- Access the dashboard to navigate to different modules.
- Admins can manage users via Account Management.
- Generate and print reports from the Reports section.

## Database Schema

- **users**: Stores user information with role (admin/user).
- **transactions**: Records income and expense transactions.
- **deposits**: Records deposit entries.
- **migrations**: Laravel migration files for schema management.

## Technologies Used

- **Laravel**: PHP framework for backend.
- **Tailwind CSS**: For styling.
- **SQLite**: Default database (configurable).
- **Laravel Breeze**: For authentication.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
