<?php



namespace Application\Controllers\User\UserRepository;
require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/model/user.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\User\User;

class UserRepository extends User
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
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        // If any of the requirements are not met
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            $passwordIsStrongEnough = false;
        } else {
            $passwordIsStrongEnough = true;
        }

        return $passwordIsStrongEnough;
    }

    public function checkEmailFormat(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validEmailFormat = false;
        } else {
            $validEmailFormat = true;
        }

        return $validEmailFormat;
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
