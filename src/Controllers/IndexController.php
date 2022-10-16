<?php

namespace Hell\Mvc\Controllers;

use Telegram\Bot\Api;

use Hell\Mvc\Core\Controller;
use Hell\Mvc\Commands\StartCommand;
use Hell\Mvc\Commands\AddNoticeCommand;
use Hell\Mvc\Actions\CalendarAction;

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

        file_put_contents(__DIR__ . '/../../message.txt', print_r($webhookData, true) . "\n", FILE_APPEND | LOCK_EX);
        file_put_contents(__DIR__ . '/../../message.txt', print_r($callbackQuery, true) . "\n", FILE_APPEND | LOCK_EX);

        /*
        if ($callbackQuery->isNotEmpty()) {
            $callbackData = collect(explode('-', $callbackQuery->get('data')));
            file_put_contents(__DIR__ . '/../../message.txt', print_r($callbackData, true) . "\n", FILE_APPEND | LOCK_EX);
            if ($callbackData->isNotEmpty() && $callbackData[0] === 'calendar') {
                (new CalendarAction($callbackData))->handle();
            }
        }
        */
    }
}