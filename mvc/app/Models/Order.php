<?php

namespace App\Models;

use Core\Libs\DB;
use Core\Libs\Session;

class Order
{
    public $id;
    public $user_id;
    public $products = [];
    public $crdate;
    public $address_id;
    public $status = 'open';
    public $payment = '';

    public static function all ()
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM orders");
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($order = $result->fetch_assoc()) {
            $p = new self();
            $p->id = $order['id'];
            $p->user_id = $order['user_id'];
            $p->products = json_decode($order['products']);
            $p->crdate = $order['crdate'];
            $p->address_id = $order['address_id'];
            $p->status = $order['status'];
            $p->payment = $order['payment'];

            $orders[] = $p;
        }

        return $orders;
    }

    public static function newFromCart ()
    {
        // Alle Produkte im Warenkorb (Session) aus der Datenbank abfragen
        $cart = Session::get('cart');

        $order = new self();
        $order->user_id = Session::get('user_id');
        $order->address_id = Session::get('use-address');

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            $product->quantity = $quantity;
            $order->products[] = $product;
        }

        return $order;
    }

    public static function find ($id)
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param('i', $id);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $result = $result->fetch_all(MYSQLI_ASSOC)[0];

            $order = new self();
            $order->id = $result['id'];
            $order->user_id = $result['user_id'];
            $order->products = json_decode($result['products']);
            $order->crdate = $result['crdate'];
            $order->address_id = $result['address_id'];
            $order->status = $result['status'];
            $order->payment = $result['payment'];

            return $order;
        } elseif ($result->num_rows > 1) {
            throw new Exception('Database broken!');
        } else {
            return false;
        }
    }

    public function save ()
    {
        $link = new DB();

        $products = json_encode($this->products);

        $stmt = $link->prepare("INSERT INTO orders SET user_id = ?, products = ?, address_id = ?, status = ?, payment = ?");
        $stmt->bind_param('isiss', $this->user_id, $products, $this->address_id, $this->status, $this->payment);
        $stmt->execute();
        $this->id = $stmt->insert_id;

        return $this;
    }

    public function update ()
    {
        $link = new DB();

        $products = json_encode($this->products);

        $stmt = $link->prepare("UPDATE orders SET user_id = ?, products = ?, address_id = ?, status = ?, payment = ? WHERE id = ?");
        $stmt->bind_param('isissi', $this->user_id, $products, $this->address_id, $this->status, $this->payment, $this->id);
        $stmt->execute();

        return $this;
    }
}
