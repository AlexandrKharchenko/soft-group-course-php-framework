<?php

namespace Core\Exception;


class RouteException extends \Exception
{

    public function __construct($message, $code = NULL)
    {
        parent::__construct($message, $code = NULL);
    }


    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
        . "{$this->getTraceAsString()}";
    }




}