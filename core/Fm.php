<?php


/**
 * Class Fm
 */
class Fm
{
    /**
     * @var
     */
    protected static $instance;

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Fm constructor.
     */
    protected function __construct()
    {

    }

    /**
     *
     */
    private function __clone()
    {
    }

    /**
     *
     */
    private function __wakeup()
    {
    }

    /**
     * Запускает работу прилижения
     */
    public  function run(){

        # Запуск маршуртизатора
        Router::getInstance()->parse();
    }
}