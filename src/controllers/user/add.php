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
        $email = null;
        $username = null;
        $password = null;
        if (!empty($_POST['txt_email']) && !empty($_POST['txt_uname']) && !empty($_POST['txt_pwd'])) {
            $email = $_POST['txt_email'];
            $username = $_POST['txt_uname'];
            $password = $_POST['txt_pwd'];
        } else {
            throw new \Exception('Les données du formulaire sont invalides.');
        }

        $userRepository = new UserRepository();
        $userRepository->connection = new DatabaseConnection();
        $success = $userRepository->createUser($email, $username, $password);
        if (!$success) {
            throw new \Exception('Impossible d\'ajouter l\'utilisateur !');
        } else {
            header('Location: index.php');
        }
    }
}
