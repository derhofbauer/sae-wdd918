<?php

namespace App\Controllers;

use App\Models\Address;
use App\Models\Product;
use Core\Libs\Formbuilder;
use Core\Libs\Session;

class CheckoutController extends BaseController
{

    public function overview ()
    {
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

    public function showDeliveryAddressForm ()
    {
        // Ein Formular bauen (Formbuilder), mit dem man bestehende Adressen auswählen kann
        $user_id = Session::get('user_id');
        $existingAddresses = Address::findByUserId($user_id);
        $addresses = [];
        foreach ($existingAddresses as $existingAddress) {
            $addresses[$existingAddress->id] = $existingAddress->address;
        }
        $form_existing = new Formbuilder('existing-address', 'checkout/use-address');
        $form_existing->addSelect('existing-address', 'Choose existing address', $addresses);
        $form_existing->addButton('select-address', 'Select this address');

        // Ein Formular bauen (Formbuilder), mit dem man eine neue Adresse hinzufügen kann
        $form_new = new Formbuilder('new-address', 'checkout/add-address');
        $form_new->addTextarea('address', 'New Address');
        $form_new->addButton('new-address', 'Add new address');

        // Formulare ausgeben
        $params = [
            'formExistingAddresses' => $form_existing->output(),
            'formNewAddress' => $form_new->output()
        ];
        $this->view->render('checkout-address', $params);

    }

    public function addNewAddress ()
    {
        // Neue Adresse speichern
        // Weiter im Checkout
    }

    public function useExistingAddress ()
    {
        // existierende ausgewählte Adresse irgendwo hin speichern (Session?)
        // Weiter im Checkout
    }
}
