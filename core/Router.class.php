<?php

use Core\Fm\Request;

class Router
{

    /**
     * Роуты заданные пользователем
     * @var array
     */
    public $routes = [
        'GET' => [],
        'POST' => [],
    ];
    public $method = 'index';
    public $default_controller;

    protected static $instance;

    public static function getInstance()
    {

        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function __construct()
    {

    }

    private function __clone()
    {

    }

    private function __wakeup()
    {

    }



    /**
     * Регистрирует GET маршруты
     * @param       $name
     * @param array $config
     */
    public function get($name, array $config)
    {
        array_push(self::getInstance()->routes['GET'], ['url' => $name, 'param' => $config]);
    }

    /**
     * Регистрирует POST маршруты
     * @param       $name
     * @param array $config
     */
    public function post($name, array $config)
    {
        array_push(self::getInstance()->routes['POST'], ['url' => $name, 'param' => $config]);
    }



    private function _getUserRoutes()
    {
        if (file_exists(APP_PATH . 'Config/routes.php')) {
            include(APP_PATH . 'Config/routes.php');
        }
    }

    public function request()
    {
        if (isset($_REQUEST['controller']))
            $this->controller = $_REQUEST['controller'];
        if (isset($_REQUEST['action']))
            $this->action = $_REQUEST['action'];
    }

    private function clearStartEndSlash($str)
    {
        return preg_replace("/^\\/|\\/?$/i", "", $str);
    }


    /**
     * Формирует массив параметров переданных в URL
     * @param $routeParams
     * @param $urlParams
     * @return array
     * @throws RouteNotRequiredParameterException
     */
    private function getControllerArg($routeParams , $urlParams){
        $methodArg = [];
        foreach ($routeParams as $k => $v){
            # Если параметр обязательный проверить что он передан и не пустой
            if(preg_match("/^\\{:/" , $v)) {
//                if(!key_exists($k , $urlParams) || empty($urlParams[$k]))
//                    throw new RouteNotRequiredParameterException($v);

                array_push($methodArg , $urlParams[$k]);

            } else { // Если параметр не обязательный передать, в том случае есть есть в URL
                if(key_exists($k , $urlParams) && !empty($urlParams[$k]))
                    array_push($methodArg , $urlParams[$k]);

            }
        }

        return $methodArg;
    }



    public function parse()
    {

        $request = new Request();
        # Подгружает пользовательские маршруты
        $this->_getUserRoutes();

        if (!empty($_REQUEST['route'])) {
            $url = $_REQUEST['route'];


            // Поиск заданых маршрутов
            $urlInRoutes = 0;
            $routeNotFound = true;
            foreach (self::getInstance()->routes[$request->type()] as $r) {

                $route = $r['url'];

                # Проверка на параметры
                preg_match_all('/(\\{:[^\\}]*\\})|(\\{\\?[^\\}]*\\})/', $route , $getParam);

                $cleanRoute = preg_replace("/(\\{:[^\\}]*\\}\\/?)|(\\{\\?[^\\}]*\\}\\/?)/i", "", $route);

                $cleanRoute = $this->clearStartEndSlash($cleanRoute);

                $urlInRoutes = preg_match("/^" . preg_quote($cleanRoute, "/") . "\\/?/i", $this->clearStartEndSlash($url));

                // Если есть параметры ссылка должна заканчиваться на / и дальше параметры. Совпадение только с начала строки
                if(!empty($getParam[0])){
                    $urlInRoutes = preg_match("/^" . preg_quote($cleanRoute, "/") . "\\//i", $this->clearStartEndSlash($url));

                }
                // Если нет параметров строка строго ^ $ и в конце может быть/не быть -  /
                else {
                    $urlInRoutes = preg_match("/^" . preg_quote($cleanRoute, "/") . "\\/?$/i", $this->clearStartEndSlash($url));

                }


                # Если страницу нашли
                if ($urlInRoutes === 1) {

                    $routeNotFound = false;
                    if(is_array($getParam) && !empty($getParam[0])){
                        # Получим параметры предусмотренные в маршруте
                        $routeParams = array_shift($getParam);
                        # Получим часть URL в которой должны быть параметры

                        $urlParams = $this->clearStartEndSlash(preg_replace("/^" . preg_quote($cleanRoute , '/') . "/" , "" , $url));

                        $urlParams = explode('/' , $urlParams);

                        // Подготовить параметры для передачи в Controller
                        $controllerArg = $this->getControllerArg($routeParams , $urlParams);



                        $controllerData = explode('@' , $r['param']['action']);
                        $pathToController = '\App\Controller\\' . $controllerData[0];

                        $controller = new $pathToController;
                        # Вызов Метода контролера
                        $controller->{$controllerData[1]}();


                    } else {

                        $controllerData = explode('@' , $r['param']['action']);
                        $pathToController = '\App\Controller\\' . $controllerData[0];

                        $controller = new $pathToController;
                        # Вызов Метода контролера
                        $controller->{$controllerData[1]}();


                    }



                }
            }

            # Если нет роута, выдать 404
            if($routeNotFound){
                $view = new \Core\App\View();
                header("HTTP/1.0 404 Not Found");
                $view->get404();
            }
        }
        # Если нет никаких страниц главная страница
        else {

            $homeController = '\App\Controller\HomeController';

            $controller = new $homeController;

            $controller->index();
        }


    }


    /**
     * Ищет URL маршрута по названию
     * @param $name
     *
     * @return null
     */
    public function getUrlByName($name)
    {
        $routesData = $this->routes;
        foreach ($routesData as $route){
            if(empty($route))
                continue;

            foreach ($route as $routeData){
                if(isset($routeData['param']['name']) && $routeData['param']['name'] == $name){
                    return $routeData['url'];
                }


            }

        }

        return NULL;
    }

}