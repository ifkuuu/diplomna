<?php


namespace Service\Encryption;


interface EncryptionServiceInterface
{
    public function encrypt($password): string;

    public function isValid($passwordHash, $passwordString): bool;
}