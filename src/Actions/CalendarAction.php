<?php

namespace Hell\Mvc\Actions;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

use Hell\Mvc\Classes\Calendar;

class CalendarAction
{
    private Collection $options;

    public function __construct(Collection $options)
    {
        $this->options = $options;
    }

    public function handle()
    {
        $calendar = new Calendar();
        $messageCalendar = [
            'inline_keyboard' => null,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ];

        switch ($this->options->get(1)) {
            case 'month':
                $messageCalendar['inline_keyboard'] = Keyboard::make($calendar->getCalendar((int)$this->options->get(2), (int)$this->options->get(3)));
                break;
            case 'year':
            case 'months_list':
                $messageCalendar['inline_keyboard'] = Keyboard::make($calendar->getMonthsList((int)$this->options->get(2)));
                break;
            case 'years_list':
                $messageCalendar['inline_keyboard'] = Keyboard::make($calendar->getYearsList((int)$this->options->get(2)));
                break;
        }

        $api = new Api($_ENV['TELEGRAM_TOKEN']);
        $webhookData = $api->getWebhookUpdate();

        if (is_null($messageCalendar['inline_keyboard'])) {
            return $api->sendMessage([
                'chat_id' => $webhookData->getChat()->get('id'),
                'text' => 'Произошла ошибка!'
            ]);
        }

        return $api->editMessageText([
            'chat_id' => $webhookData->getChat()->get('id'),
            'message_id' => $webhookData->getMessage()->get('id'),
            'reply_markup' => $messageCalendar
        ]);
    }
}