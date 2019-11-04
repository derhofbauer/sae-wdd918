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
     * if (Session::get('csrf') == $csrf) {
     *      return true;
     * } else {
     *      return false;
     * }
     */
}
