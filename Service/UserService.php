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
            throw new \Exception('Паролите не съвпадат');
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
                   id
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

        $userId = $stmt->fetch()[0];
        if (!$userId) {
            return false;
        }

        $user = $this->loadUser($userId);
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


    /**
     * @param int $userId
     * @return User|false Return the loaded User or false if not loaded properly.
     */
    public function loadUser(int $userId)
    {
        $query = "
                SELECT
						id,
                  		email,
                        password,
                        first_name as firstName,
                        last_name as lastName,
                        phone,
                        role,
                        birth_date as birthDate,
                        deleted_on as deletedOn
                FROM
                   users
                WHERE
                   id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);

        $user = $stmt->fetchObject(User::class);
        if (!$user) {
            return false;
        }
        return $user;
    }
}
