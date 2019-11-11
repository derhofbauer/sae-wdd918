<?php

namespace App\Controllers;

use App\Models\User;
use Core\Libs\Formbuilder;
use Core\Libs\Validator;

class SignupController extends BaseController
{

    public function showForm ()
    {
        $form = new Formbuilder("signup", config('app.baseUrl') . 'do-signup'); // http://localhost:8080/mvc/do-signup
        $form
            ->addInput('text', 'username', 'Username', ['placeholder' => "Username"])
            ->addInput('email', 'email', 'Email *', ['placeholder' => "Email address", 'required' => 'true', 'autofocus' => 'true'])
            ->addInput('password', 'password', 'Password *', ['placeholder' => 'Password', 'required' => 'true'])
            ->addInput('password', 'password_repeat', 'Password (repeat) *', ['placeholder' => 'Please repeat the password', 'required' => 'true'])
            ->addButton('submit', 'Sign up');

        $params = [
            'form' => $form->output()
        ];
        $this->view->render('signup-form', $params);
    }

    /**
     * Kommentare s. LoginController
     */
    public function doSignup ()
    {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $password_repeat = $_POST['password_repeat'];
        $username = trim($_POST['username']);
        $csrf_token = $_POST['csrf'];

        $errors = [];

        if (check_csrf($csrf_token) === false) {
            $errors[] = "Um Himmels Willen! Willst du uns hacken?!";
        } else {
            if (User::isLoggedin() !== true) {
                $validator = new Validator();
                $validator->validate($email, "Email", true, 'email');
                $validator->validate($password, 'Password', true, 'password', 8);
                $validator->compare([$password, 'Password'], [$password_repeat, 'Password (repeat)']);
                $validator->validate($username, "Username", false, 'textnum', 3);

                $errors = $validator->getErrors();

                $regex_special_chars = "/[!§$%&._\-*?]+/";
                $regex_uppercase_chars = "/[A-Z]+/";
                $regex_number = "/[0-9]+/";
                $regex_whitespace = "/\s+/";
                $regex_lowercase_chars = "/[a-z]+/";
                if (
                    preg_match($regex_special_chars, $password) !== 1 ||
                    preg_match($regex_uppercase_chars, $password) !== 1 ||
                    preg_match($regex_number, $password) !== 1 ||
                    preg_match($regex_whitespace, $password) === 1 ||
                    preg_match($regex_lowercase_chars, $password) !== 1
                ) {
                    $errors[] = "Das Passwort erfüllt nicht die Kriterien (mind. 1 UPPERCASE, 1 lowercase, 1 Z1ff3r, 1 Sonderzeichen, kein Whitespace)";
                }

                $userThatMightAlreadyExistEmail = User::findByEmail($email);
                if ($userThatMightAlreadyExistEmail !== false) {
                    $errors[] = "Email Adresse wird bereits verwendet. Bitte wählen Sie einen andere.";
                }

                if (!empty($username)) {
                    $userThatMightAlreadyExistUsername = User::findByUsername($username);
                    if ($userThatMightAlreadyExistUsername !== false) {
                        $errors[] = "Username wird bereits verwendet. Bitte wählen Sie einen anderen.";
                    }
                }

                if (empty($errors)) {
                    $newUser = new User();

                    if (!empty($username)) $newUser->username = $username;

                    $newUser->email = $email;
                    $newUser->setPassword($password);

                    $newUser->save();

                    // Redirect
                    $baseUrl = config('app.baseUrl');
                    header("Location: $baseUrl");
                    exit;
                } else {
                    $params = [
                        'errors' => $errors
                    ];
                    var_dump($errors);
                    $this->view->render('signup-form', $params);
                }
            }
        }
    }

}
