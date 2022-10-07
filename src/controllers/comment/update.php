<?php

namespace Application\Controllers\Comment\Update;

require_once('../src/lib/database.php');
require_once('../src/model/comment.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Controllers\Comment\CommentRepository\CommentRepository;
class UpdateComment
{
    public function execute(int $identifier, ?array $input): void
    {
        // It handles the form submission when there is an input.
        if ($input !== null) {
            $comment = null;
            if (!empty($input['comment'])) {
                $comment = $input['comment'];
            } else {
                throw new \Exception('Les données du formulaire sont invalides.');
            }

            $commentRepository = new CommentRepository();
            $commentRepository->connection = new DatabaseConnection();
            $success = $commentRepository->updateComment($identifier, $comment);
            if (!$success) {
                throw new \Exception('Impossible de modifier le commentaire !');
            } else {
                $comment = $commentRepository->getComment($identifier);

                header('Location: index.php?action=post&id=' . $comment->post);
            }
        }

        // Otherwise, it displays the form.
        $commentRepository = new CommentRepository();
        $commentRepository->connection = new DatabaseConnection();
        $comment = $commentRepository->getComment($identifier);
        if ($comment === null) {
            throw new \Exception("Le commentaire $identifier n'existe pas.");
        }

        require('./templates/update_comment.php');
    }
}
