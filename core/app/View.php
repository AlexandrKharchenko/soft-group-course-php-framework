<?php

namespace Core\App;


/**
 * Class View
 * @package Core\App
 */
class View
{
    /**
     * @var array
     */
    private $data = [];
    /**
     * @var
     */
    private $rendered;
    /**
     * @var
     */
    private $page;

    /**
     * @param array $data
     *
     * @return $this
     */

    private $page404 = VIEW_DIR . "errors/404.php";

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }


    /**
     * @param $path
     *
     * @return $this
     */
    public function page($path)
    {
        $this->page = $path;

        return $this;
    }

    /**
     * @param bool $return
     *
     * @return string
     */
    public function render($return = false)
    {

        $existFile = $this->_checkFileExit(VIEW_DIR . "{$this->page}.php");
//
//        if($existFile == false)
//            $this->get404();



        extract($this->data);
        if ($return == false) {
            include_once(APP_PATH . "View/{$this->page}.php");
            $this->_resetView();
        } else {
            ob_start();
            include APP_PATH . "View/{$this->page}.php";
            $rendered = ob_get_contents();
            ob_end_clean();
            $this->_resetView();
            return $rendered;
        }

    }


    /**
     *
     */
    private function _resetView()
    {
        $this->page = NULL;
        $this->data = [];
        $this->rendered = NULL;
    }

    /**
     * @param $path
     *
     * @return bool
     */
    private function _checkFileExit($path){

        if(file_exists($path))
            return true;
        else
            false;


    }

    public function get404()
    {
        $exist404 =  $this->_checkFileExit($this->page404);

        if($exist404){
            include_once $this->page404;
            exit;
        } else {
            die('View template not found');
        }
    }
}