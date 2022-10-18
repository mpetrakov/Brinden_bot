<?php

namespace Hell\Mvc\Actions;

use Telegram\Bot\Api;

use Hell\Mvc\Models\Notice;

class PlannedNoticeAction
{
    public function handle()
    {
        $notices = Notice::where('status', Notice::STATUS_PLANNED)->get();

        if ($notices->isEmpty()) {
            return false;
        }

        $api = new Api($_ENV['TELEGRAM_TOKEN']);

            $api->sendMessage([
                'chat_id' => $notices->chat->chat_id,
                'text' => "Напоминание запланировано!\n{$notices->text}"
            ]);

            $notices->save();
    }
}