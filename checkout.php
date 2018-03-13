<?php
require_once "app.php";

if (!isset($_SESSION['user_id'])) {
    $error = true;
    include_once "frontend/404_frontend.php";
    exit();
}
// Redirects back to cart php if user tries to be smart and directly access checkout.php with no items in cart.
if ($_SESSION['totalItems'] < 1) {
    header("Location: cart.php");
    exit();
}

if (isset($_POST['place_order']) && !(isset($successfulOrder))) {
    try {
        if ($_POST['payment_method'] === 'Наложен платеж') {
            echo "da";
        }
        //  'payment_method' => string 'Виртуални пари' (length=27)
        // 'payment_method' => string 'Наложен платеж' (length=27)
        if (!isset($_POST['city'])) {
            throw new Exception("Грешен град");
        }
        $city = $_POST['city'];
        $paymentMethod = $_POST['payment_method'];
        $description = $_POST['order_comments'];
        $address = $_POST['billing_address'];
        $orderCost = $_POST['orderCost'];
        /** @var array $productsQuantities In format $id => $quantity for said id, i.e. [id2] => 3quantity */
        $productsQuantities = $_POST['productsQty'];
        $productsPrices = $_POST['productsPrice'];
        $userService = new \Service\UserService($db, $validatorService, $encryptionService);
        $ordersService = new \Service\Orders\OrdersService($db, $productService, $userService);
        $orderId = $ordersService->createOrder(
            $_SESSION['user_id'],
            $city,
            $address,
            $description,
            $productsQuantities,
            $productsPrices,
            $orderCost,
            $paymentMethod
        );
        $successfulOrder = true;
        $cartService->resetCart();

        $order = $ordersService->getOrder($orderId);
        $mailService = new \Service\Mail\MailService();
        $mailService->sendOrderInfoEmail($order);
        $_SESSION['msg'] = "Усшешно направена поръчка!";
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

$data = $cartService->getCartViewData();
$optionsService = new \Service\OptionsService($db);
/** @var \Data\City[] $cities */
$cities = $optionsService->getAllCities();

include_once "frontend/checkout_frontend.php";
