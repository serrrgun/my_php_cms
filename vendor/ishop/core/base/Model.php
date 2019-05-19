<?php

namespace ishop\base;

use ishop\Db;

abstract class Model {

    public $attributes = []; // массив свойств модели, который будет эдентичен полям в БД
    public $errors = [];
    public $rules = []; // для правил валиидации данных

    public function __construct() {

        Db::instance();
        
    }

}