ErrorHandler.php - описание основных функций для класса

error_reporting() ->  error_reporting ([ int $level ] ) -> https://www.php.net/manual/ru/function.error-reporting.php


set_exception_handler() -> Задает пользовательский обработчик исключений -> set_exception_handler ( callable $exception_handler ) ->
https://www.php.net/manual/ru/function.set-exception-handler.php


error_log() -> Отправляет сообщение об ошибке заданному обработчику ошибок -> 
error_log ( string $message [, int $message_type = 0 [, string $destination [, string $extra_headers ]]] ) ->
https://www.php.net/manual/ru/function.error-log.php

http_response_code() -> Получает или устанавливает код ответа HTTP -> http_response_code ([ int $response_code ] ) ->
https://www.php.net/manual/ru/function.http-response-code.php


/=============================================/

Router.php - описание основных функций для класса

preg_match() -> Выполняет проверку на соответствие регулярному выражению -> 
preg_match ( string $pattern , string $subject [, array &$matches [, int $flags = 0 [, int $offset = 0 ]]] ) ->
https://www.php.net/manual/ru/function.preg-match.php


class_exists() -> Проверяет, был ли объявлен класс -> class_exists ( string $class_name [, bool $autoload = TRUE ] ) ->
https://www.php.net/manual/ru/function.class-exists.php