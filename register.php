<?php
require_once 'app.php';

if (isset($_POST['register'])) {
    $a = 5;
    $userService = new \Service\UserService($db, $validatorService, $encryptionService);
    $userService->register(
        $_POST['email'],
        $_POST['password'],
        $_POST['confirmPassword'],
        $_POST['firstName'],
        $_POST['lastName'],
        new DateTime($_POST['birthDate']),
        $_POST['phone'],
        $_POST['city'],
        $_POST['address']
    );
    header("Location: login.php");
    exit();
}

include_once "frontend/register_frontend.php";
