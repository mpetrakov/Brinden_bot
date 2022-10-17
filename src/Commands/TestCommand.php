<?php

namespace Hell\Mvc\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class TestCommand extends Command
{
    protected $name = 'test';

    protected $description = 'Команда /test';

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage(['text' => "Это тестовая команда, бро"]);
    }
}