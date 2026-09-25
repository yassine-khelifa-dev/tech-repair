# Tech Repair Backend

Tech Repair is a Laravel backend for a repair shop workflow.
It covers the internal admin panel, the device catalog, dynamic model configuration, customer repair requests, repair tickets, logs, notifications, and the API consumed by the React customer app.

The core of the project is the catalog architecture. A repair shop can define brands, categories, attributes, attribute options, and device models. Each model can then be configured with only the options it actually supports. That keeps ticket creation and customer requests precise: users do not see every option stored in the database, only the options allowed for the selected model.

## Project Links

- Backend repository: https://github.com/yassine-khelifa-dev/tech-repair
- Frontend repository: https://github.com/yassine-khelifa-dev/tech-repair-frontend

The backend and frontend are deployed separately. Runtime URLs and server paths are intentionally kept out of this repository.

## Stack
- Laravel
- Blade
- MySQL
- Eloquent ORM
- Form Requests
- Laravel notifications
- Laravel queues/jobs
- Vite
- Tailwind CSS

## Main Features
- Admin authentication
- Device brand management
- Device category management
- Dynamic specification attributes and options
- Device model configuration with allowed options
- Customer repair request review
- Repair ticket creation and tracking
- Repair logs and internal notes
- Customer/admin notifications
- API endpoints for the React frontend

## Dynamic Catalog Model

The catalog is built to avoid hardcoding device specifications into the ticket form.

Example:

1. Create a category: `Smartphone`.
2. Assign attributes to the category: `Color`, `RAM`, `Storage`.
3. Add many possible options: `Blue`, `White`, `Black`, `8GB`, `12GB`, `256GB`, `512GB`.
4. Create a model: `iPhone 17 Pro Max`.
5. Configure that model with only the valid options, for example `Blue`, `White`, `8GB`, `256GB`, `512GB`.
6. When creating a request or ticket for that model, only those configured options are available.

This design keeps the database flexible while keeping the user interface focused and clean.

## Data Relationships

```text
Brand
  has many Device Models

Device Category
  has many Specification Attributes

Specification Attribute
  has many Specification Options

Device Model
  belongs to Brand
  belongs to Device Category
  has many allowed Specification Options

Repair Request
  stores customer details, selected model, selected options, issue description, and images

Repair Ticket
  stores approved/manual repairs, status, customer/device details, logs, and repair progress
```

## Web Routes

```text
GET     /                       Welcome page
GET     /login                  Login page
POST    /login                  Authenticate user
POST    /logout                 Sign out

GET     /dashboard              Admin dashboard

GET     /brand                  Brand list
GET     /devicetype             Category list
GET     /spec-attribute         Attribute list
GET     /devicemodel            Device model list

GET     /device-models/{model}/configuration
PUT     /device-models/{model}/configuration

GET     /repair-requests
GET     /repair-requests/{request}/review
POST    /repair-requests/{request}/review

GET     /repair-tickets
GET     /repair-tickets/create
GET     /repair-tickets/{ticket}
GET     /repair-tickets/{ticket}/edit
```

## API Routes

These routes are consumed by the React frontend:

```text
GET     /api/device-types
GET     /api/brands
GET     /api/device-models
GET     /api/device-models/{device_model}/attributes
POST    /api/repair-request/create
```

## Local Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

Configure `.env` with your local database and mail settings:

```env
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## Production Notes

Use environment variables for production configuration. Do not commit real domains, server paths, database credentials, mail credentials, API keys, or deployment-specific secrets.

Typical production commands:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan view:cache
php artisan route:clear
```

## Related Frontend

The customer-facing React app lives in a separate repository:

https://github.com/yassine-khelifa-dev/tech-repair-frontend

It uses this backend through an environment variable:

```env
VITE_API_BASE_URL=https://your-backend-domain.example/api
```
