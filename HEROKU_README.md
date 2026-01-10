# 🚀 Flarum on Heroku - 中文增强版

这是一个针对 Heroku 优化的 Flarum 2.0 部署，包含完整的中文支持和增强功能。

## ✨ 特性

- 🇨🇳 **完整中文支持**：简体中文语言包
- 🎨 **中文增强扩展**：
  - 中英文自动空格
  - 智能标点转换
  - 中文搜索优化
  - 简繁体转换 API
  - 中文日期格式化
- ☁️ **Heroku 优化**：针对云平台优化的配置

## 📋 已包含的扩展

### 核心扩展
- Approval (审批)
- BBCode (BB代码)
- Emoji (表情符号)
- Flags (举报)
- GDPR (数据保护)
- Likes (点赞)
- Lock (锁定)
- Markdown (Markdown支持)
- Mentions (提及)
- Messages (私信)
- Nicknames (昵称)
- Pusher (推送)
- Statistics (统计)
- Sticky (置顶)
- Subscriptions (订阅)
- Suspend (封禁)
- Tags (标签)

### 语言包
- English (英语)
- **简体中文** ✨

### 自定义扩展
- **Chinese Enhanced (中文增强)** ✨

## 🚀 快速部署

### 方法 1: 使用部署脚本（推荐）

```bash
# 1. 克隆或初始化仓库
git clone <your-repo-url>
cd flarum

# 2. 运行部署脚本
./deploy-to-heroku.sh
```

### 方法 2: 手动部署

```bash
# 1. 登录 Heroku
heroku login

# 2. 创建应用（或使用现有应用）
heroku create your-flarum-app

# 3. 添加数据库
heroku addons:create cleardb:ignite
# 或
heroku addons:create heroku-postgresql:mini

# 4. 配置环境变量
heroku config:set APP_DEBUG=false
heroku config:set FLARUM_URL=https://your-flarum-app.herokuapp.com

# 5. 推送代码
git push heroku main

# 6. 运行初始化命令
heroku run php flarum migrate
heroku run php flarum cache:clear
heroku run php flarum assets:publish
```

## ⚙️ 环境配置

### 必需的环境变量

```bash
# 应用配置
APP_DEBUG=false
FLARUM_URL=https://your-app.herokuapp.com

# 数据库配置（通常由 Heroku 自动设置）
DB_HOST=<自动设置>
DB_DATABASE=<自动设置>
DB_USERNAME=<自动设置>
DB_PASSWORD=<自动设置>
```

### 可选的环境变量

```bash
# Redis 缓存（如果添加了 Redis 附加组件）
REDIS_URL=<自动设置>

# 邮件配置
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<your-username>
MAIL_PASSWORD=<your-password>
MAIL_ENCRYPTION=tls
```

## 🛠️ 管理命令

### 查看日志
```bash
heroku logs --tail
```

### 清除缓存
```bash
heroku run php flarum cache:clear
```

### 重新发布资源
```bash
heroku run php flarum assets:publish
```

### 运行迁移
```bash
heroku run php flarum migrate
```

### 检查环境
```bash
./check-heroku-env.sh
```

### 进入应用控制台
```bash
heroku run bash
```

## 📱 启用扩展

部署完成后：

1. 访问管理后台：`https://your-app.herokuapp.com/admin`
2. 进入「扩展」页面
3. 找到并启用：
   - ✅ 简体中文 (Simplified Chinese)
   - ✅ Chinese Enhanced (中文增强)
4. 在「基本设置」中将默认语言设为「简体中文」

## 🔧 中文增强功能配置

在扩展设置中可以配置：

- **启用简体中文支持**：默认开启
- **启用繁体中文支持**：可选
- **自动简繁转换**：可选
- **搜索优化**：推荐开启

## 📊 性能优化

### 添加 Redis 缓存
```bash
heroku addons:create heroku-redis:mini
```

然后在 `config.php` 中配置 Redis（已预配置）。

### 升级 Dyno
```bash
# 升级到 Hobby dyno（$7/月）
heroku ps:scale web=1:hobby

# 或升级到 Standard-1X（$25/月）
heroku ps:scale web=1:standard-1x
```

## 🔒 安全建议

1. **禁用调试模式**（生产环境）：
   ```bash
   heroku config:set APP_DEBUG=false
   ```

2. **使用强密码**：管理员账号使用复杂密码

3. **定期备份数据库**：
   ```bash
   heroku pg:backups:capture
   heroku pg:backups:download
   ```

4. **保持更新**：定期更新 Flarum 和扩展

## 📁 项目结构

```
flarum/
├── packages/                          # 本地扩展包
│   ├── lang-chinese-simplified/      # 简体中文语言包
│   └── flarum-chinese-enhanced/      # 中文增强扩展
├── public/                           # Web 根目录
├── storage/                          # 存储目录
├── vendor/                           # Composer 依赖
├── composer.json                     # PHP 依赖配置
├── config.php                        # Flarum 配置
├── extend.php                        # 扩展加载配置
├── Procfile                          # Heroku 进程配置
├── deploy-to-heroku.sh              # 部署脚本
└── check-heroku-env.sh              # 环境检查脚本
```

## 🆘 故障排查

### 应用无法启动

1. 检查日志：`heroku logs --tail`
2. 验证数据库连接：`heroku config | grep DATABASE`
3. 重启应用：`heroku restart`

### 扩展未显示

```bash
heroku run php flarum cache:clear
heroku run php flarum assets:publish
```

### 中文显示乱码

确保数据库字符集为 `utf8mb4`：
```sql
ALTER DATABASE database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 性能问题

1. 添加 Redis 缓存
2. 升级 Dyno 类型
3. 优化图片大小
4. 启用 CDN

## 🔄 更新流程

```bash
# 1. 拉取最新代码
git pull origin main

# 2. 更新依赖
composer update

# 3. 提交更改
git add .
git commit -m "Update dependencies"

# 4. 推送到 Heroku
git push heroku main

# 5. 清除缓存
heroku run php flarum cache:clear
heroku run php flarum assets:publish
```

## 📞 支持与帮助

- **Flarum 官方文档**：https://docs.flarum.org/
- **Heroku 文档**：https://devcenter.heroku.com/
- **中文支持论坛**：https://discuss.flarum.org/t/chinese

## 📄 许可证

MIT License

## 🙏 致谢

- Flarum 团队
- Flarum 中文社区
- 所有贡献者

---

**享受你的中文 Flarum 论坛！** 🎉
