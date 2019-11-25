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
    "/products/:id/update" => "ProductController.update",

    "/login" => "LoginController.showForm",
    "/do-login" => "LoginController.doLogin",
    "/logout" => "LoginController.doLogout",

    "/signup" => "SignupController.showForm",
    "/do-signup" => "SignupController.doSignup",

    "/cart/add/:productId/:quantity" => "CartController.addProductToCart",
    "/cart/update/:productId/:quantity" => "CartController.updateProductInCart",
    "/cart" => "CartController.list",

    "/checkout" => "CheckoutController.overview",
    "/checkout/address" => "CheckoutController.showDeliveryAddressForm"
];
