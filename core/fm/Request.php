<?php

namespace Core\Fm;


class Request
{
    private $request;

    public function __construct()
    {
        $this->REQUEST = $_REQUEST;
        $this->SERVER = $_SERVER;
    }


    public function get()
    {
        
    }

    public function isPost()
    {
        return $this->SERVER['REQUEST_METHOD'] == "POST";
    }

    public function isGet()
    {
        return $this->SERVER['REQUEST_METHOD'] == "GET";
    }

    public function type()
    {
        return $this->SERVER['REQUEST_METHOD'];
    }

    public function getRoutePath()
    {
        return (isset($this->REQUEST['route'])) ? $this->REQUEST['route'] : '/';
    }
}