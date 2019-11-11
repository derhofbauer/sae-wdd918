<?php

namespace Core\Libs;

class Session
{

    public static function init ()
    {
        session_start();
    }

    /**
     * Wert in die Session hinzufügen oder aktualisieren.
     */
    public static function add ($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Wert aus der Session auslesen.
     */
    public static function get ($key, $default = null)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Wert aus der Session löschen, sofern er gesetzt ist.
     */
    public static function delete ($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * gesamte Session löschen
     */
    public static function kill ()
    {
        session_destroy();
    }

}
