<?php
require_once "app.php";

if (isset($_POST['login'])) {
    $userService = new \Service\UserService($db, $validatorService, $encryptionService);
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!$userService->login($email, $password)) {
        throw new Exception('Incorrect login information!');
    }
}
var_dump($_SESSION);
include_once "frontend/login_frontend.php";
