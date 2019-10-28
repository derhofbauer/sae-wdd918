<?php

//ini_set('display_errors', 'On');
//error_reporting('E_ALL');

// phpinfo();

use Core\Libs\Session;
use Core\Bootstrap;

/**
 * Autoloader
 */
spl_autoload_register(function ($class) {
    $class = str_replace("Core", "core", $class);
    $class = str_replace("App", "app", $class);
    $class = str_replace("\\", "/", $class);

    require_once __DIR__ . "/${class}.php";
});


Session::init();

$app = new Bootstrap();
