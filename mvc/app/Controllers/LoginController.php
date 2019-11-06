<?php

namespace App\Controllers;

use App\Models\User;
use Core\Libs\Formbuilder;
use Core\Libs\Validator;

class LoginController extends BaseController
{

    public function showForm ()
    {

        $appConfig = require_once __DIR__ . '/../../config/app.php';

        $form = new Formbuilder("login", $appConfig['baseUrl'] . 'do-login'); // http://localhost:8080/mvc/do-login
        $form
            ->addInput('email', 'email', 'Email', ['placeholder' => "Email address", 'required' => 'true', 'autofocus' => 'true'])
            ->addInput('password', 'password', 'Password', ['placeholder' => 'Password', 'required' => 'true'])
            ->addButton('submit', 'Sign in');

        $params = [
            'form' => $form->output()
        ];
        $this->view->render('login-form', $params);

    }

    public function doLogin ()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $csrf_token = $_POST['csrf'];

        $errors = [];

        // Prüfen, ob der CSRF Token in der Session übereinstimmt --> s. helpers.php
        if (check_csrf($csrf_token) === false) {
            $errors[] = "Um Himmels Willen! Willst du uns hacken?!";
        } else {
            // Validierung der eingegebenen Daten
            $validator = new Validator();
            $validator->validate($email, "Email", true, 'email');
            $validator->validate($password, 'Password', true, 'password', 8);

            $validationErrors = $validator->getErrors();

            if ($validationErrors !== false) {
                $errors = $validationErrors;
            } else {
                // Existiert ein User mit der Email?
                $user = User::findByEmail($email);
                // existiert der User und ist das Passwort richtig?
                if ($user !== false && $user->checkPassword($password) === true) {
                    // Session setzen
                    $user->login(); // s. User Model

                    // Redirect
                    $baseUrl = config('app.baseUrl');
                    header("Location: $baseUrl");
                    exit;
                } else {
                    // es gibt keinen user mit der $email --> Fehler ausgeben
                    $errors[] = 'User existiert nicht oder Passwort ist falsch :(';
                }
            }
        }

        if (!empty($errors)) { // wenn es Fehler gibt
            $params = [
                'errors' => $errors
            ];
            $this->view->render('login-form', $params);
        }
    }

    public function doLogout () {
        User::logout();

        // Redirect
        $baseUrl = config('app.baseUrl');
        header("Location: {$baseUrl}login");
    }

}
