<?php

//** Класс базового контроллера */

namespace ishop\base;

abstract class Controller {


    /** Свойства базового контроллера */
    public $route;      // массив с текущим маршрутом
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = [];
    public $meta = ['title' => '', 'desc' => '', 'keywords' => ''];

    /** конструктор с данными
     * param $route - маршрут из адресной строки
     */
    public function __construct($route) {
        
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $route['action'];
        $this->prefix = $route['prefix'];


    }

    public function getView() {
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $viewObject->render($this->data);
    }

    public function set($data) {

        $this->data = $data;

    }

    public function setMeta($title = '', $desc = '', $keywords = '') {
        
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;

    }

    public function isAjax () {
        
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

    }

    public function loadView($view, $vars = []) {
        extract($vars);
        require APP . "/views/{$this->prefix}{$this->controller}/{$view}.php";
        die;
    }

}