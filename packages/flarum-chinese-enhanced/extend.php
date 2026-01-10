<?php

/*
 * This file is part of flarum/flarum-chinese-enhanced.
 *
 * Copyright (c) 2026 Flarum Chinese Community.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Flarum\Extend;
use FlarumChineseEnhanced\Formatter\ChineseTextFormatter;
use FlarumChineseEnhanced\Controllers\ConvertTextController;

return [
    // 注册中文文本格式化器
    (new Extend\Formatter)
        ->render(function ($renderer, $context, $xml, $request) {
            return ChineseTextFormatter::format($xml);
        }),

    // 添加设置（适配 Heroku 环境）
    (new Extend\Settings)
        ->default('flarum-chinese-enhanced.enable_simplified', true)
        ->default('flarum-chinese-enhanced.enable_traditional', false)
        ->default('flarum-chinese-enhanced.auto_convert', false)
        ->default('flarum-chinese-enhanced.search_optimization', true)
        ->serializeToForum('flarumChineseEnhanced.enableSimplified', 'flarum-chinese-enhanced.enable_simplified', 'boolval')
        ->serializeToForum('flarumChineseEnhanced.enableTraditional', 'flarum-chinese-enhanced.enable_traditional', 'boolval')
        ->serializeToForum('flarumChineseEnhanced.autoConvert', 'flarum-chinese-enhanced.auto_convert', 'boolval')
        ->serializeToForum('flarumChineseEnhanced.searchOptimization', 'flarum-chinese-enhanced.search_optimization', 'boolval'),

    // 注册 API 路由
    (new Extend\Routes('api'))
        ->post('/chinese-convert', 'chinese.convert', ConvertTextController::class),
];
