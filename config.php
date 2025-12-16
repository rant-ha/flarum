<?php

$appUrl = getenv('APP_URL');

// Database configuration: Prefer explicit vars, fallback to parsing JAWSDB_URL
$dbHost = getenv('DB_HOST');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');
$dbName = getenv('DB_NAME');
$dbPort = 3306;

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

return [
    'debug' => true,
    'database' => [
        'driver' => 'mysql',
        'host' => $dbHost ?? '127.0.0.1',
        'port' => $dbPort,
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
