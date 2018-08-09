<?php

namespace App\Services;

use App\Models\MessageBox;
use InvalidArgumentException;

class MessageBoxService
{
    const CHANNEL_TEACHER = 1;    // 认证老师
    const CHANNEL_AUDITOR = 2;    // 分店审核员
    const CHANNEL_MANAGER = 3;    // 总部工管员

    public static function create($channel, $content, $to, $from = null)
    {
        switch ($channel) {
            case self::CHANNEL_TEACHER:
            case self::CHANNEL_AUDITOR:
            case self::CHANNEL_MANAGER:
                break;
            default:
                throw new InvalidArgumentException('消息类型不合法');
        }
        if (empty($content)) {
            throw new InvalidArgumentException('消息内容不能为空');
        }

        if ($channel == self::CHANNEL_MANAGER) {
            $to = $to ?: '';
        } else if (empty($to)) {
            throw new InvalidArgumentException('消息接收者不能为空');
        }

        $message = new MessageBox;
        $message->channel = $channel;
        $message->content = $content;
        $message->msg_from = $from;
        $message->msg_to = $to;
        $message->save();
    }
}
