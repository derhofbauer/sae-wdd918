<?php

namespace App\Models;

use Core\Libs\DB;
use mysql_xdevapi\Exception;

class User
{

    public $id;
    public $email;
    public $username;
    private $password;
    public $is_admin = false;

    public static function findByEmail ($email)
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);

        $stmt->execute();

        if ($stmt->num_rows === 1) {
            $result = $stmt->get_result();
            $result = $result->fetch_all(MYSQLI_ASSOC)[0];

            $user = new self();
            $user->id = $result['id'];
            $user->email = $result['email'];
            $user->username = $result['username'];
            $user->password = $result['password'];
            $user->is_admin = $result['is_admin'];

            return $user;
        } elseif ($stmt->num_rows > 1) {
            throw new Exception('Database broken!');
        } else {
            return false;
        }
    }

}
