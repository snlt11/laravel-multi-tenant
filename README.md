# Laravel Multi-Tenant Application

A robust multi-tenant Laravel application built using the stancl/tenancy package, providing complete database isolation for each tenant.

## Overview

This application implements a multi-tenancy architecture where each tenant has its own isolated database. The system allows for tenant creation, user management within each tenant, and provides a complete API for both central and tenant-specific operations.

## Features

- **Multi-database Tenancy**: Each tenant gets its own isolated database
- **Domain-based Tenant Identification**: Tenants are identified by their domain
- **Central Administration**: Manage tenants from a central application
- **Tenant-specific User Management**: Each tenant has its own user system
- **API Authentication**: Secure API endpoints using Laravel Sanctum
- **Tenant-specific API Routes**: Separate API routes for tenant operations

## Architecture

### Central Application

The central application manages tenants and their domains. It provides API endpoints for:

- Creating new tenants
- Listing existing tenants and their domains

### Tenant Applications

Each tenant has its own isolated environment with:

- User management system
- Authentication system using Laravel Sanctum
- API endpoints for tenant-specific operations

## Technical Stack

- **PHP 8.4+**
- **Laravel 12.0**
- **stancl/tenancy 3.9**: For multi-tenancy implementation
- **Laravel Sanctum**: For API authentication

## Directory Structure

Key components of the application:

- **app/Models/Tenant.php**: Tenant model extending the stancl/tenancy base tenant
- **app/Models/User.php**: User model for tenant-specific users
- **app/Http/Controllers/TenantController.php**: Manages tenant creation and listing
- **app/Http/Controllers/AuthController.php**: Handles tenant-specific authentication
- **app/Http/Controllers/UserController.php**: Manages tenant-specific user operations
- **app/Providers/TenancyServiceProvider.php**: Configures tenancy events and routing
- **config/tenancy.php**: Configuration for the tenancy system
- **routes/api.php**: Central API routes
- **routes/tenant_api.php**: Tenant-specific API routes
- **routes/tenant.php**: Tenant-specific web routes

## API Endpoints

### Central API

- `GET /tenants`: List all tenants with their domains
- `POST /tenants`: Create a new tenant with a domain

### Tenant API

- `POST /api/register`: Register a new user in the tenant
- `POST /api/login`: Login a user and get an authentication token
- `GET /api/me`: Get the authenticated user's information
- `POST /api/logout`: Logout the authenticated user
- `GET /api/users`: List all users (with pagination and search)
- `POST /api/users`: Create a new user
- `GET /api/users/{id}`: Get a specific user
- `PUT /api/users/{id}`: Update a user
- `DELETE /api/users/{id}`: Delete a user

## Database Structure

### Central Database

- **tenants**: Stores tenant information
- **domains**: Maps domains to tenants

### Tenant Databases

Each tenant has its own database with the following tables:

- **users**: Tenant-specific users
- **personal_access_tokens**: For API authentication
- **password_reset_tokens**: For password reset functionality
- **sessions**: For session management
- **cache**: For caching
- **jobs**: For queue processing

## Getting Started

1. Clone the repository
2. Install dependencies with `composer install`
3. Copy `.env.example` to `.env` and configure your database settings
4. Run migrations for the central database: `php artisan migrate`
5. Create a tenant: `POST /tenants` with `id` and `domain` parameters
6. Access the tenant application through the configured domain

## Development

### Creating a New Tenant

```bash
curl -X POST http://localhost/tenants \
  -H "Content-Type: application/json" \
  -d '{"id":"one","domain":"one.localhost"}'
```

### Accessing Tenant API

```bash
# Register a user
curl -X POST http://one.localhost/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password","password_confirmation":"password"}'

# Login
curl -X POST http://one.localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password"}'
```

## License

This project is open-sourced software licensed under the MIT license.