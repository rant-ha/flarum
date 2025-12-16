<?php

$jawsDbUrl = getenv('JAWSDB_URL');
$redisCloudUrl = getenv('REDISCLOUD_URL');
$appUrl = getenv('APP_URL');

$dbParts = $jawsDbUrl ? parse_url($jawsDbUrl) : [];
$redisParts = $redisCloudUrl ? parse_url($redisCloudUrl) : [];

return [
    'debug' => true,
    'database' => [
        'driver' => 'mysql',
        'host' => $dbParts['host'] ?? '127.0.0.1',
        'port' => $dbParts['port'] ?? 3306,
        'database' => isset($dbParts['path']) ? ltrim($dbParts['path'], '/') : 'flarum',
        'username' => $dbParts['user'] ?? 'root',
        'password' => $dbParts['pass'] ?? '',
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
            'host' => $redisParts['host'] ?? '127.0.0.1',
            'password' => $redisParts['pass'] ?? null,
            'port' => $redisParts['port'] ?? 6379,
            'database' => 0,
        ],
    ],
    'session' => [
        'driver' => 'redis',
        'cookie' => 'flarum_session',
        'lifetime' => 60,
    ],
    'url' => $appUrl ?: 'http://localhost',
    'paths' => [
        'api' => 'api',
        'admin' => 'admin',
    ],
    'headers' => [
        'poweredByHeader' => true,
        'referrerPolicy' => 'same-origin',
    ],
];
