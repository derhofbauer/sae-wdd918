<?php

namespace App\Models;

use Core\Libs\DB;

class Product
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $images = [];
    public $stock;

    public static function all ()
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM products");
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($product = $result->fetch_assoc()) {
            $p = new self();
            $p->id = $product['id'];
            $p->name = $product['name'];
            $p->description = $product['description'];
            $p->price = $product['price'];
            $p->images = explode(',', $product['images']);
            $p->stock = $product['stock'];

            $products[] = $p;
        }

        return $products;
    }

    public static function find ($id)
    {
        $link = new DB();

        $stmt = $link->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $result = $result->fetch_all(MYSQLI_ASSOC)[0];

            $product = new self();
            $product->id = $result['id'];
            $product->name = $result['name'];
            $product->description = $result['description'];
            $product->price = $result['price'];
            $product->images = explode(',', $result['images']);
            $product->stock = $result['stock'];

            return $product;
        } elseif ($result->num_rows > 1) {
            throw new Exception('Database broken!');
        } else {
            return false;
        }
    }
}
