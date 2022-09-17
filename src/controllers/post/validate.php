<?php

namespace Application\Controllers\Post\Validate;

require_once('C:/laragon/www/p5myblog/src/classes/JWT.php');
require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/model/post.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Post\PostRepository;
use JWT;

class ValidatePost
{
    public function execute(int $identifier)
    {
        $postRepository = new PostRepository();
        $postRepository->connection = new DatabaseConnection();

        if (!empty($_COOKIE['TOKEN'])) {

            $tokenFromLogin = $_COOKIE['TOKEN'];
            $tokenProcessing = new JWT();
            $loggedPayload = $tokenProcessing->getPayload($tokenFromLogin);
            $loggedUserId = $loggedPayload['userId'];

            $success = $postRepository->validatePost($identifier);
            if (!$success) {
                throw new \Exception('Impossible d\'ajouter le post !');
            } else {
                header('Location: index.php');
            }
        }
    }
}
