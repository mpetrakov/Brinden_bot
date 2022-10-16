<?php

namespace Hell\Mvc\Controllers;

use Telegram\Bot\Api;

use Hell\Mvc\Core\Controller;
use Hell\Mvc\Commands\StartCommand;
use Hell\Mvc\Commands\AddNoticeCommand;

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

        if ($callbackQuery->isNotEmpty()) {
            file_put_contents(__DIR__ . '/../../message.txt', print_r($webhookData->callbackQuery->get('data'), true) . "\n", FILE_APPEND | LOCK_EX);
        }
    }
}