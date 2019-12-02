<?php

namespace App\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use Core\Libs\Session;

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

    public function orders ()
    {
        $user_id = Session::get('user_id');
        $invoices = Invoice::findByUserId($user_id);

        $params = [
            'invoices' => $invoices
        ];
        $this->view->render('orders', $params);
    }

}
