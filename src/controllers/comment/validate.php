<?php

namespace Application\Controllers\Comment\Validate;

require_once('C:/laragon/www/p5myblog/src/classes/JWT.php');
require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/model/post.php');
require_once('../src\controllers\comment\CommentRepository.php');


use Application\Lib\Database\DatabaseConnection;
use Application\Controllers\Comment\CommentRepository\CommentRepository;
use JWT;

class ValidateComment
{
    public function execute(int $identifier): void
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
