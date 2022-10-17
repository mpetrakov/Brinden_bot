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
        $currentChat = Chat::firstWhere('chat_id', $webhookData->getChat()->get('id'));

        if ($this->date < date('Y-m-d')) {
            return $api->sendMessage([
                'chat_id' => $webhookData->getChat()->get('id'),
                'text' => '🤕 Нельзя выбрать дату в прошлом...'
            ]);
        }

        return Notice::where('status', Notice::STATUS_NEW)
            ->where('chat_id', $currentChat->id)
            ->update([
                'status' => Notice::STATUS_PROCESSED,
                'date' => $this->date
            ]);
    }
}