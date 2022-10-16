<?php

namespace Hell\Mvc\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

use Hell\Mvc\Classes\Calendar;

class AddNoticeCommand extends Command
{
    protected $name = 'add_notice';

    protected $description = 'Команда /add_notice';

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => 'Выбери дату',
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => (new Calendar())->getCalendar((int)date('m'), (int)date('Y')),
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ])
        ]);
    }
}