<?php

namespace App\Models;

use Core\Libs\DB;

class Address
{
    public $id;
    public $address;
    public $user_id;

    public static function find (int $id)
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM addresses WHERE id = ?");
        $stmt->bind_param('i', $id);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $result = $result->fetch_all(MYSQLI_ASSOC)[0];

            $address = new self();
            $address->id = $result['id'];
            $address->user_id = $result['user_id'];
            $address->address = $result['address'];

            return $address;
        } elseif ($result->num_rows > 1) {
            throw new Exception('Database broken!');
        } else {
            return false;
        }
    }

    public static function findByUserId (int $user_id)
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM addresses WHERE user_id = ?");
        $stmt->bind_param('i', $user_id);

        $stmt->execute();
        $result = $stmt->get_result();

        $addresses = [];

        if ($result->num_rows >= 1) {
            while ($row = $result->fetch_assoc()) {
                $a = new self();
                $a->id = $row['id'];
                $a->address = $row['address'];
                $a->user_id = $row['user_id'];

                $addresses[] = $a;
            }
        }

        return $addresses;
    }

    /**
     * ACHTUNG: bisher aktualisieren alle save Methoden in den Models einen Datensatz. Diese hier erstellt einen neuen.
     */
    public function save ()
    {
        $link = new DB();

        $stmt = $link->prepare("INSERT INTO addresses SET address = ?, user_id = ?");
        $stmt->bind_param('si', $this->address, $this->user_id);

        $stmt->execute();
        $this->id = $stmt->insert_id;

        return $this;
    }
}
