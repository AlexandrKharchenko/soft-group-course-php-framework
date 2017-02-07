<?php

namespace App\Controller;

use Core\App\Controller;
use Core\App\Model;
use Core\Fm\Config;
use Core\Fm\Db;


class HomeController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $db = Db::getInstance();
        print_r('<pre>'.(__FILE__).':'.(__LINE__).'<hr />'.print_r( $db ,true).'</pre>');

        $model = new Model();

        $model->select();

        $content = $this->view->page('homepage')->render(true);
        return $this->view->page('Layouts/app')
                          ->setData(['content' => $content])
                          ->render();
    }


}