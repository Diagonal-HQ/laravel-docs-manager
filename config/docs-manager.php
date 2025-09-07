<?php

return [
    'route_prefix' => env('DOCS_MANAGER_ROUTE_PREFIX', 'docs'),

    'middleware' => [
        'web',
    ],

    'enabled' => env('DOCS_MANAGER_ENABLED', app()->environment('local')),

    // Base path to scan for markdown files (defaults to Laravel project root)
    'base_path' => env('DOCS_MANAGER_BASE_PATH', base_path()),

    // Directories to include in the scan (relative to base_path)
    // Note: Using '' (empty string) scans the entire project root
    'include_directories' => [
        '', // Scan entire project root
    ],

    // Directories to exclude from the scan
    'exclude_directories' => [
        'vendor',
        'node_modules',
        '.git',
        'storage/framework',
        'storage/logs',
        'bootstrap/cache',
        'public/build',
        'public/hot',
    ],

    // File patterns to exclude
    'exclude_files' => [
        '.env*',
        '*.log',
        'composer.lock',
        'package-lock.json',
        'yarn.lock',
    ],
];
