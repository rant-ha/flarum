# Flarum 中文增强扩展

这是一个为 Flarum 2.0 开发的中文增强扩展，提供了更好的中文支持和用户体验。

## 功能特性

### 1. 中文文本优化
- 自动优化中文排版
- 中英文混排自动添加空格
- 标点符号智能转换

### 2. 简繁体转换
- 支持简体中文和繁体中文互转
- 可配置自动转换
- API 接口支持

### 3. 中文搜索优化
- 优化中文分词搜索
- 支持拼音搜索
- 提高搜索准确度

### 4. SEO 优化
- 中文 URL Slug 优化
- Meta 标签中文支持
- 搜索引擎友好

### 5. 用户体验改进
- 中文日期格式
- 中文数字格式化
- 本地化时间显示

## 安装

1. 将扩展放置在 `packages/flarum-chinese-enhanced` 目录

2. 在主 `composer.json` 中添加仓库配置：

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/flarum-chinese-enhanced"
        }
    ]
}
```

3. 安装扩展：

```bash
composer require local/flarum-chinese-enhanced
```

4. 在 Flarum 后台启用扩展

## 配置

在 Flarum 后台管理面板中，找到"中文增强"扩展设置页面：

- **启用简体中文支持**：默认开启
- **启用繁体中文支持**：可选
- **自动简繁转换**：可选
- **搜索优化**：默认开启

## 使用

### 简繁体转换 API

```javascript
// 简体转繁体
app.request({
    method: 'POST',
    url: app.forum.attribute('apiUrl') + '/chinese-convert',
    body: {
        text: '简体中文文本',
        to: 'traditional'
    }
});

// 繁体转简体
app.request({
    method: 'POST',
    url: app.forum.attribute('apiUrl') + '/chinese-convert',
    body: {
        text: '繁體中文文本',
        to: 'simplified'
    }
});
```

## 开发

### 目录结构

```
flarum-chinese-enhanced/
├── composer.json           # Composer 配置
├── extend.php             # 扩展配置
├── LICENSE                # 许可证
├── README.md             # 说明文档
├── src/                  # PHP 源代码
│   ├── Controllers/      # 控制器
│   ├── Formatter/        # 格式化器
│   ├── Locale/          # 语言环境
│   └── Search/          # 搜索相关
├── js/                   # JavaScript 源代码
│   └── src/
│       ├── admin/       # 后台 JS
│       └── forum/       # 前台 JS
├── less/                # 样式文件
│   ├── admin.less
│   └── forum.less
└── locale/              # 翻译文件
    └── zh-hans.yml
```

### 构建前端资源

```bash
cd packages/flarum-chinese-enhanced
npm install
npm run build
```

## 贡献

欢迎提交问题和拉取请求！

## 许可证

MIT License

## 支持

如有问题，请在 GitHub 上提交 Issue。
