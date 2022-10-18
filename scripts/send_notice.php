<?php

require_once 'C:/OpenServer/domains/Brinden_bot/vendor/autoload.php';

use Dotenv\Dotenv;
use Hell\Mvc\Core\Database;
use Hell\Mvc\Actions\SendNoticeAction;


$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

Database::bootEloquent();

(new SendNoticeAction())->handle();