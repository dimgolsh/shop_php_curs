<?php

class Router {

    private $routes;

    public function __construct() {

        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Returns request string
     * @return string
     */
    private function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
            //это если проект локальный и лежит в папке где то
            //  return substr($_SERVER['REQUEST_URI'],strlen('/testPegas/'));  
        }
    }

    public function run() {
        //  echo 'Class router, method run';
        //получть строку запроса
        $uri = $this->getURI();
        // echo $uri;
        //проверка наличие такого запрсоа в routes.php
        foreach ($this->routes as $uriPattern => $path) {

            //сравниваем // добавлен знак конца стороки по коммнту
            if (preg_match("~$uriPattern~", $uri)) {
                //if(preg_match("~^$uriPattern$~", $uri)){   
                /* echo '<br>Где ищем (запрос, который набрал)' .$uri;
                  echo '<br>Где ищем (запрос, совпадение)' .$uriPattern;
                  echo '<br>Где ищем (запрос, обработчик)' .$path; */


                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                // $internalRoute = preg_replace("~^$uriPattern$~", $path, $uri);
                // echo '<br><br> Нужно сформировать:'.$internalRoute;
                //echo "<br>$uriPattern->$path";
                // echo '+';
                $seqments = explode('/', $internalRoute);

                /* echo '<pre>';
                  print_r($seqments);
                  echo '<pre>'; */
                // $nullName =  array_shift($seqments); если оставлять в папке локально
                $controllerName = array_shift($seqments) . 'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = 'action' . ucfirst(array_shift($seqments));
                // echo '<br>Класс: '.$controllerName;
                // echo '<br>Метод: '.$actionName;
                $parameters = $seqments;
                // echo '<pre>';
                // print_r($parameters);
                // подкс класс контролелера
                $controllerFile = ROOT . '/controllers/' .
                        $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }
                //создать обьекто
                $controllerObject = new $controllerName;
                // old function
                //    $result = $controllerObject->$actionName($parameters);
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                }
            }
        }
    }

}
