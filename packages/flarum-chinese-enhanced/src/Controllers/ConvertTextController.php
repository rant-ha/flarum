<?php

namespace FlarumChineseEnhanced\Controllers;

use Flarum\Http\RequestUtil;
use FlarumChineseEnhanced\Formatter\ChineseTextFormatter;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ConvertTextController implements RequestHandlerInterface
{
    /**
     * 处理文本转换请求
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // 验证用户权限
        RequestUtil::getActor($request);
        
        // 获取请求数据
        $data = $request->getParsedBody();
        $text = $data['text'] ?? '';
        $to = $data['to'] ?? 'simplified'; // simplified 或 traditional
        
        // 执行转换
        if ($to === 'traditional') {
            $converted = ChineseTextFormatter::simplifiedToTraditional($text);
        } else {
            $converted = ChineseTextFormatter::traditionalToSimplified($text);
        }
        
        // 返回结果
        return new JsonResponse([
            'data' => [
                'type' => 'chinese-convert',
                'attributes' => [
                    'original' => $text,
                    'converted' => $converted,
                    'direction' => $to
                ]
            ]
        ]);
    }
}
