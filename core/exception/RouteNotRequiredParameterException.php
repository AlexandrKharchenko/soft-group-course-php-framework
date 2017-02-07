<?php

namespace Core\Exception;


class RouteNotRequiredParameterException extends \Exception
{

    public function __construct($param) {
        parent::__construct();
    }

}