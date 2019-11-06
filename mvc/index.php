<?php

use Core\Libs\Session;
use Core\Bootstrap;

/**
 * Einbinden der Helper Funktionen in den globalen
 * Scope, damit sie überall verfügbar sind
 */
require_once __DIR__ . '/core/helpers.php';

/**
 * Autoloader
 *
 * Die anonyme Funktion wird immer aufgerufen, wenn wir eine Klasse aufrufen
 */
spl_autoload_register(function ($class) {
    $class = str_replace("Core", "core", $class);
    $class = str_replace("App", "app", $class);
    $class = str_replace("\\", "/", $class);

    require_once __DIR__ . "/${class}.php";
});

/**
 * Session Initialisieren
 */
Session::init();

/**
 * Gesamtes Framework starten (Routing, Template Loading, etc.)
 */
$app = new Bootstrap();
