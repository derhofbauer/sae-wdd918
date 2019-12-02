<?php

namespace App\Models;

use Core\Libs\DB;

class Invoice
{
    public $order_id;
    public $products = [];
    public $totalPrice = 0;
    public $address;
    public $payment;
    public $user;
    public $status = 'open';

    public static function find (int $order_id)
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param('i', $order_id);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $result = $result->fetch_all(MYSQLI_ASSOC)[0];

            $invoice = new self();
            $invoice->order_id = $result['id'];
            $invoice->products = json_decode($result['products']);
            $invoice->totalPrice();
            $invoice->address = Address::find($result['address_id']);
            $invoice->payment = json_encode($result['payment']);
            $invoice->user = User::find($result['user_id']);
            $invoice->status = $result['status'];

            return $invoice;
        } elseif ($result->num_rows > 1) {
            throw new Exception('Database broken!');
        } else {
            return false;
        }
    }

    public function totalPrice ()
    {
        foreach ($this->products as $key => $product) {
            $this->totalPrice += $product->price * $product->quantity;

            $product->totalPriceOfUnit = $product->price * $product->quantity;
            $this->products[$key] = $product;
        }

        return $this->totalPrice;
    }

    public static function findByUserId (int $user_id)
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM orders WHERE user_id = ?");
        $stmt->bind_param('i', $user_id);

        $stmt->execute();
        $result = $stmt->get_result();

        $invoices = [];

        if ($result->num_rows >= 1) {
            while ($row = $result->fetch_assoc()) {
                $invoice = new self();
                $invoice->order_id = $row['id'];
                $invoice->products = json_decode($row['products']);
                $invoice->totalPrice();
                $invoice->address = Address::find($row['address_id']);
                $invoice->payment = json_encode($row['payment']);
                $invoice->user = User::find($row['user_id']);
                $invoice->status = $row['status'];

                $invoices[] = $invoice;
            }
        }

        return $invoices;
    }

}
