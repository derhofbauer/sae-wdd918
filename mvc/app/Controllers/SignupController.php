<?php

namespace App\Controllers;

use App\Models\User;
use Core\Libs\Formbuilder;
use Core\Libs\Validator;

class SignupController extends BaseController
{

    public function showForm ()
    {

    }

    public function doSignup ()
    {
        $user = new User();
        $user->username = $inputUsername;
        // ...
        $user->save();
    }

}
