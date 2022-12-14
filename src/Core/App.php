<?php

namespace Hell\Mvc\Core;

class App
{
    public static function run()
    {
        Database::bootEloquent();

        $controller_name = "Hell\\Mvc\\Controllers\\IndexController";
        $action_name = "index";

        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        if ($path !== "") {
            @list($controller, $action) = explode("/", $path, 2);
            if (isset($controller)) {
                $controller_name = "Hell\\Mvc\\Controllers\\{$controller}Controller";
            }
            if (isset($action)) {
                $action_name = $action;
            }
        }

        if (!class_exists($controller_name, true)) {
            View::render('404');
        }

        if (!method_exists($controller_name, $action_name)) {
            View::render('404');
        }

        $controller = new $controller_name();
        $controller->$action_name();
    }
}