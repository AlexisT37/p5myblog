<?php



require_once('../src/controllers/post/validate.php');
require_once('../src/controllers/comment/validate.php');

use Application\Controllers\Post\Validate\ValidatePost;
use Application\Controllers\Comment\Validate\ValidateComment;

if (isset($_GET['action']) && $_GET['action'] !== '') {
    if ($_GET['action'] === "ValidatePost") {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];

            (new ValidatePost())->execute($identifier);
        } else {
            throw new Exception('Aucun identifiant de billet envoyé');
        }
    }
    if ($_GET['action'] === "ValidateComment") {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];

            (new ValidateComment())->execute($identifier);
        } else {
            throw new Exception('Aucun identifiant de billet envoyé');
        }
    }
}
