<?php

namespace Service;


use Data\Users\User;
use Service\Encryption\EncryptionServiceInterface;
use Service\Validator\ValidatorServiceInterface;

class UserService implements UserServiceInterface
{

    private $db;

    private $validatorService;

    private $encryptionService;

    public function __construct(\PDO $db,
                                ValidatorServiceInterface $validatorService,
                                EncryptionServiceInterface $encryptionService)
    {
        $this->db = $db;
        $this->validatorService = $validatorService;
        $this->encryptionService = $encryptionService;
    }

    public function register(string $email,
                             string $password,
                             string $confirmPassword,
                             string $firstName,
                             string $lastName,
                             \DateTime $birthDate,
                             string $phone)
    {

        // Validating Data
        if ($this->emailExists($email)) {
            throw new \Exception('Email already exists');
        }

        $password = $this->validatorService->validatePassword($password);
        $confirmPassword = $this->validatorService->validatePassword($confirmPassword);
        $email = $this->validatorService->validateEmail($email);
        $phone = $this->validatorService->validatePhone($phone);


        if ($password !== $confirmPassword) {
            throw new \Exception('Password mismatch');
        }

        // ==========================================================================
        $query = "INSERT INTO users ( 

                        email,
                        password,
                        first_name,
                        last_name,
                        phone,
                        birth_date
                        
                  ) VALUES (
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?
                  )";
        $stmt = $this->db->prepare($query);
        $stmt->execute(
            [
                $email,
                $this->encryptionService->encrypt($password),
                $firstName,
                $lastName,
                $phone,
                $birthDate->format('Y-m-d'),
            ]
        );
    }

    public function login($email, $password): bool
    {
        $query = "SELECT
                   id,
                   password
                FROM
                   users
                WHERE
                   email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute(
            [
                $email
            ]
        );

        /**
         * @var User $user
         */
        $user = $stmt->fetchObject(User::class);
        if (!$user) {
            return false;
        }

        $passwordHash = $user->getPassword();
        if ($this->encryptionService->isValid($passwordHash, $password)) {
            $_SESSION['user_id'] = $user->getId();
            return true;
        }

        return false;
    }

    private function emailExists(string $email): bool
    {
        $query = "SELECT * FROM users WHERE email = ?;";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return !!$result;
    }
}