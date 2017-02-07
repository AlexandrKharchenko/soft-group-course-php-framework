<?php

namespace App\Controller;

use Core\App\Controller;
use Core\Fm\Request;


class AuthController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function showLogin()
    {
        $content = $this->view->page('Auth/Login')->render(true);

        return $this->view->page('Layouts/app')
            ->setData(['content' => $content])
            ->render();
    }

    public function showRegister()
    {
        $content = $this->view->page('Auth/Register')->render(true);

        return $this->view->page('Layouts/app')
            ->setData(['content' => $content])
            ->render();
    }
}