<?php

echo "<pre>";
echo "<h1>Flarum Translation Debugger</h1>";

// Define paths
$basePath = __DIR__ . '/..';
$packagePath = $basePath . '/packages/lang-chinese-simplified/locale';
$vendorPath = $basePath . '/vendor/local/lang-chinese-simplified/locale';

// 1. Check Source Package Folder (Manual Git Upload)
echo "<h2>1. Checking Source Package Folder</h2>";
echo "Path: " . $packagePath . "\n";
if (is_dir($packagePath)) {
    echo "Status: FOUND\n";
    $files = scandir($packagePath);
    echo "Files:\n";
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        echo " - " . $file . " (" . filesize($packagePath . '/' . $file) . " bytes)\n";
        
        // Read snippet of core.yml to verify Lib content matches
        if ($file === 'core.yml') {
            echo "   [Content Check] core.yml snippet (looking for 'lib'):\n";
            $content = file_get_contents($packagePath . '/' . $file);
            if (strpos($content, 'lib:') !== false) {
                echo "   SUCCESS: Found 'lib:' key in source file.\n";
            } else {
                echo "   FAILURE: 'lib:' key MISSING in source file.\n";
            }
        }
    }
} else {
    echo "Status: NOT FOUND (This is critically bad if valid)\n";
}

// 2. Check Vendor Installed Folder (Composer)
echo "\n<h2>2. Checking Vendor Installed Folder</h2>";
echo "Path: " . $vendorPath . "\n";
if (is_dir($vendorPath)) {
    echo "Status: FOUND\n";
    $files = scandir($vendorPath);
    echo "Files:\n";
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        echo " - " . $file . " (" . filesize($vendorPath . '/' . $file) . " bytes)\n";

         // Read snippet of core.yml to verify Lib content matches
         if ($file === 'core.yml') {
            echo "   [Content Check] core.yml snippet (looking for 'lib'):\n";
            $content = file_get_contents($vendorPath . '/' . $file);
            if (strpos($content, 'lib:') !== false) {
                echo "   SUCCESS: Found 'lib:' key in vendor file.\n";
            } else {
                echo "   FAILURE: 'lib:' key MISSING in vendor file. (Composer did not update the package)\n";
            }
        }
    }
} else {
    echo "Status: NOT FOUND (Composer might not have installed it or path is different)\n";
}

echo "\n<h2>3. Environment Info</h2>";
echo "Current Dir: " . __DIR__ . "\n";
echo "PHP Version: " . phpversion() . "\n";
echo "</pre>";
