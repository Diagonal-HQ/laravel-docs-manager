<?php

return [
    'route_prefix' => env('DOCS_MANAGER_ROUTE_PREFIX', 'docs'),
    
    'middleware' => [
        'web',
    ],
    
    'enabled' => env('DOCS_MANAGER_ENABLED', app()->environment('local')),
];
