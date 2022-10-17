<?php

namespace Hell\Mvc\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

use Hell\Mvc\Classes\Calendar;
use Hell\Mvc\Models\Notice;

class AddNoticeCommand extends Command
{
    protected $name = 'add_notice';

    protected $description = 'Команда /add_notice';

    public function handle()
    {
        $oldNotice = Notice::firstWhere('status', [Notice::STATUS_NEW, Notice::STATUS_PROCESSED]);

        if ($oldNotice->isNotEmpty) {
            $oldNotice->status = Notice::STATUS_CANCELLED;
            $oldNotice->save();
        }


        // Если у нас есть раннее уведомление в статусах "Новое", "В процессе" и мы снова сюда попадаем,
        // то это раннее уведомление нужно перенести в статус "Отменено".

        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => 'Выбери дату',
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => (new Calendar())->getCalendar((int)date('m'), (int)date('Y')),
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ])
        ]);


        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => 'Введите текст напоминания',
        ]);
    }

}