<?php

namespace FlarumChineseEnhanced\Search;

use Flarum\Search\AbstractFulltextGambit;
use Flarum\Search\SearchState;

class ChineseFullTextGambit extends AbstractFulltextGambit
{
    /**
     * 应用全文搜索
     *
     * @param SearchState $search
     * @param string $bit
     */
    protected function applyFulltext(SearchState $search, string $bit)
    {
        // 优化中文搜索
        $processedBit = $this->processChineseQuery($bit);
        
        // 应用搜索
        $search->getQuery()->where(function ($query) use ($processedBit) {
            $query->where('title', 'like', "%{$processedBit}%")
                  ->orWhere('content', 'like', "%{$processedBit}%");
        });
    }

    /**
     * 处理中文搜索查询
     *
     * @param string $query
     * @return string
     */
    protected function processChineseQuery($query)
    {
        // 移除多余空格
        $query = preg_replace('/\s+/', ' ', trim($query));
        
        // 分词处理（简化版）
        $words = $this->segmentChinese($query);
        
        return implode('%', $words);
    }

    /**
     * 简单的中文分词
     *
     * @param string $text
     * @return array
     */
    protected function segmentChinese($text)
    {
        // 这是简化版实现
        // 实际应用中建议集成 jieba 等专业分词库
        
        $words = [];
        $length = mb_strlen($text, 'UTF-8');
        
        for ($i = 0; $i < $length; $i++) {
            $char = mb_substr($text, $i, 1, 'UTF-8');
            
            // 中文字符
            if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $char)) {
                $words[] = $char;
            } 
            // 英文单词
            elseif (preg_match('/[a-zA-Z0-9]/', $char)) {
                $word = $char;
                while ($i + 1 < $length) {
                    $nextChar = mb_substr($text, $i + 1, 1, 'UTF-8');
                    if (preg_match('/[a-zA-Z0-9]/', $nextChar)) {
                        $word .= $nextChar;
                        $i++;
                    } else {
                        break;
                    }
                }
                $words[] = $word;
            }
        }
        
        return array_filter($words);
    }

    /**
     * 拼音搜索支持
     *
     * @param string $chinese
     * @return array
     */
    protected function toPinyin($chinese)
    {
        // 这里可以集成拼音转换库
        // 例如：overtrue/pinyin
        return [$chinese];
    }
}
