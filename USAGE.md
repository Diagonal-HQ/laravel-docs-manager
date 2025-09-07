# Laravel Docs Manager - Usage

## Installation

Install the package via Composer:

```bash
composer require diagonal/laravel-docs-manager --dev
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag="docs-manager-config"
```

This will publish a `config/docs-manager.php` file where you can configure:

- `route_prefix`: The URL prefix for the docs routes (default: 'docs')
- `middleware`: Middleware to apply to the routes (default: ['web'])
- `enabled`: Whether the package is enabled (default: only in local environment)

## Frontend Assets

If you're using Inertia.js with React, publish the frontend assets:

```bash
php artisan vendor:publish --tag="docs-manager-assets"
```

This will publish the React components to `resources/js/vendor/laravel-docs-manager/`.

## Usage

Once installed and configured, visit `/docs` (or your configured route prefix) in your browser to see the docs manager interface.

## Environment Variables

You can also configure the package using environment variables:

```env
DOCS_MANAGER_ROUTE_PREFIX=docs
DOCS_MANAGER_ENABLED=true
```

## Development

The package is designed to be used primarily in development environments. By default, it's only enabled when `APP_ENV=local`.
