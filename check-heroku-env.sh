#!/bin/bash

# Heroku 环境检查脚本
# 使用方法: ./check-heroku-env.sh

echo "🔍 检查 Heroku 环境配置..."
echo ""

# 检查应用名称
read -p "请输入 Heroku 应用名称 (默认使用当前 remote): " app_name

if [ -z "$app_name" ]; then
    REMOTE="heroku"
else
    REMOTE="--app $app_name"
fi

echo ""
echo "📊 应用信息:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
heroku info $REMOTE

echo ""
echo "⚙️  环境变量:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
heroku config $REMOTE

echo ""
echo "🔌 附加组件:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
heroku addons $REMOTE

echo ""
echo "📦 已安装的扩展:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
heroku run "php flarum info" $REMOTE 2>/dev/null || echo "⚠️  无法获取扩展列表"

echo ""
echo "💾 数据库状态:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
if heroku addons | grep -q "heroku-postgresql"; then
    heroku pg:info $REMOTE
elif heroku addons | grep -q "cleardb"; then
    echo "✓ ClearDB MySQL 已安装"
    heroku config:get CLEARDB_DATABASE_URL $REMOTE
else
    echo "⚠️  未检测到数据库附加组件"
fi

echo ""
echo "📝 最近日志:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
heroku logs --tail --num 20 $REMOTE

echo ""
echo "✅ 检查完成！"
