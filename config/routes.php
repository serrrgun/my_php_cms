<?php

use ishop\Router; // ипользуем класс Router

Router::add('^product/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Product', 'action' => 'view']);

// дефолтные маршруты для админки
Router::add('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']);   // вызываем метод add класса Router
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']); // вызываем метод add класса Router

// Дефолтные маршруты для сайта
Router::add('^$', ['controller' => 'Main', 'action' => 'index']); // вызываем метод add класса Router
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');   // вызываем метод add класса Router