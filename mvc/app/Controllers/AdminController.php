<?php

namespace App\Controllers;

use App\Models\Address;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Core\Libs\Formbuilder;
use Core\Libs\PHPMailer;
use Core\Libs\Session;

class AdminController extends BaseController
{

    public function orders ()
    {
        if (User::isAdmin()) {
            $orders = Order::all();

            $params = [
                'orders' => $orders
            ];
            $this->view->render('admin-orders', $params);
        }
    }

    public function ordersForm ($order_id)
    {
        if (!User::isLoggedin() || Session::get('is_admin') != true) {
            die("Du bist kein Admin :(");
        }

        $order = Order::find($order_id);
        $user = User::find($order->user_id);
        $address = Address::find($order->address_id);
        $allUsers = User::all();

        $id = $order->id;
        $form = new Formbuilder('order-edit', "admin/orders/$id/update", 'post', 'multipart/form-data');

        $userSelects = [];
        foreach ($allUsers as $u) {
            $userSelects[$u->id] = $u->email;
        }
        $form->addSelect('user_id', 'User', $userSelects, $user->id);

        $userAddresses = Address::findByUserId($user->id);
        $addresses = [];
        foreach ($userAddresses as $userAddress) {
            $addresses[$userAddress->id] = $userAddress->address;
        }
        $form->addSelect('address_id', 'Address', $addresses, $order->address_id);
        $form->addSelect('status', 'Status', ['open' => 'Open', 'delivered' => 'Delivered', 'in_progress' => 'In progress', 'cancelled' => 'Cancelled'], $order->status);

        $form->addButton('submit', 'Save', ['type' => 'submit']);

        $params = [
            'form' => $form->output(),
            'user' => $user,
            'order' => $order
        ];

        $this->view->render('admin-order-edit', $params);
    }

    public function setProductQuantity ($order_id, $product_id, $new_quantity)
    {
        $order = Order::find($order_id);

        foreach ($order->products as $index => $product) {
            if ($product->id == $product_id) {
                if ($new_quantity == 0) {
                    unset($order->products[$index]);
                } else {
                    $product->quantity = $new_quantity;
                }
            }
        }
        $order->save();

        $baseUrl = config('app.baseUrl');
        header("Location: ${baseUrl}admin/orders/$order->id");
        exit;
    }

    public function ordersUpdate ($order_id)
    {
        if (User::isLoggedin() && Session::get('is_admin')) {
            $order = Order::find($order_id);

            if (check_csrf($_POST['csrf']) === false) {
                $errors[] = "Um Himmels Willen! Willst du uns hacken?!";
            } else {
                $order->address_id = $_POST['address_id'];
                $order->user_id = $_POST['user_id'];
                $order->status = $_POST['status'];

                $order->update();

                $baseUrl = config('app.baseUrl');
                header("Location: ${baseUrl}admin/orders/$order->id");
                exit;
            }
        } else {
            $baseUrl = config('app.baseUrl');
            header("Location: ${baseUrl}");
            exit;
        }
    }
}
