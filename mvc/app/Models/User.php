<?php

namespace App\Models;

use Core\Libs\DB;
use Core\Libs\Session;
use \Exception;

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
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $result = $result->fetch_all(MYSQLI_ASSOC)[0];

            $user = new self();
            $user->id = $result['id'];
            $user->email = $result['email'];
            $user->username = $result['username'];
            $user->password = $result['password'];
            $user->is_admin = $result['is_admin'];

            return $user;
        } elseif ($result->num_rows > 1) {
            throw new Exception('Database broken!');
        } else {
            return false;
        }
    }

    public function checkPassword ($input)
    {
        /*
         * wir prüfen das Passwort nur, wenn wir überhaupt schon
         * eines im aktuellen Objekt haben, weil die Prüfung
         * relativ Resourcen-aufwändig ist
         */
        if (!empty($this->password)) {
            // Passwort prüfen und Rückgabewert returnen
            return password_verify($input, $this->password);
        }
        return false;
    }

    public function login() {
        if (!empty($this->password)) {
            Session::add('logged_in', true);
            Session::add('email', $this->email);
            return true;
        }
        return false;
    }

    public function logout () {

    }

}
