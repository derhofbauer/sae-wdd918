<?php

namespace App\Controllers;

class BaseController {

    protected $view;

    public function __construct ()
    {
        $this->view = new \Core\View();
    }

}
