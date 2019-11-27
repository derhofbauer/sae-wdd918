<?php

namespace App\Models;

use Core\Libs\DB;
use Core\Libs\Session;
use \Exception;

class User
{

    /**
     * Für jede Spalte der User in der Datenbank, sollte hier eine Eigenschaft angelegt werden.
     *
     * Teilweise macht es Sinn Standardwerte zu definieren.
     */
    public $id;
    public $email;
    public $username = null;
    private $password;
    public $is_admin = false;

    public static function find (int $id)
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $result = $result->fetch_all(MYSQLI_ASSOC)[0];

            $user = new self();
            $user->id = $result['id'];
            $user->email = $result['email'];
            $user->username = $result['username'];
            $user->is_admin = $result['is_admin'];
            $user->password = $result['password'];

            return $user;
        } elseif ($result->num_rows > 1) {
            throw new Exception('Database broken!');
        } else {
            return false;
        }
    }

    public static function findByEmail ($email)
    {
        /**
         * neues DB Objekt instanzieren und damit Datenbankverbindung herstellen
         */
        $link = new DB();

        /**
         * MySQL Statement vorbereiten und ausführen
         *
         * s.https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php
         */
        $stmt = $link->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            /**
             * Existiert genau 1 Datensatz mit der Email-Adresse, so laden wir die Daten, befüllen ein neues User
             * Objekt damit und geben es zurück.
             */
            $result = $result->fetch_all(MYSQLI_ASSOC)[0];

            $user = new self();
            $user->id = $result['id'];
            $user->email = $result['email'];
            $user->username = $result['username'];
            $user->password = $result['password'];
            $user->is_admin = $result['is_admin'];

            return $user;
        } elseif ($result->num_rows > 1) {
            /**
             * Existiert mehr als 1 Datensatz mit der Email-Adresse, ist die Datenbank kaputt und wir werfen eine
             * Exception.
             *
             * Exceptions sollten sehr sparsam verwendet werden, da sie dazu verleiten können unsauberen Code
             * zu schreiben.
             */
            throw new Exception('Database broken!');
        } else {
            /**
             * Wird gar kein Datensatz gefunden, können wir auch keine Daten setzen.
             */
            return false;
        }
    }

    public static function findByUsername ($username)
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);

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
         * wir prüfen das Passwort nur, wenn wir überhaupt schon eines im aktuellen Objekt haben, weil die Prüfung
         * relativ Resourcen-aufwändig ist
         */
        if (!empty($this->password)) {
            /**
             * Passwort prüfen und Rückgabewert zurückgeben
             */
            return password_verify($input, $this->password);
        }
        return false;
    }

    public function login ()
    {
        /**
         * Ist das Passwort des aktuellen Objekts nicht leer, so setzen wir die benötigten Sessions.
         */
        if (!empty($this->password)) {
            Session::add('logged_in', true);
            Session::add('email', $this->email);
            Session::add('user_id', $this->id);
            Session::add('is_admin', $this->is_admin);
            return true;
        }
        return false;
    }

    public static function isLoggedin ()
    {
        if (Session::get('logged_in') === true) {
            return true;
        }
        return false;
    }

    public static function logout ()
    {
        /**
         * Ist ein User eingeloggt, loggen wir ihn hier aus.
         *
         * Wir könnten auch Session::kill() verwenden, aber möglicherweise sind auch andere Informationen in der
         * Session gespeichert, die dann auch verloren gehen würden (bspw. Warenkorb).
         */
        if (Session::get('logged_in') === true) {

            Session::add('logged_in', false);
            Session::delete('email');
            Session::delete('user_id');
            Session::delete('is_admin');
            return true;
        }
        return false;
    }

    public function setPassword (string $plain_password)
    {
        $this->password = password_hash($plain_password, PASSWORD_BCRYPT);
    }

    public function save ($returnAfterSave = false)
    {
        // Speichert aktuelle Werte der Properties in die Datenbank
        $link = new DB();

        $stmt = $link->prepare("INSERT INTO users SET email = ?, PASSWORD = ?, username = ?");
        $stmt->bind_param('sss', $this->email, $this->password, $this->username);
        $stmt->execute();

        if ($returnAfterSave === true) {
            return self::findByEmail($this->email);
        }
    }

}
