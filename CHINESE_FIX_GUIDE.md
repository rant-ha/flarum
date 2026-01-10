# 🔧 中文显示问题修复指南

## 问题症状

界面显示翻译键名（如 `core.forum.index.start_discussion_button`）而不是中文文本。

## ✅ 已修复的问题

### 问题 1: 语言代码不匹配

**原因：** 语言包使用的代码是 `zh`，但 Flarum 2.0 期望使用 `zh-Hans`

**修复：** 已将 `packages/lang-chinese-simplified/composer.json` 中的语言代码更改为 `zh-Hans`

```json
"flarum-locale": {
    "code": "zh-Hans",  // 从 "zh" 改为 "zh-Hans"
    "title": "简体中文"
}
```

## 🚀 部署后修复步骤

### 步骤 1: 重新部署到 Heroku

代码已推送到 GitHub，在 Heroku Dashboard 中重新部署：

1. 访问 https://dashboard.heroku.com/apps/your-app-name
2. 进入 **Deploy** 标签
3. 在 **Manual deploy** 部分点击 **Deploy Branch**

### 步骤 2: 清除缓存（重要！）

部署完成后，必须清除缓存：

```bash
# 清除 Flarum 缓存
heroku run "php flarum cache:clear" -a your-app-name

# 重新发布资源
heroku run "php flarum assets:publish" -a your-app-name

# 重启应用
heroku restart -a your-app-name
```

### 步骤 3: 重新启用扩展

1. 访问管理后台：`https://your-app-name.herokuapp.com/admin`
2. 进入 **扩展** 页面
3. **禁用** 简体中文扩展
4. **启用** 简体中文扩展
5. 刷新页面

### 步骤 4: 重新设置默认语言

1. 在管理后台，进入 **基本设置**
2. **默认语言** 选择 **简体中文**（应该显示为 "简体中文" 而不是 "zh"）
3. 保存更改

### 步骤 5: 清除浏览器缓存

- **Chrome/Edge**: `Ctrl + Shift + Delete`
- **Firefox**: `Ctrl + Shift + Delete`
- **Safari**: `Command + Option + E`

然后刷新页面（`Ctrl + F5` 或 `Cmd + Shift + R`）

---

## 🔍 验证修复

刷新后，界面应该显示：

- ❌ **之前**: `core.forum.index.start_discussion_button`
- ✅ **现在**: `发布帖子`

其他应该正常显示的中文：

- `core.forum.header.profile_button` → `个人主页`
- `core.forum.header.settings_button` → `设置`
- `core.forum.header.log_out_button` → `退出`
- `core.lib.search.placeholder` → `搜索论坛`

---

## 🐛 如果问题仍然存在

### 方法 1: 完全清除缓存

```bash
# 连接到 Heroku
heroku run bash -a your-app-name

# 在 Heroku 控制台中运行
rm -rf storage/cache/*
rm -rf storage/locale/*
rm -rf storage/views/*
php flarum cache:clear
php flarum assets:publish
exit

# 重启应用
heroku restart -a your-app-name
```

### 方法 2: 检查扩展是否正确安装

```bash
heroku run "php flarum info" -a your-app-name
```

应该看到：
```
简体中文 (local/lang-chinese-simplified) version 2.0.1
Chinese Enhanced (local/flarum-chinese-enhanced) version 1.0.0
```

### 方法 3: 检查语言包文件

```bash
heroku run "ls -la vendor/local/lang-chinese-simplified/locale/" -a your-app-name
```

应该看到 `core.yml` 等翻译文件。

### 方法 4: 手动重建

```bash
# 清除所有缓存
heroku run "php flarum cache:clear" -a your-app-name

# 重新发布资源（强制）
heroku run "php flarum assets:publish --force" -a your-app-name

# 重启
heroku restart -a your-app-name
```

---

## 📊 检查清单

部署后请完成以下检查：

- [ ] 代码已推送到 GitHub
- [ ] Heroku 已重新部署
- [ ] 运行了 `php flarum cache:clear`
- [ ] 运行了 `php flarum assets:publish`
- [ ] 重启了应用
- [ ] 在管理后台重新启用了扩展
- [ ] 设置了默认语言为简体中文
- [ ] 清除了浏览器缓存
- [ ] 刷新了页面

---

## 💡 预防措施

为避免未来出现类似问题：

1. **每次修改后清除缓存**
   ```bash
   heroku run "php flarum cache:clear" -a your-app-name
   ```

2. **使用硬刷新**
   - Windows: `Ctrl + F5`
   - Mac: `Cmd + Shift + R`

3. **检查语言代码**
   - 简体中文: `zh-Hans`
   - 繁体中文: `zh-Hant`
   - 英语: `en`

4. **定期检查日志**
   ```bash
   heroku logs --tail -a your-app-name
   ```

---

## 📞 仍需帮助？

如果问题持续存在，提供以下信息：

1. **Heroku 日志**:
   ```bash
   heroku logs --tail -a your-app-name
   ```

2. **浏览器控制台错误**:
   - 按 `F12` 打开开发者工具
   - 查看 Console 标签的错误信息

3. **扩展列表**:
   ```bash
   heroku run "php flarum info" -a your-app-name
   ```

4. **截图**: 显示问题的界面截图

---

## ✅ 修复完成

修复代码已推送到 GitHub。重新部署后清除缓存，中文应该会正常显示！

**GitHub 提交**: `39a1ee9` - 将语言代码从 'zh' 改为 'zh-Hans'

🎉 **现在去 Heroku 重新部署，然后清除缓存即可！**
