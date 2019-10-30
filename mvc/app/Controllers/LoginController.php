<?php

namespace App\Controllers;

class LoginController extends BaseController {

    public function showForm () {

        $this->view->render('login-form');

    }

}
