<?php
require_once "app.php";

$userService = new \Service\UserService($db, $validatorService, $encryptionService);
$user = $userService->loadUser($_SESSION['user_id']);

if (isset($_GET['orders'])) {
    $ordersService = new \Service\Orders\OrdersService($db, $productService, $userService);
    $orders = $ordersService->getAllOrders($user->getId());
}

include_once "frontend/user_profile_frontend.php";
