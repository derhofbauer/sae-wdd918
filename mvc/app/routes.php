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
    "/checkout/address" => "CheckoutController.showDeliveryAddressForm",
    "/checkout/use-address" => "CheckoutController.useExistingAddress",
    "/checkout/add-address" => "CheckoutController.addNewAddress",
    "/checkout/check" => "CheckoutController.check",
    "/checkout/finish" => "CheckoutController.finish",

    "/order/:id/invoice" => "InvoiceController.invoice",
    "/orders" => "HomeController.orders",
    "/account/invoice/:id" => "InvoiceController.invoice",

    /**
     * Example Routes to demonstrate Mailing and PDF functionality
     */
    "/sendemail" => "HomeController.sendEmail",
    "/pdf" => "HomeController.generatePDF",

    /**
     * API Routes for AJAX calls
     */
    "/api/products" => "ApiController.products",

    /**
     * User Routes
     */
    "/user-settings" => "UserController.form",
    "/user-settings/update" => "UserController.update"
];
