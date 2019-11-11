<?php

namespace App\Controllers;

/**
 * Der BaseController wird verwendet, damit wir jeden anderen Controller darauf aufbauen können und jeder andere
 * Controller $this->view automatisch bekommt und damit Templates laden kann.
 */
class BaseController
{

    protected $view;

    public function __construct ()
    {
        /**
         * neues View Objekt erstellen, damit wir Templates laden können.
         */
        $this->view = new \Core\View();
    }

}
