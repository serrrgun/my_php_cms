<?php

namespace app\controllers;

use ishop\Cache;

class MainController extends AppController {

    public function indexAction() {

        //echo __METHOD__;

        $posts = \R::findAll('test');
        
        $this->setMeta('Интернет-магазин Luxury', 'Описание', 'Ключевики');
        $names = ['Sergey', 'Darya', 'Alice', 'Platon'];
        $cache = Cache::instance();
        
        //$cache->delete('test');
        $data = $cache->get('test');
        if(!$data) {
            $cache->set('test', $names);
        }
        debug($data);
        $this->set(compact('posts'));
        
        
    }

}