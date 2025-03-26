<?php

namespace App;

class Controller
{
    protected function redirect($path)
    {
        header("location: http://" . $_SERVER['HTTP_HOST'] . $path);
    }

    protected function render($view, $data = [])
    {
        extract($data);
        include "Views/$view.php";
    }
}