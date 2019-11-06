<?php

use Core\Libs\Session;

function set_csrf ()
{
    $csrf = uniqid();
    Session::add("csrf", $csrf);

    return $csrf;
}

function check_csrf ($csrf)
{
    return (Session::get('csrf') == $csrf) ? true : false;
    /**
     * Ident mit:
     *
     * if (Session::get('csrf') == $csrf) {
     *      return true;
     * } else {
     *      return false;
     * }
     */
}

/**
 * Aufruf:
 * - config('app.baseUrl')
 * - config('db.host')
 */
function config ($fileAndKey) {
    $config = [
        'db' => require __DIR__ . '/../config/db.php',
        'app' => require __DIR__ . '/../config/app.php',
    ];

    // $fileAndKey: "app.baseUrl"
    $file = explode('.', $fileAndKey)[0]; // $file: "app"
    $key = explode('.', $fileAndKey)[1]; // $key: "baseUrl"

    if (array_key_exists($file, $config) && array_key_exists($key, $config[$file])) {
        return $config[$file][$key]; // $config['app']['baseUrl']
    }
}
