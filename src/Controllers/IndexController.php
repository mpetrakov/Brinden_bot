<?php

namespace Hell\Mvc\Controllers;

use Telegram\Bot\Api;
use Hell\Mvc\Models\Chat;

class IndexController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api($_ENV['TELEGRAM_TOKEN']);
    }

    public function index()
    {
        $message = $this->api->getWebhookUpdate();

        file_put_contents(__DIR__ . '/../../message.txt', print_r($message, true));

        $chatId = $message['message']['chat']['id'];

        Chat::create(['chat_id' => $chatId]);

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