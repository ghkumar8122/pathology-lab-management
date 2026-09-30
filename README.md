# Pathology Lab Management System

A PHP + MySQL web application for managing a pathology lab with patient records, test orders, reports, and billing.

## Features

- Secure admin login
- Patient registration and search
- Lab test catalog management
- Test ordering and tracking
- Report management
- Billing summary dashboard
- Modern responsive UI

## Tech Stack

- PHP 8+
- MySQL
- PDO for database access
- HTML/CSS/JavaScript

## Project Structure

- `config/` - Database and app configuration
- `includes/` - Shared layout and auth helpers
- `database/` - Schema and seeding scripts
- `assets/` - CSS and JS files
- Root PHP pages for dashboard and management modules

## Quick Start

1. Start Apache and MySQL.
2. Update your MySQL credentials in `config/db.php` if needed.
3. Visit the project in your browser, for example:
   - `http://localhost/pathology-lab-management/`
4. Login with the default admin account:
   - Username: `admin`
   - Password: `admin123`

## Default Database Behavior

The app will automatically create the database and tables if they do not exist.

## Notes

This is a starter application ready for extension with:
- doctor dashboards
- patient login portals
- PDF report export
- notifications and email alerts
- barcode integration

## License

MIT
