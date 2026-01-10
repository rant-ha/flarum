# Heroku 部署指南 - Flarum 中文增强扩展

本指南详细说明如何在 Heroku 上部署带有中文增强扩展的 Flarum 论坛。

## 📋 前置要求

- Heroku 账号
- Heroku CLI 工具
- Git 已安装配置
- PHP >= 8.1
- MySQL 或 PostgreSQL 数据库附加组件

## 🚀 部署步骤

### 1. 确认扩展已添加到 composer.json

确保主目录的 `composer.json` 包含中文扩展：

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/*",
            "options": {
                "symlink": false
            }
        }
    ],
    "require": {
        "local/lang-chinese-simplified": "*",
        "local/flarum-chinese-enhanced": "*"
    }
}
```

**注意**：`"symlink": false` 对 Heroku 部署非常重要！

### 2. 安装依赖

在本地运行：

```bash
composer install --no-dev --optimize-autoloader
```

### 3. 提交更改到 Git

```bash
git add .
git commit -m "Add Chinese Enhanced extension"
```

### 4. 推送到 Heroku

```bash
git push heroku main
# 或
git push heroku 2.x:main
```

### 5. 运行数据库迁移（首次部署）

```bash
heroku run php flarum migrate
```

### 6. 清除缓存

```bash
heroku run php flarum cache:clear
```

### 7. 发布资源

```bash
heroku run php flarum assets:publish
```

## ⚙️ Heroku 环境配置

### 必需的环境变量

在 Heroku 控制台设置以下环境变量，或使用 CLI：

```bash
# 数据库配置（如果使用 ClearDB MySQL）
heroku config:set DB_URL="mysql://username:password@hostname/database"

# 或者分别设置
heroku config:set DB_HOST="hostname"
heroku config:set DB_DATABASE="database"
heroku config:set DB_USERNAME="username"
heroku config:set DB_PASSWORD="password"
heroku config:set DB_PORT="3306"

# URL 配置
heroku config:set FLARUM_URL="https://your-app.herokuapp.com"

# 关闭调试模式（生产环境）
heroku config:set APP_DEBUG="false"
```

### 推荐的附加组件

```bash
# MySQL 数据库
heroku addons:create cleardb:ignite

# 或 PostgreSQL
heroku addons:create heroku-postgresql:mini

# Redis（用于缓存和队列）
heroku addons:create heroku-redis:mini
```

## 📝 config.php 配置示例

在 Heroku 上，你需要从环境变量读取配置：

```php
<?php

return [
    'debug' => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),
    'offline' => false,
    'database' => [
        'driver' => 'mysql',
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => getenv('DB_PORT') ?: 3306,
        'database' => getenv('DB_DATABASE') ?: 'flarum',
        'username' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => false,
        'engine' => 'InnoDB',
        'prefix_indexes' => true,
    ],
    'url' => getenv('FLARUM_URL') ?: 'http://localhost',
    'paths' => [
        'api' => 'api',
        'admin' => 'admin',
    ],
];
```

## 🔧 中文扩展特定配置

### 启用扩展

部署后，访问管理后台：

1. 登录到 `https://your-app.herokuapp.com/admin`
2. 进入「扩展」页面
3. 找到「简体中文」和「Chinese Enhanced」
4. 点击启用

### 配置中文增强功能

在管理后台的扩展设置中：

- ✅ **启用简体中文支持**：推荐开启
- ⬜ **启用繁体中文支持**：根据需要
- ⬜ **自动简繁转换**：可选
- ✅ **搜索优化**：推荐开启

## 📦 Procfile 配置

确保你的 `Procfile` 正确配置：

```
web: vendor/bin/heroku-php-apache2 public/
```

## 🔄 更新部署

当你需要更新扩展时：

```bash
# 1. 修改代码
# 2. 更新依赖
composer update local/flarum-chinese-enhanced

# 3. 提交更改
git add .
git commit -m "Update Chinese Enhanced extension"

# 4. 推送到 Heroku
git push heroku main

# 5. 清除缓存
heroku run php flarum cache:clear
heroku run php flarum assets:publish
```

## 🐛 故障排查

### 查看日志

```bash
heroku logs --tail
```

### 检查扩展状态

```bash
heroku run php flarum info
```

### 清除所有缓存

```bash
heroku run php flarum cache:clear
heroku run rm -rf storage/cache/*
heroku run rm -rf storage/views/*
```

### 重新编译资源

```bash
heroku run php flarum assets:publish --force
```

## ⚡ 性能优化建议

### 1. 启用 Redis 缓存

安装 Redis 附加组件后，在 `config.php` 中配置：

```php
'cache' => [
    'driver' => 'redis',
    'redis' => [
        'url' => getenv('REDIS_URL'),
    ],
],
'session' => [
    'driver' => 'redis',
    'connection' => 'default',
],
```

### 2. 配置队列

```php
'queue' => [
    'driver' => 'redis',
    'connection' => 'default',
],
```

### 3. 优化 Composer autoloader

```bash
composer dump-autoload --optimize --no-dev
```

## 🔒 安全建议

1. **禁用调试模式**：
   ```bash
   heroku config:set APP_DEBUG="false"
   ```

2. **使用 HTTPS**：Heroku 自动提供，确保强制使用

3. **定期更新依赖**：
   ```bash
   composer update
   ```

4. **备份数据库**：
   ```bash
   heroku pg:backups:capture
   ```

## 📊 监控

### 查看应用状态

```bash
heroku ps
```

### 查看数据库连接

```bash
heroku pg:info
```

### 查看 Redis 状态

```bash
heroku redis:info
```

## 🆘 常见问题

### Q: 扩展没有显示？
A: 运行 `heroku run php flarum cache:clear && php flarum assets:publish`

### Q: 中文显示乱码？
A: 确保数据库使用 `utf8mb4` 字符集和 `utf8mb4_unicode_ci` 排序规则

### Q: 搜索中文不准确？
A: 确保中文增强扩展已启用，并开启了搜索优化选项

### Q: 应用启动缓慢？
A: 考虑升级 Dyno 类型或启用 Redis 缓存

## 📞 支持

如遇问题，请检查：
1. Heroku 日志：`heroku logs --tail`
2. Flarum 日志：`storage/logs/flarum.log`
3. PHP 错误日志

## 🎉 部署成功后

访问你的论坛：`https://your-app.herokuapp.com`

享受优化的中文体验！
