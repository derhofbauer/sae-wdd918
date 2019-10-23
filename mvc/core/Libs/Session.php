<?php

namespace Core\Libs;

class Session
{

    public static function init ()
    {
        session_start();
    }

    public static function add ($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get ($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    public static function delete ($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function kill ()
    {
        session_destroy();
    }

}
