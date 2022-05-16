<?php
session_start();
define("URL", "http://" . $_SERVER["HTTP_HOST"]);
define('S', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT . S . 'views');


require_once(ROOT . S . 'lib' . S . 'init.php');




App::Run($_SERVER['REQUEST_URI']);


