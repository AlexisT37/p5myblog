<?php

namespace Application\Controllers\User\Add;

require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/model/user.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\User\UserRepository;

class AddUser
{
    public function execute()
    {
        try {
            $email = null;
            $username = null;
            $password = null;
            if (!empty($_POST['txt_email']) && !empty($_POST['txt_uname']) && !empty($_POST['txt_pwd']) && !empty($_POST['txt_password_verify'])) {
                $email = $_POST['txt_email'];
                $username = $_POST['txt_uname'];
                $passwordTest1 = $_POST['txt_pwd'];
                $passwordTest2 = $_POST['txt_password_verify'];
                $passwordMatch = ($passwordTest1 === $passwordTest2);

                // Verify if the two passwords match
                if ($passwordMatch == true) {
                    $password = password_hash($_POST['txt_pwd'], PASSWORD_BCRYPT);
                } else {
                    throw new \Exception('Les mots de passe ne correspondent pas.');
                }
            } else {
                throw new \Exception('Les données du formulaire sont invalides.');
            }

            $userRepository = new UserRepository();
            $userRepository->connection = new DatabaseConnection();
            if ($userRepository->checkExistingUsernameRegister($username) === true) {
                throw new \Exception('Le nom d\'utilisateur existe déjà !');
            } 
            
            if ($userRepository->checkPasswordStrength($passwordTest1) !== true) {
                throw new \Exception('Le mot de passe n\'est pas assez fort !');
            }


            if ($userRepository->checkEmailFormat($email) !== true) {
                throw new \Exception('L\'email n\'a pas le bon format !');
            }




            $success = $userRepository->createUser($email, $username, $password);
            if (!$success) {
                throw new \Exception('Impossible d\'ajouter l\'utilisateur !');
            } else {
                header('Location: index.php');
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            echo $errorMessage;
        }
    }
}
