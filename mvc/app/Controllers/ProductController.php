<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use Core\Libs\Formbuilder;
use Core\Libs\Session;

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
        $product = Product::find($id);

        $params = [
            'product' => $product
        ];

        $this->view->render('product', $params);
    }

    public function edit ($id)
    {
        if (!User::isLoggedin() || Session::get('is_admin') != true) {
            die("Du bist kein Admin :(");
        }

        $product = Product::find($id);

        $id = $product->id;
        $form = new Formbuilder('product-edit', "products/$id/update", 'post', 'multipart/form-data');
        $form->addInput('text', 'name', 'Name', ['value' => $product->name]);
        $form->addTextarea('description', 'Description', $product->description);
        $form->addInput('number', 'price', 'Price', ['value' => $product->price, 'step' => '.01']);
        $form->addInput('number', 'stock', 'Stock', ['value' => $product->stock]);
        $form->addInput('file', 'new_image', 'Add some fancy image');

        // $images = ['path/to/image.jpg' => '<img ="....'];
        $images =  [];
        foreach ($product->images as $image) {
            /**
             * Der Formbuilder erwartet einen Array im Format: HTML-value => Label.
             * Wir generieren hier einen IMG-Tag als Label. Das ist nicht ganz sauber so, aber für unsere
             * Zwecke duerfte es reichen.
             */
            $images[$image] = "<img src=\"storage/$image\" width='50'>";
        }
        var_dump($images);
        $form->addCheckboxGroup($images);

        $form->addButton('submit', 'Save', ['type' => 'submit']);

        $params = [
            'form' => $form->output()
        ];

        $this->view->render('product-edit', $params);
    }

}
