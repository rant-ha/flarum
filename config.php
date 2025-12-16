<?php

$dbUrl = parse_url(getenv('JAWSDB_URL'));
$redisUrl = parse_url(getenv('REDISCLOUD_URL'));

return [
    'debug' => getenv('APP_DEBUG') === 'true',
    'database' => [
        'driver' => 'mysql',
        'host' => $dbUrl['host'],
        'port' => $dbUrl['port'] ?? 3306,
        'database' => ltrim($dbUrl['path'], '/'),
        'username' => $dbUrl['user'],
        'password' => $dbUrl['pass'],
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => false,
        'engine' => 'InnoDB',
        'prefix_indexes' => true,
    ],
    'redis' => [
        'client' => 'phpredis',
        'default' => [
            'host' => $redisUrl['host'],
            'password' => $redisUrl['pass'],
            'port' => $redisUrl['port'],
            'database' => 0,
        ],
    ],
    'session' => [
        'driver' => 'redis',
        'cookie' => 'flarum_session',
        'lifetime' => 60,
    ],
    'url' => getenv('APP_URL'),
    'paths' => [
        'api' => 'api',
        'admin' => 'admin',
    ],
    'headers' => [
        'poweredByHeader' => true,
        'referrerPolicy' => 'same-origin',
    ],
];
