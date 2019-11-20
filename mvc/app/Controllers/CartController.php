<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Libs\Session;

class CartController extends BaseController
{

    public function list ()
    {
        $cart = Session::get('cart');

        // Zeige alle Produkte im Warenkorb in einem View an
        // Lies dazu alle produkt ids aus dem Warenkorb aus, hol dir die benötigten Informationen zu den Produkten
        // aus der Datenbank und übergib sie an einen neuen View
    }

    public function addProductToCart ($productId, $quantity)
    {
        $cart = Session::get('cart');
        // Füge $quantity Stück von $productId in die Session hinzu oder erhöhe um die $quantity

        // Speichere den aktualisierten Wartenkorb zurück in die Session
        Session::add('cart', $cart);

        // Leite den User zurück zum Produkt
    }

    public function updateProductInCart ($productId, $newQuantity)
    {
        $cart = Session::get('cart');

        // aktualisiere die $newQuantity
        // wenn $newQuantity 0 ist, so soll das Produkt aus dem Warenkorb gelöscht werden

        // Speichere den aktualisierten Warenkorb zurück in die Session
        Session::add('cart', $cart);

        // leite den User zurück zum Produkt od. Warenkorb, je nachdem, woher er gekommen ist
    }
}
