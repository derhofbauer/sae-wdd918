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
    "/products/:id/edit" => "ProductController.edit",

    "/login" => "LoginController.showForm",
    "/do-login" => "LoginController.doLogin",
    "/logout" => "LoginController.doLogout",

    "/signup" => "SignupController.showForm",
    "/do-signup" => "SignupController.doSignup"
];
