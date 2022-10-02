<?php

namespace Application\Model\User;

require_once('C:/laragon/www/p5myblog/src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class User
{
    public int $id;
    public string $email;
    public string $username;
    public string $password;
    public array $roles;
}

class UserRepository
{
    public DatabaseConnection $connection;

    public function createUser(string $email,  string $username, string $password): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO user(email, username, password) VALUES(?, ?, ?)'
        );
        $affectedLines = $statement->execute([$email, $username, $password]);

        return ($affectedLines > 0);
    }

    public function getUserNameFromId(int $identifier): string
    {
        $identifier = (int)$identifier;
        $statement = $this->connection->getConnection()->prepare(
            "SELECT username FROM user WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $user = $row['username'];

        return $user;
    }

    public function checkExistingUsernameRegister(string $username): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT username FROM user WHERE username = ?"
        );
        $statement->execute([$username]);

        $row = $statement->fetch();
        $userAlreadyExists = false;
        if ($row !== false) {
            $userAlreadyExists = true;
        } else {
            $userAlreadyExists = false;
        }

        return $userAlreadyExists;
    }

    public function checkPasswordStrength(string $password): bool
    {
        

        return $passwordIsStrongEnough;
    }

    public function getUserIdFromName(string $name): int
    {
        $connection = new DatabaseConnection();

        $statement = $connection->getConnection()->prepare(
            "SELECT id FROM user WHERE username = ?"
        );
        $statement->execute([$name]);

        $row = $statement->fetch();
        $id = $row['id'];

        return $id;
    }
}
