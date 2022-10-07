<?php

namespace Application\Controllers\Comment\Delete;

require_once('C:/laragon/www/p5myblog/src/classes/JWT.php');
require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/model/comment.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Controllers\Comment\CommentRepository\CommentRepository;
use JWT;

class DeleteComment
{
    public function execute(int $identifier): void
    {
        $commentRepository = new CommentRepository();
        $commentRepository->connection = new DatabaseConnection();

        if (!empty($_COOKIE['TOKEN'])) {

            $tokenFromLogin = $_COOKIE['TOKEN'];
            $tokenProcessing = new JWT();
            $loggedPayload = $tokenProcessing->getPayload($tokenFromLogin);
            $loggedUserId = $loggedPayload['userId'];

            $success = $commentRepository->deleteComment($identifier);
            if (!$success) {
                throw new \Exception('Impossible de supprimer le commentaire !');
            } else {
                header('Location: index.php');
            }
        }
    }
}
