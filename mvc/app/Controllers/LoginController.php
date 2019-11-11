<?php

namespace App\Controllers;

use App\Models\User;
use Core\Libs\Formbuilder;
use Core\Libs\Validator;

class LoginController extends BaseController
{

    public function showForm ()
    {
        /**
         * Action für das HTML-Formular erzeugen
         *
         * hier: http://localhost:8080/mvc/do-login
         */
        $htmlAction = config('app.baseUrl') . 'do-login';

        /**
         * neues Formbuilder Objekt erstellen und Werte für den `<form>` Tag übergeben
         */
        $form = new Formbuilder("login", $htmlAction);

        /**
         * Felder im Formular hinzufügen
         */
        $form
            ->addInput('email', 'email', 'Email', ['placeholder' => "Email address", 'required' => 'true', 'autofocus' => 'true'])
            ->addInput('password', 'password', 'Password', ['placeholder' => 'Password', 'required' => 'true'])
            ->addButton('submit', 'Sign in');

        /**
         * $form->output() generiert das fertige HTML. Hier übergeben wir es in die Parameter für das Template
         */
        $params = [
            'form' => $form->output()
        ];

        /**
         * Template Loading starten
         */
        $this->view->render('login-form', $params);

    }

    public function doLogin ()
    {
        /**
         * Werte aus der Superglobal in leichter tippbare Variablen schreiben.
         */
        $email = $_POST['email'];
        $password = $_POST['password'];
        $csrf_token = $_POST['csrf'];

        /**
         * Fehler-Array initialisieren
         */
        $errors = [];

        /**
         * Prüfen, ob der CSRF Token in der Session übereinstimmt --> s. helpers.php
         */
        if (check_csrf($csrf_token) === false) {

            /**
             * Ist der CSRF Token falsch, schreiben wir einen Error in das $errors Array
             */
            $errors[] = "Um Himmels Willen! Willst du uns hacken?!";

        } else {
            /**
             * Ist der CSRF Token richtig, validieren wir die Daten aus dem Formular
             */

            /**
             * neues Validator Objekt instanzieren
             */
            $validator = new Validator();

            /**
             * Email-Adresse und Passwort validieren.
             *
             * Um herauszufinden, was die einzelnen Parameter sind, schaut bitte in Validator.php
             */
            $validator->validate($email, "Email", true, 'email');
            $validator->validate($password, 'Password', true, 'password', 8);

            /**
             * Potentielle Validierungsfehler abrufen
             */
            $validationErrors = $validator->getErrors();

            /**
             * Wenn es validierungsfehler gibt, schreiben wir sie in unser $errors Array
             */
            if ($validationErrors !== false) {
                $errors = $validationErrors;
            } else {
                /**
                 * Wenn es keine Validierungsfehler gibt, suchen wir nach einem User, der die eingegeben
                 * Email-Adresse hat
                 */
                $user = User::findByEmail($email);

                /**
                 * existiert der User und ist das Passwort richtig?
                 */
                if ($user !== false && $user->checkPassword($password) === true) {
                    /**
                     * Session setzen
                     *
                     * s. User Model
                     */
                    $user->login();

                    /**
                     * Redirect
                     */
                    $baseUrl = config('app.baseUrl');
                    header("Location: $baseUrl");
                    exit;
                } else {
                    /**
                     * es gibt keinen user mit der $email --> Fehler in $errors hinzufügen
                     */
                    $errors[] = 'User existiert nicht oder Passwort ist falsch :(';
                }
            }
        }

        /**
         * wenn es Fehler gibt, laden wir das login-form Template erneut und übergeben die Fehler an dieses Template
         */
        if (!empty($errors)) {
            $params = [
                'errors' => $errors
            ];
            $this->view->render('login-form', $params);
        }
    }

    public function doLogout () {
        /**
         * User ausloggen
         *
         * s. User Model
         */
        User::logout();

        /**
         * Redirect
         */
        $baseUrl = config('app.baseUrl');
        header("Location: {$baseUrl}login");
    }

}
