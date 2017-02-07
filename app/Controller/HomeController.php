<?php

namespace App\Controller;

use Core\App\Controller;



class HomeController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $content = $this->view->page('homepage')->render(true);
        return $this->view->page('Layouts/app')
                          ->setData(['content' => $content])
                          ->render();
    }

    public function login()
    {
        $content = $this->view->page('Auth/Login12132')->render(true);
        return $this->view->page('Layouts/app')
            ->setData(['content' => $content])
            ->render();
    }
}