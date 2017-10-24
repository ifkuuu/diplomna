<?php


namespace Service\Encryption;


class BCryptEncryptionService implements EncryptionServiceInterface
{

    public function encrypt($password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function isValid($passwordHash, $passwordString): bool
    {
        return password_verify($passwordString, $passwordHash);
    }
}