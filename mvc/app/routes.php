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
    "/" => "HomeController.index",
    "/products/:id" => "ProductController.show",
    "/login" => "LoginController.showForm",
    "/do-login" => "LoginController.doLogin",
    "/logout" => "LoginController.logout"
];
