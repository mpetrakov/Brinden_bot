<?php

namespace Hell\Mvc\Controllers;

use Telegram\Bot\Api;
use Hell\Mvc\Core\Controller;
use Hell\Mvc\Models\Chat;

class IndexController extends Controller
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api($_ENV['TELEGRAM_TOKEN']);
    }

    public function index()
    {
        $webhookData = $this->api->getWebhookUpdate();
        $message = $webhookData->getMessage();
        $chat = $webhookData->getChat();

        if ($chat->isEmpty()) {
            $this->error(['message' => 'Empty chat']);
        }

        file_put_contents(__DIR__ . '/../../message.txt', print_r($message, true) . "\n", FILE_APPEND | LOCK_EX);
        file_put_contents(__DIR__ . '/../../message.txt', print_r($chat, true) . "\n", FILE_APPEND | LOCK_EX);

        Chat::firstOrCreate([
            'chat_id' => $chat->get('id'),
            'name' => $chat->get('first_name')
        ]);

        /*
        $text = $result["message"]["text"]; //Текст сообщения
        $chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
        $name = $result["message"]["from"]["username"]; //Юзернейм пользователя
        $keyboard = [["Последние статьи"], ["Картинка"], ["Гифка"]]; //Клавиатура

        if ($text) {
            if ($text == "/start") {
                $reply = "Добро пожаловать в бота!";
                $reply_markup = $telegram->replyKeyboardMarkup([
                    'keyboard' => $keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => false
                ]);
                $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);
            } elseif ($text == "/help") {
                $reply = "Информация с помощью.";
                $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
            } else {
                $telegram->sendMessage(['chat_id' => $chat_id, 'text' => "Отправьте текстовое сообщение."]);
            }
        }
        */
    }
}