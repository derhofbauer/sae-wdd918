<?php

namespace App\Controllers;

use Core\Libs\Formbuilder;
use Core\Libs\Validator;

class LoginController extends BaseController
{

    public function showForm ()
    {

        $appConfig = require_once __DIR__ . '/../../config/app.php';

        $form = new Formbuilder("login", $appConfig['baseUrl'] . 'do-login'); // http://localhost:8080/mvc/do-login
        $form
            ->addInput('email', 'Email', 'Email', ['placeholder' => "Email address", 'required' => 'true', 'autofocus' => 'true'])
            ->addInput('password', 'Password', 'Password', ['placeholder' => 'Password', 'required' => 'true'])
            ->addButton('submit', 'Sign in');

        $params = [
            'form' => $form->output()
        ];
        $this->view->render('login-form', $params);

    }

    public function doLogin () {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $csrf_token = $_POST['csrf'];

        $errors = [];

        if (check_csrf($csrf_token) === false) {
            $errors[] = "Um Himmels Willen! Willst du uns hacken?!";
        } else {
            // Validierung
            $validator = new Validator();
            $validator->validate($email, "Email", true, 'email');
            $validator->validate($password, 'Password', true, 'password', 8);

            $validationErrors = $validator->getErrors();

            if ($validationErrors !== false) {
                $errors = $validationErrors;
            } else {
                // Existiert ein User mit der Email?
                // wenn ja: Passwort prüfen (Vorsicht: Hash!)
                // wenn nein: Fehler ausgeben
            }
        }

        if (!empty($errors)) {
            $params = [
                'errors' => $errors
            ];
            $this->view->render('login-form', $params);
        }
    }

}
