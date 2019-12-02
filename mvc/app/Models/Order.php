<?php

namespace App\Models;

use Core\Libs\DB;
use Core\Libs\Session;

class Order {
    public $id;
    public $user_id;
    public $products = [];
    public $crdate;
    public $address_id;
    public $status = 'open';
    public $payment = '';

    public static function newFromCart () {
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

    public function save() {
        $link = new DB();

        $products = json_encode($this->products);

        $stmt = $link->prepare("INSERT INTO orders SET user_id = ?, products = ?, address_id = ?, status = ?, payment = ?");
        $stmt->bind_param('isiss', $this->user_id, $products, $this->address_id, $this->status, $this->payment);
        $stmt->execute();
        $this->id = $stmt->insert_id;

        return $this;
    }
}
