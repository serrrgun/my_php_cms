<?php

/** Базовый класс приложения */

namespace app\controllers;

use ishop\base\Controller;
use app\models\AppModel;

class AppController extends Controller {
    
    public function __construct($route) {
        
        parent::__construct($route);
        new AppModel();

    }

}