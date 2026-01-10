<?php

namespace FlarumChineseEnhanced\Locale;

use Flarum\Locale\LocaleManager;
use Illuminate\Support\Arr;

class ChineseLocaleSwitcher
{
    /**
     * @var LocaleManager
     */
    protected $locales;

    /**
     * @param LocaleManager $locales
     */
    public function __construct(LocaleManager $locales)
    {
        $this->locales = $locales;
    }

    /**
     * 处理语言环境切换
     */
    public function __invoke()
    {
        // 检测用户首选语言
        $locale = $this->detectUserLocale();
        
        // 如果是中文相关，设置为简体中文
        if (in_array($locale, ['zh', 'zh-CN', 'zh-Hans', 'zh-Hans-CN'])) {
            $this->locales->setLocale('zh');
        } elseif (in_array($locale, ['zh-TW', 'zh-HK', 'zh-Hant', 'zh-Hant-TW'])) {
            $this->locales->setLocale('zh-Hant');
        }
    }

    /**
     * 检测用户语言环境
     *
     * @return string
     */
    protected function detectUserLocale()
    {
        // 从浏览器 Accept-Language 头检测
        $acceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
        
        // 解析语言偏好
        preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $acceptLanguage, $matches);
        
        if (count($matches[1])) {
            $languages = array_combine($matches[1], $matches[4]);
            
            foreach ($languages as $lang => $val) {
                if ($val === '') {
                    $languages[$lang] = 1;
                }
            }
            
            arsort($languages, SORT_NUMERIC);
            
            return key($languages);
        }
        
        return 'en';
    }

    /**
     * 格式化中文日期
     *
     * @param \DateTime $date
     * @return string
     */
    public static function formatChineseDate(\DateTime $date)
    {
        $year = $date->format('Y');
        $month = $date->format('n');
        $day = $date->format('j');
        
        return "{$year}年{$month}月{$day}日";
    }

    /**
     * 格式化中文时间
     *
     * @param \DateTime $date
     * @return string
     */
    public static function formatChineseDateTime(\DateTime $date)
    {
        $dateStr = self::formatChineseDate($date);
        $hour = $date->format('H');
        $minute = $date->format('i');
        
        return "{$dateStr} {$hour}:{$minute}";
    }
}
