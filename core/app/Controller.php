<?php

namespace Core\App;

use Core\Exception\RouteException;
use Core\App\View;

class Controller
{

    public function __construct()
    {
        $this->view = new View();
    }

    public function __call($name, $arguments)
    {

        if (!method_exists($this, $name))
            throw new RouteException("Controller " . get_class($this) . " not exist method {$name}");

    }

}