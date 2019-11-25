<?php

namespace App\Models;

use Core\Libs\DB;

class Address
{
    public $id;
    public $address;
    public $user_id;

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
}
