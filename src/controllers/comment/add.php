<?php

namespace Application\Controllers\Comment\Add;

require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('../src/controllers/comment/CommentRepository.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Controllers\Comment\CommentRepository\CommentRepository;
class AddComment
{
    public function execute(string $post, array $input): void
    {
        $author = null;
        $comment = null;
        if (!empty($input['comment'])) {
            $comment = $input['comment'];
        } else {
            throw new \Exception('Les données du formulaire sont invalides.');
        }

        $commentRepository = new CommentRepository();
        $commentRepository->connection = new DatabaseConnection();
        $success = $commentRepository->createComment($post, $author, $comment);
        if (!$success) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $post.'#portfolio');
        }
    }
}
