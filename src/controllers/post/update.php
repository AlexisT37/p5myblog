<?php

namespace Application\Controllers\Post\Update;

require_once('../src/lib/database.php');
require_once('../src/controllers/post/PostRepository.php');


use Application\Lib\Database\DatabaseConnection;
use Application\Controllers\Post\PostRepository\PostRepository;


class UpdatePost
{
    public function execute(int $identifier, ?array $input): void
    {
        // It handles the form submission when there is an input.
        if ($input !== null) {
            $content = null;
            $leadParagraph = null;
            $title = null;
            if (!empty($input['modifcontent']) && !empty($input['modifleadParagraph']) && !empty($input['modiftitle'])) {
                $content = $input['modifcontent'];
                $leadParagraph = $input['modifleadParagraph'];
                $title = $input['modiftitle'];
            } else {
                throw new \Exception('Les données du formulaire sont invalides.');
            }

            $postRepository = new PostRepository();
            $postRepository->connection = new DatabaseConnection();
            $success = $postRepository->UpdatePost($identifier, $content, $leadParagraph, $title);
            if (!$success) {
                throw new \Exception('Impossible de modifier le post !');
            } else {
                $post = $postRepository->getPost($identifier);

                header('Location: index.php?action=post&id=' . $identifier);
            }
        }

        // Otherwise, it displays the form.
        $postRepository = new PostRepository();
        $postRepository->connection = new DatabaseConnection();
        $post = $postRepository->getPost($identifier);
        if ($post === null) {
            throw new \Exception("Le commentaire $identifier n'existe pas.");
        }

        require('./templates/update_post.php');
    }
}
