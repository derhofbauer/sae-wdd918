<?php

namespace App\Controllers;

use App\Models\User;
use Core\Libs\Formbuilder;
use Core\Libs\Session;
use Core\Libs\Validator;

class UserController extends BaseController
{

    public function form ()
    {
        if (User::isLoggedin()) {
            $user_id = Session::get('user_id');
            $user = User::find($user_id);

            // Edit Form
            $form = new Formbuilder('user-edit', "user-settings/update", 'post', 'multipart/form-data');
            $form->addInput('email', 'email', 'Email', ['value' => $user->email]);
            $form->addInput('text', 'username', 'Username', ['value' => $user->username]);
            $form->addInput('password', 'password_new', 'Password (new)');
            $form->addInput('password', 'password_new2', 'Password (repeat)');
            $form->addButton('submit', 'Save', ['type' => 'submit']);

            $params = [
                'user' => $user,
                'form' => $form->output(),
                'errors' => Session::get('errors', [])
            ];
            Session::delete('errors');
            $this->view->render('user-settings-form', $params);
        } else {
            // forbidden
        }
    }

    public function update ()
    {
        if (User::isLoggedin()) {
            $user_id = Session::get('user_id');
            $user = User::find($user_id);

            $validator = new Validator();

            $validator->validate($_POST['email'], 'Email', true, 'email');
            $validator->validate($_POST['username'], 'Username', false, 'textnum', 3);

            if (!empty($_POST['password_new'])) {
                /**
                 * Hier sollte die selbe Passwort Validierung durchgeführt werden, wie im Signup
                 */
                $validator->validate($_POST['password_new'], 'Password', false, 'password', 8);
                $validator->compare([$_POST['password_new'], 'Password'], [$_POST['password_new2'], 'Password (repeat)']);
            }

            $errors = $validator->getErrors();

            if (empty($errors)) {
                $user->email = trim($_POST['email']);
                $user->username = trim($_POST['username']);

                if (!empty($_POST['password_new'])) {
                    $user->setPassword($_POST['password_new']);
                }

                $user->update();

                Session::add('email', $user->email);
            } else {
                Session::add('errors', $errors);
            }

            $baseUrl = config('app.baseUrl');
            header("Location: ${baseUrl}user-settings");
            exit;
        } else {
            // forbidden
            var_dump($_SESSION);
        }
    }
}
