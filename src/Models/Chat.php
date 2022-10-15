<?php

namespace Hell\Mvc\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'chat_id', 'name'
    ];
}