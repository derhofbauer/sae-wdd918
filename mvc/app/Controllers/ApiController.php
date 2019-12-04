<?php


namespace App\Controllers;


use App\Models\Product;

class ApiController extends BaseController
{

    public function products ()
    {
        $products = Product::all();

        echo json_encode($products);
    }

}
