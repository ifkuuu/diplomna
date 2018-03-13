<?php
require_once 'app.php';

if (isset($_POST['register'])) {
    try {
        $userService = new \Service\UserService($db, $validatorService, $encryptionService);
        $userService->register(
            $_POST['email'],
            $_POST['password'],
            $_POST['confirmPassword'],
            $_POST['firstName'],
            $_POST['lastName'],
            new DateTime($_POST['birthDate']),
            $_POST['phone']
        );
        $_SESSION['msg'] = "Вие се регистрирахте успешно! Моля влезте в системата!";
        sleep(2);
        header("Location: login.php");
        exit();
    } catch (Exception $e) {
        $errorMessage =  $e->getMessage();
    }
}

include_once "frontend/register_frontend.php";
