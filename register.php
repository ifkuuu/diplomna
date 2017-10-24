<?php
require_once 'app.php';

if (isset($_POST['register'])) {
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
    header("Location: login.php");
    exit();
}
?>
<form method="post">
    email: <input type="text" name="email"> <br>
    password: <input type="text" name="password"> <br>
    confirm: <input type="text" name="confirmPassword"> <br>
    first name: <input type="text" name="firstName"> <br>
    lastn name: <input type="text" name="lastName"> <br>
    birth date: <input type="text" name="birthDate"> <br>
    telephonikos: <input type="text" name="phone"> <br>
    <input type="submit" value="Regvai se" name="register">
</form>


