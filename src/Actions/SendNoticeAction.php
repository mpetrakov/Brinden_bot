<?php

namespace Hell\Mvc\Actions;

use Telegram\Bot\Api;

use Hell\Mvc\Models\Notice;

class SendNoticeAction
{
    public function handle()
    {
        $notices = Notice::where('status', Notice::STATUS_PLANNED)->get();

        if ($notices->isEmpty()) {
            return false;
        }

        $api = new Api($_ENV['TELEGRAM_TOKEN']);

        return $notices->each(function ($notice) use ($api) {
            if ($notice->date !== date('Y-m-d')) {
                return true;
            }

            $api->sendMessage([
                'chat_id' => $notice->chat->chat_id,
                'text' => "Новое уведомление!\n{$notice->text}"
            ]);

            $notice->status = Notice::STATUS_SEND;

            return $notice->save();
        });
    }
}