<?php

namespace Application\Controllers\Comment\Validate;

require_once('C:/laragon/www/p5myblog/src/classes/JWT.php');
require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/model/post.php');
require_once('C:/laragon/www/p5myblog/src/model/comment.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;
use JWT;

class ValidateComment
{
    public function execute(int $identifier)
    {
        $postRepository = new CommentRepository();
        $postRepository->connection = new DatabaseConnection();

        if (!empty($_COOKIE['TOKEN'])) {

            $tokenFromLogin = $_COOKIE['TOKEN'];
            $tokenProcessing = new JWT();
            $loggedPayload = $tokenProcessing->getPayload($tokenFromLogin);
            $loggedUserId = $loggedPayload['userId'];

            $success = $postRepository->validateComment($identifier);
            if (!$success) {
                throw new \Exception('Impossible de valider le commentaire !');
            } else {
                header('Location: index.php');
            }
        }
    }
}
