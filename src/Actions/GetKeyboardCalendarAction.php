<?php

namespace Hell\Mvc\Actions;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

use Hell\Mvc\Classes\Calendar;

class GetKeyboardCalendarAction
{
    private Collection $options;

    public function __construct(Collection $options)
    {
        $this->options = $options;
    }

    public function handle()
    {
        $calendar = new Calendar();
        $keyboardCalendar = null;
        $selectedDay = null;

        switch ($this->options->get(1)) {
            case 'month':
                $keyboardCalendar = $calendar->getCalendar((int)$this->options->get(2), (int)$this->options->get(3));
                break;
            case 'year':
            case 'months_list':
                $keyboardCalendar = $calendar->getMonthsList((int)$this->options->get(2));
                break;
            case 'years_list':
                $keyboardCalendar = $calendar->getYearsList((int)$this->options->get(2));
                break;
            case 'day':
                $selectedDay = "{$this->options->get(4)}-{$this->options->get(3)}-{$this->options->get(2)}";
                break;
        }

        $api = new Api($_ENV['TELEGRAM_TOKEN']);
        $webhookData = $api->getWebhookUpdate();
        $chatId = $webhookData->getChat()->get('id');

        if (is_null($keyboardCalendar) && is_null($selectedDay)) {
            return $api->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Произошла ошибка!'
            ]);
        }

        if (is_null($keyboardCalendar) && !is_null($selectedDay)) {
            return $api->sendMessage([
                'chat_id' => $chatId,
                'text' => "Ты выбрал: {$selectedDay}"
            ]);
        }

        return $api->editMessageReplyMarkup([
            'chat_id' => $chatId,
            'message_id' => $webhookData->getMessage()->get('message_id'),
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => $keyboardCalendar,
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ])
        ]);
    }
}