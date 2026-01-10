#!/bin/bash

# Heroku 部署脚本 - Flarum 中文扩展
# 使用方法: ./deploy-to-heroku.sh

set -e

echo "🚀 开始部署 Flarum 中文扩展到 Heroku..."

# 1. 检查 Heroku CLI
if ! command -v heroku &> /dev/null; then
    echo "❌ 错误: 未找到 Heroku CLI，请先安装"
    echo "   访问: https://devcenter.heroku.com/articles/heroku-cli"
    exit 1
fi

# 2. 检查是否已登录
echo "📋 检查 Heroku 登录状态..."
if ! heroku auth:whoami &> /dev/null; then
    echo "⚠️  未登录 Heroku，请先登录"
    heroku login
fi

# 3. 检查 Git 状态
echo "📝 检查 Git 状态..."
if [[ -n $(git status -s) ]]; then
    echo "⚠️  检测到未提交的更改"
    read -p "是否要提交所有更改? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        git add .
        read -p "请输入提交信息: " commit_msg
        git commit -m "$commit_msg"
    else
        echo "❌ 取消部署，请先提交更改"
        exit 1
    fi
fi

# 4. 更新 Composer 依赖
echo "📦 更新 Composer 依赖..."
composer install --no-dev --optimize-autoloader --prefer-dist

# 5. 推送到 Heroku
echo "🚢 推送代码到 Heroku..."
BRANCH=$(git branch --show-current)
read -p "请输入 Heroku remote 名称 (默认: heroku): " heroku_remote
heroku_remote=${heroku_remote:-heroku}

echo "推送分支 $BRANCH 到 $heroku_remote..."
git push $heroku_remote $BRANCH:main

# 6. 运行部署后命令
echo "🔧 运行部署后命令..."

echo "  - 清除缓存..."
heroku run "php flarum cache:clear" --remote $heroku_remote || echo "⚠️  缓存清除失败（可能是首次部署）"

echo "  - 发布资源..."
heroku run "php flarum assets:publish" --remote $heroku_remote || echo "⚠️  资源发布失败（可能是首次部署）"

# 7. 检查应用状态
echo "📊 检查应用状态..."
heroku ps --remote $heroku_remote

# 8. 显示 URL
APP_URL=$(heroku info --remote $heroku_remote | grep "Web URL" | awk '{print $3}')
echo ""
echo "✅ 部署完成！"
echo "🌐 应用 URL: $APP_URL"
echo ""
echo "📝 后续步骤:"
echo "   1. 访问管理后台: ${APP_URL}admin"
echo "   2. 启用'简体中文'和'Chinese Enhanced'扩展"
echo "   3. 配置中文增强功能设置"
echo ""
echo "🔍 查看日志: heroku logs --tail --remote $heroku_remote"
echo "🛠️  打开控制台: heroku run bash --remote $heroku_remote"
