<?php

namespace Application\Controllers\Homepage;

require_once('../src/lib/database.php');
require_once('../src/model/post.php');
require_once('../src/model/user.php');
require_once('../src/controllers/post/PostRepository.php');



use Application\Lib\Database\DatabaseConnection;
use Application\Model\User\UserRepository;
use Application\Controllers\Post\PostRepository\PostRepository;


class Homepage
{
    public function execute(): void
    {
        $connection = new DatabaseConnection();
        $postRepository = new PostRepository();
        $postRepository->connection = new DatabaseConnection();
        $posts = $postRepository->getPosts();
        
        // Get the post usernames
        $users = [];
        foreach ($posts as $post) {
            $postUserRepository = new UserRepository;
            $postUserRepository->connection = $connection;
            $user = $postUserRepository->getUserNameFromId($post->userId);
            $users[$post->userId] = $user;
        }

        require('./templates/homepage.php');
    }
}
