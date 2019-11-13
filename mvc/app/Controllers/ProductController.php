<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use Core\Libs\Formbuilder;
use Core\Libs\Session;
use Core\Libs\Validator;

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
        $images = [];
        foreach ($product->images as $image) {
            /**
             * Der Formbuilder erwartet einen Array im Format: HTML-value => Label.
             * Wir generieren hier einen IMG-Tag als Label. Das ist nicht ganz sauber so, aber für unsere
             * Zwecke duerfte es reichen.
             */
            $images["delete_image[$image]"] = "<img src=\"storage/$image\" width='50'>";
        }
        $form->addCheckboxGroup($images);

        $form->addButton('submit', 'Save', ['type' => 'submit']);

        $params = [
            'form' => $form->output()
        ];

        $this->view->render('product-edit', $params);
    }

    public function update ($id)
    {
        if (!User::isLoggedin() || Session::get('is_admin') != true) {
            die("Du bist kein Admin :(");
        }

        $product = Product::find($id);

        $errors = [];
        if (check_csrf($_POST['csrf']) === false) {
            $errors[] = "Um Himmels Willen! Willst du uns hacken?!";
        } else {
            $validator = new Validator();

            $validator->validate($_POST['name'], 'Name', true, 'textnum', 5, 255);
            $validator->validate($_POST['description'], 'Description', false, 'textnum');
            $validator->validate($_POST['price'], 'Price', true, 'textnum');
            $validator->validate($_POST['stock'], 'Stock', true, 'num');

            $validationErrors = $validator->getErrors();

            if ($validationErrors !== false) {
                $errors = $validationErrors;
                // Fehler müssten noch irgendwo ausgegeben werden; aus Zeitgründen verzichten wir darauf (s. Signup)
            } else {
                $product->name = $_POST['name'];
                $product->description = $_POST['description'];
                $product->stock = (int)$_POST['stock'];
                $product->price = (float)$_POST['price'];

                $product->save();

                $baseUrl = config('app.baseUrl');
                header("Location: ${baseUrl}products/$id");
                exit;
            }
        }
    }

}

// Route anlegen
// (Controller &) Action anlegen
// Daten aus $_POST auslesen, validieren und in ein Produkt speichern
//  Produkt Objekt in Datenbank speichern
