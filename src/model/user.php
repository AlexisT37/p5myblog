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

    public function getUserName(int $identifier): string
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
}
