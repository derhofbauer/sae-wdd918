<?php

namespace App\Controllers;

use App\Models\Product;

class HomeController extends BaseController
{

    public function index ()
    {
        $products = Product::all();
        /**
         * Die Parameter sind im Template dann als eigene Variablen verfügbar, weil wir in der View Klasse
         * die `extract()` Funktion verwenden.
         */
        $params = [
            "welcome_message" => "HomeController Test",
            "products" => $products
        ];

        /**
         * JS File angeben, welches geladen werden soll
         */
        $this->view->addJs('assets/js/fancyAnimation.js');

        /**
         * Template Loading starten
         */
        $this->view->render('home', $params);
    }

}
