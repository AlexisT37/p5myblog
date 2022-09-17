<?php

namespace Application\Controllers\Post\Add;

require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/model/post.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Post\PostRepository;
use JWT;

class AddPost
{
    public function execute()
    {
        $title = null;
        $content = null;
        $leadParagraph = null;
        if (!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['leadParagraph'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $leadParagraph = $_POST['leadParagraph'];
        } else {
            throw new \Exception('Les données du formulaire sont invalides.');
        }

        $userRepository = new PostRepository();
        $userRepository->connection = new DatabaseConnection();

        // Use the token if the user is logged in

        if (!empty($_COOKIE['TOKEN'])) {

            $tokenFromLogin = $_COOKIE['TOKEN'];
            $tokenProcessing = new JWT();
            $loggedPayload = $tokenProcessing->getPayload($tokenFromLogin);
            $loggedUserId = $loggedPayload['userId'];


            $success = $userRepository->createPost($title, $content, $leadParagraph, $loggedUserId);
            if (!$success) {
                throw new \Exception('Impossible d\'ajouter le post !');
            } else {
                header('Location: index.php');
            }
        } else {
            throw new \Exception('Utilisateur non autentifié');
        }
    }
}
