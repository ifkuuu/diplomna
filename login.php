<?php
require_once "app.php";

if (isset($_POST['login'])) {
    $userService = new \Service\UserService($db, $validatorService, $encryptionService);
    $email = $_POST['email'];
    $password = $_POST['password'];
    try {
        // Sets $_SESSION['user_id'].
        if (!$userService->login($email, $password)) {
            throw new Exception('Грешни данни за вход!');
        }
        // If user logged in through login.php redirect him to his profile page.
        if (strpos($_SERVER['HTTP_REFERER'], 'login.php')) {
            header("Location: user_profile.php");
            exit();
            // Else if he logged in from different page, redirect him to that page.
        } else {
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    } catch (Exception $e) {
        $errorMessage =  $e->getMessage();
    }
}
include_once "frontend/login_frontend.php";
