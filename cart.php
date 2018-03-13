<?php
require_once "app.php";

try {
    if (isset($_POST['addToCart'])) {
        $cartService->addProduct($_POST['addToCart'], $_POST['quantity']);
//    unset($_SESSION['cartContents'], $_SESSION['totalCartAmount'], $_SESSION['totalItems']);
//    var_dump($_SESSION);
//    exit();
        $_SESSION['msg'] = "Продуктът беше добавен успешно!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } elseif (isset($_GET['product'])) {
        $cartService->addProduct($_GET['product']);
        $_SESSION['msg'] = "Продуктът беше добавен успешно!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } elseif (isset($_GET['remove'])) {
        $cartService->removeProduct($_GET['remove']);
        $_SESSION['msg'] = "Продуктът беше премахнат успешно!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        $data = $cartService->getCartViewData();
        include_once "frontend/cart_frontend.php";
    }
} catch (Exception $e) {
    $_SESSION['errorMessage'] = $e->getMessage();
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
