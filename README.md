# ClearLedger Tax & Advisory

A responsive Laravel application for a tax services firm. Customers can explore services, create an account, request appointments, track service requests, update their profile, and securely upload/download/delete their documents. Staff can manage services, appointments, requests, and customer accounts in a role-protected admin dashboard.

## Requirements

- PHP 8.3+ with the PDO MySQL extension (SQLite can be used for local development)
- Composer 2
- MySQL 8+ (or SQLite)
- Node.js is optional; the application uses a static stylesheet and CDN-hosted Bootstrap

## Setup

1. Copy `.env.example` to `.env` and set `APP_KEY` by running `php artisan key:generate`.
2. Create a MySQL database named `clearledger`, then set `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`.
3. Optionally configure a staff account in `.env`:

   ```dotenv
   ADMIN_NAME="ClearLedger Admin"
   ADMIN_EMAIL=admin@gmail.com
   ADMIN_PASSWORD=use-a-unique-long-password
   ```

4. Install dependencies and initialize the database:

   ```bash
   composer install
   php artisan migrate --seed
   ```

5. Start the local server:

   ```bash
   php artisan serve
   ```

   Visit `http://127.0.0.1:8000`. Configure an SMTP provider in `.env` before sending real customer communications. For a local SQLite setup, create `database/database.sqlite` and set `DB_CONNECTION=sqlite` and `DB_DATABASE=database/database.sqlite`.

The database seeder creates five sample tax services. It creates an administrator only when both `ADMIN_EMAIL` and `ADMIN_PASSWORD` are configured. Never use development credentials in a production environment.

Sample service prices are stored and displayed in LKR. The starter prices were converted from the original sample USD amounts using an illustrative rate of LKR 300 per USD; adjust them to your actual local pricing before launch.

## Application structure

- `app/Models` — users, tax services, appointments, customer documents, and service requests.
- `app/Http/Controllers` — public pages, authentication, customer account actions, and admin CRUD/status workflows.
- `app/Http/Middleware/AdminMiddleware.php` — server-side admin role check.
- `routes/web.php` — named routes, guest/authentication boundaries, login throttling, and admin route group.
- `database/migrations` — relational schema and foreign-key constraints.
- `database/seeders/DatabaseSeeder.php` — sample service catalog and optional environment-configured admin.
- `resources/views` — Blade templates for the marketing site, authentication, booking, customer dashboard, and admin dashboard.
- `public/css/app.css` and `public/css/modern.css` — responsive styling and the current visual theme.
- `public/images/` — locally stored decorative illustrations used by the home, about, and authentication pages.

Uploaded customer files are stored on Laravel's private local disk and served only through an authenticated, ownership-checked download route. Accepted formats are PDF, JPG/PNG, and DOC/DOCX, with a 10 MB per-file limit.

## Main flows

- Public catalog: `/` and `/services`
- Customer authentication: `/register`, `/login`
- Appointment booking: `/book` (requires login)
- Customer dashboard: `/dashboard` (requires login)
- Staff dashboard: `/admin` (requires an authenticated user with the `admin` role)

## Tests

```bash
php artisan test
```

The feature tests cover public service pages, authenticated appointment booking, private document ownership, and admin access/status updates.

## Screenshots

Example responsive application screenshots are included in [`screenshots/`](screenshots/):

- `home.png` — home page
- `services.png` — service catalog
- `customer-dashboard.png` — customer account, appointment, and service-request status
- `admin-dashboard.png` — admin overview

To reproduce the dashboard screenshots, register a customer account and configure an admin account as described above.
