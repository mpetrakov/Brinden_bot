<?php

namespace Hell\Mvc\Controllers;

use Telegram\Bot\Api;

use Hell\Mvc\Core\Controller;
use Hell\Mvc\Commands\StartCommand;
use Hell\Mvc\Commands\TestCommand;
use Hell\Mvc\Commands\AddNoticeCommand;
use Hell\Mvc\Actions\GetKeyboardCalendarAction;

class IndexController extends Controller
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api($_ENV['TELEGRAM_TOKEN']);

        $this->api->addCommands([
            StartCommand::class,
            AddNoticeCommand::class,
            TestCommand::class
        ]);
    }

    public function index()
    {
        $this->api->commandsHandler(true);

        $webhookData = $this->api->getWebhookUpdate();
        $callbackQuery = $webhookData->callbackQuery;

        file_put_contents(__DIR__ . '/../../message.txt', print_r($webhookData, true) . "\n", FILE_APPEND | LOCK_EX);

        if (is_null($callbackQuery)) {
            $this->success(['message' => 'Empty callbackQuery']);
        }

        $callbackData = collect(explode('-', $callbackQuery->get('data')));

        if ($callbackData->isNotEmpty()) {
            $chatId = $webhookData->getChat()->get('id');

            switch ($callbackData->get(0)) {
                case 'null_callback':
                    return $this->api->sendMessage([
                        'chat_id' => $chatId,
                        'text' => '🤙 Нужно сделать выбор!'
                    ]);
                case 'calendar':
                    return (new GetKeyboardCalendarAction($callbackData))->handle();
                default:
                    return $this->api->sendMessage([
                        'chat_id' => $chatId,
                        'text' => '🤕 Что-то пошло не так...'
                    ]);
            }
        }
    }
}