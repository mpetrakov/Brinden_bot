<?php

require_once '../vendor/autoload.php';

use Dotenv\Dotenv;
use Hell\Mvc\Core\App;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

App::run();