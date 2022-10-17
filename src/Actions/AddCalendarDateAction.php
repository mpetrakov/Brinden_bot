<?php

namespace Hell\Mvc\Actions;

use Telegram\Bot\Api;

use Hell\Mvc\Models\Chat;
use Hell\Mvc\Models\Notice;

class AddCalendarDateAction
{
    private string $date;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function handle()
    {
        $api = new Api($_ENV['TELEGRAM_TOKEN']);
        $webhookData = $api->getWebhookUpdate();
        $chatId = $webhookData->getChat()->get('id');
        $currentChat = Chat::firstWhere('chat_id', $chatId);

        if ($this->date < date('Y-m-d')) {
            return $api->sendMessage([
                'chat_id' => $chatId,
                'text' => '🤕 Нельзя выбрать дату в прошлом...'
            ]);
        }

        Notice::whereIn('status', [Notice::STATUS_NEW, Notice::STATUS_PROCESSED])
            ->where('chat_id', $currentChat->id)
            ->update([
                'status' => Notice::STATUS_PROCESSED,
                'date' => $this->date
            ]);

        return $api->sendMessage([
            'chat_id' => $chatId,
            'text' => '🖊️ Введите текст напоминания'
        ]);
    }
}