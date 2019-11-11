<?php

use Core\Libs\Session;

/**
 * Setzt einen CSRF Token
 *
 * s. https://de.wikipedia.org/wiki/Cross-Site-Request-Forgery
 */
function set_csrf ()
{
    $csrf = uniqid();
    Session::add("csrf", $csrf);

    return $csrf;
}

/**
 * Prüft einen CSRF Token aus der Sessions
 */
function check_csrf ($csrf)
{
    return (Session::get('csrf') == $csrf) ? true : false;
    /**
     * * Ternary Operator / Short-hand If
     * s. https://de.wikipedia.org/wiki/Bedingte_Anweisung_und_Verzweigung#Auswahloperator

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
 * holt einen Wert aus den Config files
 *
 * Beispiele:
 * - config('app.baseUrl')
 * - config('db.host')
 */
function config ($fileAndKey) {
    /**
     * Laden der Config-Files
     */
    $config = [
        'db' => require __DIR__ . '/../config/db.php',
        'app' => require __DIR__ . '/../config/app.example.php',
    ];

    // $fileAndKey: "app.baseUrl"
    $file = explode('.', $fileAndKey)[0]; // $file: "app"
    $key = explode('.', $fileAndKey)[1]; // $key: "baseUrl"

    // wenn "db"/"app" existiert und "baseUrl"/"host"/etc., dann geben wir es zurück
    if (array_key_exists($file, $config) && array_key_exists($key, $config[$file])) {
        return $config[$file][$key]; // $config['app']['baseUrl']
    } else {
        return null;
    }
}
