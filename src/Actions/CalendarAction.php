<?php

namespace Hell\Mvc\Actions;

use Illuminate\Support\Collection;

class CalendarAction
{
    private Collection $options;

    public function __construct(Collection $options)
    {
        $this->options = $options;
    }

    public function handle()
    {
        file_put_contents(__DIR__ . '/../../message.txt', print_r($this->options, true) . "\n", FILE_APPEND | LOCK_EX);
    }
}