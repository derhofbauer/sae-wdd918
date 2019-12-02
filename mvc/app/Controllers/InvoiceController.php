<?php

namespace App\Controllers;

use App\Models\Invoice;

class InvoiceController extends BaseController
{

    public function invoice ($order_id)
    {
        /**
         * + Neuer Controller: InvoiceController
         * + Neues Model: Invoice (inkl. find())
         * + View: Invoice
         * + Route
         *
         * + HTML Rechnung mit Aufstellung der gekauften Produkte, Lieferadresse, Status, Käufer, Preisen, etc.
         */

        $invoice = Invoice::find($order_id);

        $params = [
            'invoice' => $invoice
        ];
        $this->view->render('invoice', $params);
    }

}
