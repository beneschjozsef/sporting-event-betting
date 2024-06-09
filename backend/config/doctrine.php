<?php

return [
    'meta' => [
        'entity_paths' => [
            base_path('app/Entities')
        ],
        'auto_generate_proxies' => true,
        'proxy_dir' => null,
        'proxy_namespace' => null,
        'annotation_reader' => null,
    ],
    'connections' => [
        'default' => [
            'driver' => env('DB_DRIVER', 'pdo_mysql'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 3306),
            'dbname' => env('DB_DATABASE', 'homestead'),
            'user' => env('DB_USERNAME', 'homestead'),
            'password' => env('DB_PASSWORD', 'secret'),
            'charset' => 'utf8',
        ],
    ],
    'cache' => [
        'second_level' => [
            'enabled' => false,
            'driver' => 'array',
            'namespace' => 'dc2',
        ],
    ],
    'migrations' => [
        'directory' => base_path('database/migrations'),
        'namespace' => 'Database\\Migrations',
        'table' => 'migrations',
        'version_column' => 'version',
    ],
];
