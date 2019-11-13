<?php

namespace App\Controllers;

use App\Models\Product;

/**
 * Product
 * + id
 * + name
 * + description
 * + price
 * + images: /path/to/image.png,/path/to/image2.png
 * + stock
 *
 * Steps:
 * + Tabelle anlegen
 * + Testdaten einfügen
 * + Product Model anlegen
 * + HomeController.index anpassen um alle Produkte auszugeben
 */

class ProductController extends BaseController
{

    public function show ($id)
    {
        // echo "ProductController Test: $id";
        $product = Product::find($id);

        $params = [
            'product' => $product
        ];

        $this->view->render('product', $params);
    }

}
