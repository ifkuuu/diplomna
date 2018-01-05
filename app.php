<?php
session_start();

spl_autoload_register(function($class) {
    require_once "{$class}.php";
});

$db = new PDO("mysql:host=" . \Config\DbConfig::DB_HOST . ";dbname=" . \Config\DbConfig::DB_NAME . ";charset=utf8", \Config\DbConfig::DB_USER, \Config\DbConfig::DB_PASS);
$app = new \Core\Application();
$validatorService = new \Service\Validator\ValidatorService();
$encryptionService = new \Service\Encryption\BCryptEncryptionService();
$productService = new \Service\ProductService($db);
$cartService = new \Service\Cart\CartService($_SESSION, $productService);
$URI = $_SERVER['REQUEST_URI'];

// If requested page has 'user_' or 'admin_' in it, and there is no currently logged in user.
if ((strpos($URI, 'user_') || strpos($URI, 'admin_')) && !isset($_SESSION['user_id'])) {
    $error = true;
    include_once "frontend/404_frontend.php";
    exit();
}

// If requested page has 'admin_' and there is a logged in user.
if (strpos($URI, 'admin_') && isset($_SESSION['user_id'])) {
    $userService = new \Service\UserService($db, $validatorService, $encryptionService);
    $user = $userService->loadUser($_SESSION['user_id']);
    unset($userService);
    if (!$user->isAdmin()) {
        unset($user);
        // header('HTTP/1.0 403 Forbidden');
        include_once "frontend/404_frontend.php";
        exit();
    }
    unset($user);
}

$queryString = $_SERVER['QUERY_STRING'];
if (isset($_GET['page'])) {
    $queryString = preg_replace("/page=-?[0-9]+&?/", '', $queryString);
}
