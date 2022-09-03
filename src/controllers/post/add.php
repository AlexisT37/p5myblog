<?php

namespace Application\Controllers\Post\Add;

require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/model/post.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Post\postRepository;

class AddPost
{
    public function execute(array $input)
    {
        $author = null;
        $title = null;
        $author = null;
        $leadParagraph = null;
        $content = null;


        if (!empty($input['author']) && !empty($input['comment']) && !empty($input['title']) && !empty($input['leadParagraph']) && !empty($input['content'])) {
            $author = $input['author'];
            $title = $input['title'];
            $leadParagraph = $input['leadParagraph'];
            $content = $input['content'];
        } else {
            throw new \Exception('Les données du formulaire sont invalides.');
        }

        $postRepository = new PostRepository();
        $postRepository->connection = new DatabaseConnection();
        $success = $postRepository->createPost($author, $title, $leadParagraph, $content);
        if (!$success) {
            throw new \Exception('Impossible d\'ajouter le post !');
        } else {
            header('Location: index.php');
        }
    }
}
