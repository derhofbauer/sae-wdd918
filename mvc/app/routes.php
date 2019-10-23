<?php

/**
 * Ohne Parameter:
 *
 * "/some/url" => "SomeController.urlAction" --> SomeController::urlAction()
 *
 * Mit Parameter:
 *
 * "/product/show/:id" => "ProductController.show" --> ProductController::show($id)
 */

return [
    "/" => "HomeController.index"
];
