<?php

/** Класс обработки ошибок */

namespace ishop;

class ErrorHandler {
    
    /** Описание конструктора класса, нужен для того чтобы узнать состояние константы DEBAG (режим разработки или режим продакшена) */
    public function __construct() {

        if(DEBUG) {                                             // проверяем состояние крнстанты DEBAG
            error_reporting(-1);                                // если включен то показываем все ошибки
        } else {
            error_reporting(0);                                 // если выключен, то выключаем показ ошибок
        }
        set_exception_handler([$this, 'exceptionHandler']);     // позволяет назначить для обработки исключений свою функцию метод (exceptionHandler)
        
    }

    /** Метод который, будет обрабатывать перехваченные исключения 
     *  param $e -  объект исключений
    */
    public function exceptionHandler($e) {
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());   // вызываем метод logErrors 
        $this->displayError('Исключения', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());  // вызываем метод displayError
    }

    /** Метод для логирования ошибок и запись в файл errors.log
     *  param $message - текст исключеения (ошибки) по умолчанию пустая строка
     *  param $file    - файл в котором произошла ошибка по умолчанию пустая строка
     *  param $line    - сторока в которой произошла ошибка по умолчанию пустая строка
    */
    protected function logErrors($message = '', $file = '', $line = '') {
        
        /** формирует текст ошибки */
        error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$message} | Файл: {$file} | Строка: {$line}\n=============================\n", 3, ROOT . '/tmp/errors.log');

    }
    
    /** Метод для вывода ошибок 
     *  param $errno    - номер ошибки
     *  param $errstr   - текст ошибки
     *  param $errfile  - файл, в котором произошла ошибка
     *  param $errline  - строка на которой произошла ошибка  
     *  param $responce - http код который нужно отправить браузеру
    */
    protected function displayError($errno, $errstr, $errfile, $errline, $responce = 404) {

        http_response_code($responce); // получет http код ошибки

        if($responce == 404 && !DEBUG) {
            require WWW . '/errors/404.php';
            die;
        }
        if(DEBUG) {
            require WWW . '/errors/dev.php';
        }else {
            require WWW . '/errors/prod.php';
        }
        die;

    }

}