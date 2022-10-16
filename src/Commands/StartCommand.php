<?php

namespace Hell\Mvc\Commands;

use Telegram\Bot\Api;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

use Hell\Mvc\Models\Chat;

class StartCommand extends Command
{
    protected $name = 'start';

    protected $description = 'Команда /start';

    public function handle()
    {
        $webhookData = (new Api($_ENV['TELEGRAM_TOKEN']))->getWebhookUpdate();
        $chat = $webhookData->getChat();

        file_put_contents(__DIR__ . '/../../message.txt', print_r($webhookData, true) . "\n", FILE_APPEND | LOCK_EX);

        Chat::firstOrCreate([
            'chat_id' => $chat->get('id'),
            'name' => $chat->get('first_name')
        ]);

        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage(['text' => "Привет, {$chat->get('first_name')}! Для добавления напоминания введи команду /add_notice"]);
    }
}