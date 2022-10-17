<?php

namespace Hell\Mvc\Controllers;

use Telegram\Bot\Api;

use Hell\Mvc\Core\Controller;
use Hell\Mvc\Commands\StartCommand;
use Hell\Mvc\Commands\AddNoticeCommand;
use Hell\Mvc\Actions\GetKeyboardCalendarAction;
use Hell\Mvc\Actions\AddTextAction;

class IndexController extends Controller
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api($_ENV['TELEGRAM_TOKEN']);

        $this->api->addCommands([
            StartCommand::class,
            AddNoticeCommand::class
        ]);
    }

    public function index()
    {
        $this->api->commandsHandler(true);

        $webhookData = $this->api->getWebhookUpdate();
        $callbackQuery = $webhookData->callbackQuery;
        $text = $webhookData->getMessage()->get('text');

        // file_put_contents(__DIR__ . '/../../message.txt', print_r($webhookData, true) . "\n", FILE_APPEND | LOCK_EX);

        if (!is_null($callbackQuery)) {
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

        if (!is_null($text)) {
            return (new AddTextAction($text))->handle();
        }
    }
}