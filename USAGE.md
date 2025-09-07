# Laravel Docs Manager - Usage

## Installation

Install the package via Composer:

```bash
composer require diagonal/laravel-docs-manager --dev
```

## Setup

Run the installation command:

```bash
php artisan docs-manager:install
```

That's it! No additional setup required.

## Usage

Visit `/docs` (or your configured route prefix) in your browser to see the docs manager interface.

## Configuration

The installation publishes a `config/docs-manager.php` file where you can configure:

- `route_prefix`: The URL prefix for the docs routes (default: 'docs')
- `middleware`: Middleware to apply to the routes (default: ['web'])
- `enabled`: Whether the package is enabled (default: only in local environment)

## Environment Variables

You can also configure the package using environment variables:

```env
DOCS_MANAGER_ROUTE_PREFIX=docs
DOCS_MANAGER_ENABLED=true
```

## Manual Installation (Advanced)

If you prefer manual setup or the automatic installation fails:

1. Install Inertia.js: `composer require inertiajs/inertia-laravel`
2. Install frontend deps: `npm install @inertiajs/react react react-dom`
3. Publish assets: `php artisan vendor:publish --tag="docs-manager-assets"`
4. Configure your `app.js` to resolve `DocsManager/*` components from `./vendor/laravel-docs-manager/Pages/`
5. Add `HandleInertiaRequests` middleware to your web group

## Development

The package is designed to be used primarily in development environments. By default, it's only enabled when `APP_ENV=local`.
