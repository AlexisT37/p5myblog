<?php

namespace Application\Controllers\Post\Delete;

require_once('C:/laragon/www/p5myblog/src/classes/JWT.php');
require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/model/post.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Post\PostRepository;
use JWT;

class DeletePost
{
    public function execute(int $identifier): void
    {
        $postRepository = new PostRepository();
        $postRepository->connection = new DatabaseConnection();

        if (!empty($_COOKIE['TOKEN'])) {

            $tokenFromLogin = $_COOKIE['TOKEN'];
            $tokenProcessing = new JWT();
            $loggedPayload = $tokenProcessing->getPayload($tokenFromLogin);
            $loggedUserId = $loggedPayload['userId'];

            $success = $postRepository->deletePost($identifier);
            if (!$success) {
                throw new \Exception('Impossible de supprimer le post !');
            } else {
                header('Location: index.php');
            }
        }
    }
}
