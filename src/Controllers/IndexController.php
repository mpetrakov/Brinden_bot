<?php

namespace Hell\Mvc\Controllers;

use Telegram\Bot\Api;
use Hell\Mvc\Core\Controller;
use Hell\Mvc\Classes\Calendar;

use Hell\Mvc\Commands\StartCommand;

class IndexController extends Controller
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api($_ENV['TELEGRAM_TOKEN']);

        $this->api->addCommands([
            StartCommand::class
        ]);
    }

    public function index()
    {
        $this->api->commandsHandler(true);
        /*
        $webhookData = $this->api->getWebhookUpdate();
        $messageData = $webhookData->getMessage();
        $chatData = $webhookData->getChat();

        if ($chatData->isEmpty()) {
            $this->error(['message' => 'Empty chat']);
        }

        file_put_contents(__DIR__ . '/../../message.txt', print_r($messageData, true) . "\n", FILE_APPEND | LOCK_EX);
        file_put_contents(__DIR__ . '/../../message.txt', print_r($chatData, true) . "\n", FILE_APPEND | LOCK_EX);

        $chatId = $chatData->get('id');
        $name = $chatData->get('first_name');
        $text = $messageData->get('text');

        Chat::firstOrCreate([
            'chat_id' => $chatId,
            'name' => $name
        ]);

        if ($text === '/start') {
            return $this->api->sendMessage([
                'chat_id' => $chatId,
                'text' => "Привет, {$name}. Для того, чтобы оставить напоминание, введи текст в формате Дата/Время/Текст напоминания."
            ]);
        }

        if ($text === '/add') {
            return $this->api->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Выберите дату',
                'reply_markup' => $this->api->inline
            ]);
        }
        */

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