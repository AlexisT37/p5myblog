<?php

namespace Application\Controllers\Post;

require_once('../src/lib/database.php');
require_once('../src/model/comment.php');
require_once('../src/model/post.php');
require_once('../src/model/user.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;
use Application\Model\Post\PostRepository;
use Application\Model\User\UserRepository;
use JWT;

class Post
{
    public function execute(int $identifier)
    {
        $connection = new DatabaseConnection();

        $postRepository = new PostRepository();
        $postRepository->connection = $connection;
        $post = $postRepository->getPost($identifier);

        $commentRepository = new CommentRepository();
        $commentRepository->connection = $connection;
        $comments = $commentRepository->getComments($identifier);

        $tokenFromLogin = $_COOKIE['TOKEN'];
        $tokenProcessing = new JWT();
        $loggedPayload = $tokenProcessing->getPayload($tokenFromLogin);
        $loggedUserId = $loggedPayload['userId'];


        $users = [];
        foreach ($comments as $comment) {
            $commentUserRepository = new UserRepository;
            $commentUserRepository->connection = $connection;
            $user = $commentUserRepository->getUserNameFromId($comment->author);
            $userIdChar = $comment->identifier;
            $userId = (int)$userIdChar;
            $users[$userId] = $user;
        }
        require('../templates/post.php');
    }
}
