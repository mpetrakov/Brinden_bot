<?php

namespace Hell\Mvc\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    public const STATUS_NEW = 1;
    public const STATUS_PROCESSED = 2;
    public const STATUS_PLANNED = 3;
    public const STATUS_CANCELLED = 4;
    public const STATUS_SEND = 5;

    protected $fillable = [
        'chat_id', 'status', 'date', 'text'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}