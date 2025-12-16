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
        // 可选值：cookie | file | redis
        'driver' => getenv('SESSION_DRIVER') ?: 'redis',
        'cookie' => getenv('SESSION_COOKIE') ?: 'flarum_session',
        'lifetime' => intval(getenv('SESSION_LIFETIME') ?: 60),
    ],

    // Redis 连接配置（支持 Heroku 常见变量名）
    'redis' => [
        // 优先使用用户显式设置的 REDIS_CLIENT，否则根据运行时检测选择：
        // 若 PHP 已加载 ext-redis -> phpredis；否则使用 predis（需要 composer 安装 predis/predis）
        'client' => getenv('REDIS_CLIENT') ?: (extension_loaded('redis') ? 'phpredis' : 'predis'),

        'default' => [
            // 支持多种 Heroku/第三方服务环境变量名：
            // 首先 REDIS_URL（通用），其次 REDISCLOUD_URL（Redis Cloud），然后其他可能的名
            'url' => getenv('REDIS_URL') ?: getenv('REDISCLOUD_URL') ?: getenv('REDISGREEN_URL') ?: null,
        ],
    ],
];
