<!DOCTYPE html>
<html lang="en">

<?php

require_once('../src/controllers/comment/add.php');
require_once('../src/controllers/comment/update.php');
require_once('../src/controllers/homepage.php');
require_once('../src/controllers/post.php');
require_once('../src/controllers/post/add.php');
require_once('../src/controllers/post/update.php');
require_once('../src/controllers/post/delete.php');
require_once('../src/controllers/comment/delete.php');

use Application\Controllers\Comment\Add\AddComment;
use Application\Controllers\Comment\Update\UpdateComment;
use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Post\Post;
use Application\Controllers\Post\Add\AddPost;
use Application\Controllers\Post\Update\UpdatePost;
use Application\Controllers\Post\Delete\DeletePost;
use Application\Controllers\Comment\Delete\DeleteComment;

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                (new Post())->execute($identifier);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] === 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                (new AddComment())->execute($identifier, $_POST);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] === 'updateComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                // It sets the input only when the HTTP method is POST (ie. the form is submitted).
                $input = null;
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $input = $_POST;
                }

                (new UpdateComment())->execute($identifier, $input);
            } else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        } elseif ($_GET['action'] === 'addPost') {
            
                $input = null;
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $input = $_POST;
                }
                (new addPost())->execute($identifier, $input);
        } elseif ($_GET['action'] === 'updatePost') {
            $identifier = $_GET['id'];
            $input = null;
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $input = $_POST;
            }
            (new UpdatePost())->execute($identifier, $input);
    } elseif ($_GET['action'] === 'deletePost') {
        $identifier = $_GET['id'];
        $input = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = $_POST;
        }
        (new DeletePost())->execute($identifier, $input);
} elseif ($_GET['action'] === 'deleteComment') {
    $identifier = $_GET['id'];
    $input = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = $_POST;
    }
    (new DeleteComment())->execute($identifier, $input);
}
    
    else {
            throw new Exception("La page que vous recherchez n'existe pas.");
        }
    } else {
        (new Homepage())->execute();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('./templates/error.php');
}
