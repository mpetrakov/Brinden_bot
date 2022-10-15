<?php

namespace Hell\Mvc\Core;

class View
{
    static function render(string $view, array $data = [])
    {
        extract($data, EXTR_OVERWRITE);
        $path = implode(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'src', 'Views', "$view.php"]);
        if (file_exists($path)) {
            require_once $path;
        } else {
            echo 'Данная страница не существует';
        }
    }
}