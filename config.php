<?php
return [
    // Production: 若需要临时打开 Debug，可在 Heroku 上设置 APP_DEBUG=true
    'debug' => (getenv('APP_DEBUG') === 'true'),

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

    // 用于生成邮件/站点链接，建议在 Heroku Config Vars 中设置为你的域名
    'url' => getenv('APP_URL') ?: 'https://qzforum.ranai.me',

    // Session 配置（优先由环境变量控制）
    'session' => [
        // 可选值：cookie | file | redis  （默认改为 redis）
        'driver' => getenv('SESSION_DRIVER') ?: 'redis',
        'cookie' => getenv('SESSION_COOKIE') ?: 'flarum_session',
        // 建议 60-120 分钟以减少 Redis 内存消耗
        'lifetime' => intval(getenv('SESSION_LIFETIME') ?: 60),
    ],

    // Redis 连接配置（使用 REDIS_URL）
    'redis' => [
        // client: 'phpredis' 对应 PHP 的 ext-redis；若你使用 predis 改为 'predis'
        'client' => getenv('REDIS_CLIENT') ?: 'phpredis',
        'default' => [
            'url' => getenv('REDIS_URL') ?: null,
        ],
    ],
];
