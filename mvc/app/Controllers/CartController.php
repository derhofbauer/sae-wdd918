<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Libs\Session;

class CartController extends BaseController
{

    public function list ()
    {
        $cart = Session::get('cart', []);

        // Zeige alle Produkte im Warenkorb in einem View an
        // Lies dazu alle produkt ids aus dem Warenkorb aus, hol dir die benötigten Informationen zu den Produkten
        // aus der Datenbank und übergib sie an einen neuen View

        $products = [];

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            $product->quantity = $quantity;
            $products[] = $product;
        }

        $params = [
            'products' => $products
        ];

        $this->view->render('cart', $params);
    }

    public function addProductToCart ($productId, $quantity)
    {
        // Array($productId => $quantity)
        $cart = Session::get('cart');
        // Füge $quantity Stück von $productId in die Session hinzu oder erhöhe um die $quantity

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        // Speichere den aktualisierten Wartenkorb zurück in die Session
        Session::add('cart', $cart);

        // Leite den User zurück zum Produkt
        $baseUrl = config('app.baseUrl');
        header("Location: ${baseUrl}products/$productId");
        exit;
    }

    public function updateProductInCart ($productId, $newQuantity)
    {
        $cart = Session::get('cart');

        if ($newQuantity == 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $newQuantity;
        }

        // aktualisiere die $newQuantity
        // wenn $newQuantity 0 ist, so soll das Produkt aus dem Warenkorb gelöscht werden

        // Speichere den aktualisierten Warenkorb zurück in die Session
        Session::add('cart', $cart);

        // leite den User zurück zum Produkt od. Warenkorb, je nachdem, woher er gekommen ist
        $baseUrl = config('app.baseUrl');
        header("Location: ${baseUrl}cart");
        exit;
    }

    public static function cartCount ()
    {
        $cart = Session::get('cart');

        return array_sum($cart);

        /**
         * ODER:
         *
         * $sum = 0;
         * foreach ($cart as $quantity) {
         *      $sum += $quantity;
         * }
         * return $sum;
         */
    }
}
