<?php
// Diagnostic script to test Heroku PHP and routing
header('Content-Type: text/html; charset=utf-8');

echo "<h1>Heroku PHP 诊断</h1>";
echo "<p><strong>PHP 版本:</strong> " . phpversion() . "</p>";
echo "<p><strong>当前工作目录:</strong> " . getcwd() . "</p>";
echo "<p><strong>脚本路径:</strong> " . __FILE__ . "</p>";
echo "<p><strong>文档根目录:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . "</p>";
echo "<p><strong>请求 URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "</p>";

echo "<h2>目录内容:</h2>";
echo "<ul>";
$files = scandir(__DIR__);
foreach ($files as $file) {
    echo "<li>" . htmlspecialchars($file) . "</li>";
}
echo "</ul>";

echo "<h2>public/ 目录内容:</h2>";
if (is_dir(__DIR__ . '/public')) {
    echo "<ul>";
    $publicFiles = scandir(__DIR__ . '/public');
    foreach ($publicFiles as $file) {
        echo "<li>" . htmlspecialchars($file) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>public/ 目录不存在!</p>";
}

echo "<h2>config.php 存在性:</h2>";
echo "<p>" . (file_exists(__DIR__ . '/config.php') ? '存在' : '不存在') . "</p>";

echo "<h2>vendor/autoload.php 存在性:</h2>";
echo "<p>" . (file_exists(__DIR__ . '/vendor/autoload.php') ? '存在' : '不存在') . "</p>";

echo "<hr>";
echo "<p><a href='/public/'>尝试访问 /public/</a></p>";
