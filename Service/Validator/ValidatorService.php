<?php

namespace Service\Validator;


class ValidatorService implements ValidatorServiceInterface
{

    public function validatePassword(string $password)
    {
        // Only Alphanumeric characters and underscore, between 3 and 20 symbols.
        if (!preg_match_all("/^[\\w]{3,20}$/", $password)) {
            throw new \Exception("Password format incorrect!");
        }
        return $password;
    }

    public function validatePhone(string $phoneNumber)
    {
        // Only Numbers, spaces, tabulations, { / }, { \ } and { - }, between 6 and 15 symbols.
        $pattern = "/^[0-9-\/\\ 	]{6,15}$/";
        if (!preg_match_all($pattern, $phoneNumber)) {

            throw new \Exception('Wrong number format!');
        }
        return $phoneNumber;
    }

    public function validateEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email!');
        }
        return $email;
    }

    public function validateDate(string $date)
    {

    }

    public function validateName(string $name)
    {
        // TODO: Implement validateName() method.
    }
}
