<?php

namespace Application\Controllers\Post\Validate;

require_once('../src/classes/JWT.php');
require_once('../src/lib/database.php');
require_once('../src/controllers/post/PostRepository.php');

use Application\Lib\Database\DatabaseConnection;
use JWT;
use Application\Controllers\Post\PostRepository\PostRepository;


class ValidatePost
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

            $success = $postRepository->validatePost($identifier);
            if (!$success) {
                throw new \Exception('Impossible de valider le post !');
            } else {
                header('Location: index.php');
            }
        }
    }
}
