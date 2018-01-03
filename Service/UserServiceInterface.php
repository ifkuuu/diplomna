<?php

namespace Service;


interface UserServiceInterface
{
    public function register(string $email,
                             string $password,
                             string $confirmPassword,
                             string $firstName,
                             string $lastName,
                             \DateTime $birthday,
                             string $phone
    );

    public function login($username, $password):bool ;

    public function loadUser(int $userId);
}
