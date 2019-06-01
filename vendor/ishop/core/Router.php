<?php

/** Класс маршрутизатора */

namespace ishop;

class Router {

    /** Здесь будет хранится таблица маршрутов */
    protected static $routes = [];

    /** Здесь будет хранится текущий маршрут если найдено соответствие запрошенного адреса с адресов в таблице $routes */
    protected static $route = [];

    /** Метод будет записывать правила в таблицу маршрутов
     *  $regexp - регулярное выражение адреса
     *  $route  - маршрут (опционален), можно записать кокретный контроллер, который будет соответствовать шаблону рег. выражения
    */
    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route;  // записываем в таблицу маршрутов соответствие для данного маршрута
    }

    /** Метод будет возвращать таблицу маршрутов (для тестирования) */
    public static function getRoutes() {
        return self::$routes;  // возвращает таблицу маршрутов
    }

    /** Метод будет возвращать текущий маршрут (для тестирования) */
    public static function getRoute() {
        return self::$route;  // возвращает текущий маршрут
    }

    /** Метод, который принимает url адрес  */
    public static function dispatch($url) {

        $url = self::removeQueryString($url);
        if(self::matchRoute($url)) {            // если метод  matchRoute вернёт true, т.е если url адрес существует и должны вернуть какой то контроллер
           $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller'; // создаем переменную $controller 
           if(class_exists($controller)) {                          // если имя класса существует (класс был объявлен)
                $controllerObject = new $controller(self::$route);  // если такой класс существует, то создаем его объект
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';  // находим экшен класса 
                if(method_exists($controllerObject, $action)) {      // проверяет есть ли такой метод у класса
                    $controllerObject->$action();
                    $controllerObject->getView();
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
        foreach(self::$routes as $pattern => $route) {       // проходимся циклом по таблице маршрутов $routes и отдельно получаем шаблон $pattern регю выражения и соответвия для него $route
            if(preg_match("#{$pattern}#i", $url, $matches)) { // условие возьмет шаблон и сравнит с переданным url адресом, если соответствие будет найдено то помещаем в переменную $matches
                foreach($matches as $k => $v) {              // если найдено соответствие, то проходимся циклом по массиву $matches и возьмем отдельно ключ $k и отдельно значение $v
                    if(is_string($k)) {                      // проверим, если ключ является строкой, то он нужен и  
                        $route[$k] = $v;
                    }
                }
                if(empty($route['action'])) {       // если пуст $route['action']
                    $route['action'] = 'index';     // тогда присвоим $route['action'] строку 'index', т.е. экшеном по умолчанию будет index
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

    protected static function removeQueryString($url) {
        if($url) {
            $params = explode('&', $url, 2);
            if(false === strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            }else {
                return '';
            }
        }
    }

}