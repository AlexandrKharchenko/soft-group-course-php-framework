<?php


namespace Core\Fm;


/**
 * Class Config
 * @package Core\Fm
 */
class Config
{

    /**
     * @var
     */
    protected static $instance;

    /**
     * @var array
     */
    private static $config = [];


    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return static::$instance;
    }

    /**
     * Config constructor.
     */
    private function __construct()
    {

    }

    /**
     * Подгружает файлы конфигурации пользователя
     */
    public  static function loadConfig()
    {
        # Загрузить все конифги в массив конфигов
        $configList = glob(APP_PATH . 'Config/*.php');

        foreach ($configList as $config){
            $baseName = basename($config , '.php');
            ob_start();
                $config = include_once ($config);
            ob_end_clean();


            if(is_array($config)){
                print_r('<pre>'.(__FILE__).':'.(__LINE__).'<hr />'.print_r($baseName  ,true).'</pre>');
                self::$config[$baseName] = $config;
            }


        }

    }

    /**
     * @param      $config
     * @param null $key
     */
    public static function get($config , $key = null)
    {

        return isset(self::$config[$config][$key]) ? self::$config[$config][$key] : null;
    }
}