<?php

include('vendor/autoload.php'); //Подключаем библиотеку

use Telegram\Bot\Api;

$telegram = new Api('5657397166:AAHyCb9G3B8mRwsubvOgdI07VRjpJPSvHQY'); //Устанавливаем токен, полученный у BotFather
$result = $telegram->getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

file_put_contents(__DIR__ . '/message.txt', print_r($result, true));

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