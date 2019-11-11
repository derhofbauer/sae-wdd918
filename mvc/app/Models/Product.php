<?php

namespace App\Models;

use Core\Libs\DB;

class Product
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $images;
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
            $p->images = $product['images'];
            $p->stock = $product['stock'];

            $products[] = $p;
        }

        return $products;
    }
}
