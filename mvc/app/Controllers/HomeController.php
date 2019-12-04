<?php

namespace App\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Core\Libs\PHPMailer;
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

    public function sendEmail ()
    {
        $to = "arthur.dent@galaxy.com";

        if (PHPMailer::ValidateAddress($to)) {
            $mailer = new PHPMailer();
            $mailer->isMail();
            $mailer->AddAddress($to);
            $mailer->SetFrom('no-reply@sae-mvc.at');
            $mailer->Subject = "SAE MVC Testmail";
            $mailer->Body = "Super cooles Testmail! yay!";

            $mailer->Send();

            echo "success";
        } else {
            echo "fail :(";
        }
    }

    public function generatePDF ()
    {
        $user_id = Session::get('user_id');
        $user = User::find($user_id);

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1>Invoice</h1>');
        $mpdf->WriteHTML("<strong>{$user->email}</strong>");
        $mpdf->Output();
    }
}
