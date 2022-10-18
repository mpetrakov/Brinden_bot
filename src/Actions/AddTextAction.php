<?php

namespace Hell\Mvc\Actions;

use Telegram\Bot\Api;

use Hell\Mvc\Models\Chat;
use Hell\Mvc\Models\Notice;

class AddTextAction
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function handle()
    {
        $api = new Api($_ENV['TELEGRAM_TOKEN']);
        $webhookData = $api->getWebhookUpdate();
        $chatId = $webhookData->getChat()->get('id');
        $currentChat = Chat::firstWhere('chat_id', $chatId);

        Notice::where('status', Notice::STATUS_PROCESSED)
            ->where('chat_id', $currentChat->id)
            ->update([
                'status' => Notice::STATUS_PLANNED,
                'text' => $this->text
            ]);
        return $api->sendMessage([
            'chat_id' => $chatId,
            'text' => '🖊️ А если так?'
        ]);
    }
}