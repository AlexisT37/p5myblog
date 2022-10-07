<?php

namespace Application\Controllers\Post;

require_once('../src/lib/database.php');
require_once('../src/controllers/comment/CommentRepository.php');
require_once('../src/model/post.php');
require_once('../src/model/user.php');
require_once('../src/controllers/post/PostRepository.php');


use Application\Lib\Database\DatabaseConnection;
use Application\Controllers\Comment\CommentRepository\CommentRepository;
use Application\Controllers\Post\PostRepository\PostRepository;

use Application\Model\User\UserRepository;
use JWT;

class Post
{
    public function execute(int $identifier): void
    {
        $connection = new DatabaseConnection();

        $postRepository = new PostRepository();
        $postRepository->connection = $connection;
        $post = $postRepository->getPost($identifier);

        //Get the post author username
        $usernameConnection = new DatabaseConnection();
        $postUserRepository =  new UserRepository();
        $postUserRepository->connection = $usernameConnection;
        $postUsername = $postUserRepository->getUserNameFromId($post->userId);

        $commentRepository = new CommentRepository();
        $commentRepository->connection = $connection;
        $comments = $commentRepository->getComments($identifier);

        // Use the token if the user is logged in

        if (!empty($_COOKIE['TOKEN'])) {

            $tokenFromLogin = $_COOKIE['TOKEN'];
            $tokenProcessing = new JWT();
            $loggedPayload = $tokenProcessing->getPayload($tokenFromLogin);
            $loggedUserId = $loggedPayload['userId'];
        }


        // Get the comment usernames
        $users = [];
        foreach ($comments as $comment) {
            $commentUserRepository = new UserRepository;
            $commentUserRepository->connection = $connection;
            $user = $commentUserRepository->getUserNameFromId($comment->author);
            $userIdChar = $comment->identifier;
            $userId = (int)$userIdChar;
            $users[$userId] = $user;
        }
        require('./templates/post.php');
    }
}
