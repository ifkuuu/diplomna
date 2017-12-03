<?php

namespace Service\Validator;


interface ValidatorServiceInterface
{
    public function validatePassword(string $password);

    public function validatePhone(string $phoneNumber);

    public function validateEmail(string $email);

    public function validateDate(string $date);

    public function validateName(string $name);
}
