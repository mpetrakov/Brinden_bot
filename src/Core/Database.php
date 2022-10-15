<?php

namespace Hell\Mvc\Core;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    public static function bootEloquent()
    {
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => $_ENV['DATABASE_DRIVER'],
            'host' => $_ENV['DATABASE_HOST'],
            'port' => $_ENV['DATABASE_PORT'],
            'database' => $_ENV['DATABASE_NAME'],
            'username' => $_ENV['DATABASE_USER'],
            'password' => $_ENV['DATABASE_PASSWORD']
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}