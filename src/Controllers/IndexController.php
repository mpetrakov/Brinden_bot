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
        file_put_contents(__DIR__ . '/../../message.txt', print_r($this->api->getWebhookUpdate(), true) . "\n", FILE_APPEND | LOCK_EX);

        $this->api->commandsHandler(true);
    }
}