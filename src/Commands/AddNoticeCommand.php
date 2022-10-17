<?php

namespace Hell\Mvc\Commands;

use Telegram\Bot\Api;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

use Hell\Mvc\Classes\Calendar;
use Hell\Mvc\Models\Chat;
use Hell\Mvc\Models\Notice;

class AddNoticeCommand extends Command
{
    protected $name = 'add_notice';

    protected $description = 'Команда /add_notice';

    public function handle()
    {
        $webhookData = (new Api($_ENV['TELEGRAM_TOKEN']))->getWebhookUpdate();
        $currentChat = Chat::firstWhere('chat_id', $webhookData->getChat()->get('id'));

        Notice::where('status', [Notice::STATUS_NEW, Notice::STATUS_PROCESSED])
            ->where('chat_id', $currentChat->id)
            ->update(['status' => Notice::STATUS_CANCELLED]);

        Notice::create([
            'chat_id' => $currentChat->id,
            'status' => Notice::STATUS_NEW
        ]);

        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => '📅 Выбери дату',
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => (new Calendar())->getCalendar((int)date('m'), (int)date('Y')),
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ])
        ]);

        $this->triggerCommand('test');
    }
}