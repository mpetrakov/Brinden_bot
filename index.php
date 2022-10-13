<?php
include('vendor/autoload.php'); //Подключаем библиотеку
use Telegram\Bot\Api;


$data = file_get_contents('php://input');
$data = json_decode($data, true);

file_put_contents(__DIR__ . '/message.txt', print_r($data, true));

if (empty($data['message']['chat']['id'])) {
    exit();
}

const TOKEN = '5657397166:AAHyCb9G3B8mRwsubvOgdI07VRjpJPSvHQY';

// Функция вызова методов API.
function sendTelegram($method, $response)
{
    $ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);

    return $res;
}

// Ответ на текстовые сообщения.
if (!empty($data['message']['text'])) {
    $text = $data['message']['text'];

    if (mb_stripos($text, 'привет') !== false) {
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => 'Хай!'
            )
        );
        exit();
    }
}






//
//$telegram = new Api('5657397166:AAHyCb9G3B8mRwsubvOgdI07VRjpJPSvHQY'); //Устанавливаем токен, полученный у BotFather
//$result = $telegram->getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
//
//$text = $result["message"]["text"]; //Текст сообщения
//$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
//$name = $result["message"]["from"]["username"]; //Юзернейм пользователя
//$keyboard = [["Последние статьи"], ["Картинка"], ["Гифка"]]; //Клавиатура
//
//if ($text) {
//    if ($text == "/start") {
//        $reply = "Добро пожаловать в бота!";
//        $reply_markup = $telegram->replyKeyboardMarkup([
//            'keyboard' => $keyboard,
//            'resize_keyboard' => true,
//            'one_time_keyboard' => false
//        ]);
//        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);
//    } elseif ($text == "/help") {
//        $reply = "Информация с помощью.";
//        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
//    } else {
//        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => "Отправьте текстовое сообщение."]);
//    }
//}