<?php

namespace ishop;

class Router {

    /** Здесь будет хранится табли ца маршрутов */
    protected static $routes = [];

    /** Здесь будет хранится текущий маршрут если найдено соответствие запрошенного адреса с адресов в таблице $routes */
    protected static $route = [];

    /** Метод будет записывать правила в таблицу маршрутов
     *  $regexp - регулярное выражение адреса
     *  $route  - маршрут (опционален), можно записать кокретный контроллер, который будет соответствовать шаблону рег. выражения
    */
    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route;
    }

    /** Метод будет возвращать таблицу маршрутов (для тестирования) */
    public static function getRoutes() {
        return self::$routes;
    }

    /** Метод будет возвращать текущий маршрут (для тестирования) */
    public static function getRoute() {
        return self::$route;
    }

    /** Метод, который принимает url адрес  */
    public static function dispatch($url) {
        if(self::matchRoute($url)) {
           $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';
           if(class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                if(method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                }else {
                    throw new \Exception("Метод $controller::$action не найден", 404);
                }
           }else {
                throw new \Exception("Контроллер $controller не найден", 404);
           }
        }else {
            throw new \Exception("Страница не найдена", 404);
        }
    }

    /** Метод, который принимае url адрес и сравнивает с таблицой маршрутов  */
    public static function matchRoute($url) {
        foreach(self::$routes as $pattern => $route) {
            if(preg_match("#{$pattern}#", $url, $matches)) {
                foreach($matches as $k => $v) {
                    if(is_string($k)) {
                        $route[$k] = $v;
                    }
                }
                if(empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if(!isset($route['prefix'])) {
                    $route['prefix'] = '';
                }else {
                    $route['prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /** приводит наименование к формату CamelCase */
    protected static function upperCamelCase($name) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /** приводит наименование к формату camelCase */
    protected static function lowerCamelCase($name) {
        return lcfirst(self::upperCamelCase($name));
    }

}