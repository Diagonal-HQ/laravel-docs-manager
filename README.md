# Laravel Docs Manager

[![Latest Version on Packagist](https://img.shields.io/packagist/v/diagonal/laravel-docs-manager.svg?style=flat-square)](https://packagist.org/packages/diagonal/laravel-docs-manager)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/diagonal/laravel-docs-manager/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/diagonal/laravel-docs-manager/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/diagonal/laravel-docs-manager/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/diagonal/laravel-docs-manager/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/diagonal/laravel-docs-manager.svg?style=flat-square)](https://packagist.org/packages/diagonal/laravel-docs-manager)

A simple and elegant package to browse and view markdown files in your Laravel project through a web interface. Perfect for local development environments where you want to quickly access documentation, README files, and other markdown content directly from your browser.

The package automatically scans your project for markdown files and provides a clean, responsive interface to browse and read them with syntax highlighting and proper formatting.

## Installation

You can install the package via composer:

```bash
composer require diagonal/laravel-docs-manager
```

That's it! The package will automatically register itself and be ready to use in your local development environment.

## Usage

Once installed, the package automatically works out of the box. Simply visit `/docs` in your Laravel application to browse all markdown files in your project.

### Accessing the Docs Manager

- **Default URL**: `http://your-app.test/docs`
- **Automatic Discovery**: The package automatically scans your project for `.md` files
- **Local Environment Only**: By default, only enabled in local environments for security

### What You'll See

- A clean, responsive interface listing all markdown files in your project
- Organized file tree structure
- Syntax-highlighted markdown rendering
- Search and navigation capabilities

### Configuration (Optional)

The package works perfectly with zero configuration, but you can customize it if needed by publishing the config file:

```bash
php artisan vendor:publish --tag="laravel-docs-manager-config"
```

Available configuration options:

```php
return [
    // Route prefix (default: 'docs')
    'route_prefix' => env('DOCS_MANAGER_ROUTE_PREFIX', 'docs'),
    
    // Enable/disable the package (default: local environment only)
    'enabled' => env('DOCS_MANAGER_ENABLED', app()->environment('local')),
    
    // Base path to scan for markdown files
    'base_path' => env('DOCS_MANAGER_BASE_PATH', base_path()),
    
    // Directories to include in the scan
    'include_directories' => [''],
    
    // Directories to exclude from the scan
    'exclude_directories' => [
        'vendor', 'node_modules', '.git', 'storage/framework',
        'storage/logs', 'bootstrap/cache', 'public/build', 'public/hot'
    ],
    
    // File patterns to exclude
    'exclude_files' => ['.env*', '*.log', 'composer.lock', 'package-lock.json', 'yarn.lock'],
];
```

### Customizing Views (Optional)

If you want to customize the appearance, you can publish the views:

```bash
php artisan vendor:publish --tag="laravel-docs-manager-views"
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Diagonal](https://github.com/Diagonal-HQ)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
