<?php

namespace Application\Controllers\Post\Add;

require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/model/post.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Post\PostRepository;

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
        $UserId = 1;
        $success = $userRepository->createPost($title, $content, $leadParagraph, $UserId);
        if (!$success) {
            throw new \Exception('Impossible d\'ajouter le post !');
        } else {
            header('Location: index.php');
        }
    }
}
