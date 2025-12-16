<?php
return [
    'debug' => false,
    'database' => [
        'driver'    => 'mysql',
        'host'      => getenv('DB_HOST') ?: getenv('JAWSDB_HOST') ?: getenv('CLEARDB_HOST') ?: 'localhost',
        'database'  => getenv('DB_NAME') ?: getenv('JAWSDB_DATABASE') ?: getenv('CLEARDB_DATABASE') ?: '',
        'username'  => getenv('DB_USER') ?: getenv('JAWSDB_USERNAME') ?: getenv('CLEARDB_USERNAME') ?: '',
        'password'  => getenv('DB_PASS') ?: getenv('JAWSDB_PASSWORD') ?: getenv('CLEARDB_PASSWORD') ?: '',
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'    => '',
    ],
    'url' => getenv('APP_URL') ?: 'https://your-heroku-app.herokuapp.com',
];
