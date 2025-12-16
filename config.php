<?php

$appUrl = getenv('APP_URL');

// Database configuration: Prefer explicit vars, fallback to parsing JAWSDB_URL
$dbHost = getenv('DB_HOST');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');
$dbName = getenv('DB_NAME');

if (!$dbHost && getenv('JAWSDB_URL')) {
    $dbParts = parse_url(getenv('JAWSDB_URL'));
    if ($dbParts) {
        $dbHost = $dbParts['host'] ?? null;
        $dbUser = $dbParts['user'] ?? null;
        $dbPass = $dbParts['pass'] ?? null;
        $dbName = isset($dbParts['path']) ? ltrim($dbParts['path'], '/') : null;
        $dbPort = $dbParts['port'] ?? 3306;
    }
}

// Redis configuration
$redisUrl = getenv('REDISCLOUD_URL');
$redisParts = $redisUrl ? parse_url($redisUrl) : [];
if ($redisParts === false) {
    $redisParts = [];
}

return [
    'debug' => true,
    'database' => [
        'driver' => 'mysql',
        'host' => $dbHost ?? '127.0.0.1',
        'port' => $dbPort ?? 3306,
        'database' => $dbName ?? 'flarum',
        'username' => $dbUser ?? 'root',
        'password' => $dbPass ?? '',
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
