<?php

namespace App\Controllers;

class HomeController extends BaseController
{

    public function index ()
    {
        $params = [
            "welcome_message" => "HomeController Test"
        ];
        $this->view->addJs('assets/js/fancyAnimation.js');
        $this->view->render('home', $params);
    }

}
