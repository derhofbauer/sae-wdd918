<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Libs\Session;

class CheckoutController extends BaseController {

    public function overview () {
        // Alle Produkte im Warenkorb (Session) aus der Datenbank abfragen
        $cart = Session::get('cart');

        $products = [];
        $totalPrice = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            $product->quantity = $quantity;
            // Preis für die einzelnen Posten berechnen (Achtung: Quantity)
            $product->totalPriceOfUnit = $product->price * $quantity;
            $products[] = $product;

            // Gesamtpreis berechnen
            $totalPrice = $totalPrice + $product->totalPriceOfUnit;
        }

        $params = [
            'products' => $products,
            'totalPrice' => $totalPrice
        ];

        // Übersicht ausgeben
        $this->view->render('checkout-overview', $params);
    }

    public function showDeliveryAddressForm () {
        // Ein Formular bauen (Formbuilder), mit dem man bestehende Adressen auswählen kann
        // Ein Formular bauen (Formbuilder), mit dem man eine neue Adresse hinzufügen kann
        // Formulare ausgeben
    }

    public function addNewAddress () {
        // Neue Adresse speichern
        // Weiter im Checkout
    }

    public function useExistingAddress () {
        // existierende ausgewählte Adresse irgendwo hin speichern (Session?)
        // Weiter im Checkout
    }
}
