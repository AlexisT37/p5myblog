<?php

require_once('../src/lib/database.php');
require_once('../src/controllers/post/PostRepository.php');
require_once('../src/controllers/comment/CommentRepository.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Controllers\Post\PostRepository\PostRepository;

use Application\Controllers\Comment\CommentRepository\CommentRepository;

ob_start();

$postRepository = new PostRepository();
$postRepository->connection = new DatabaseConnection();
$posts = $postRepository->getPosts();

$commentRepository = new CommentRepository();
$commentRepository->connection = new DatabaseConnection();
$unvalidatedComments = $commentRepository->getUnvalidatedComments();

?>




<?php
foreach ($posts as $post) {
    if ($post->validated == 0) {

?>
        <div class="news">
            <h3>
                <?= htmlspecialchars($post->title); ?>
                <em>le <?= $post->frenchCreationDate; ?></em>

                (<a href="administrationindex.php?action=ValidatePost&id=<?= $post->identifier ?>">Valider le post</a>)</p>
            </h3>
            <h4><?= htmlspecialchars($post->leadParagraph) ?></h4>
            <p>
                <?php echo $post->content?>
                <br />
            </p>
        </div>
<?php
    }
}
?>
<br>
<div class="col-lg-12 text-center">
    <h2>Liste des Commentaires non validés</h2>
</div>

<?php
foreach ($unvalidatedComments as $unvalidatedComment) {
    
?>
        <p><strong><?= htmlspecialchars($unvalidatedComment->identifier) ?></strong> <?= $unvalidatedComment->frenchCreationDate ?>

            <?php if (1 == 1) {

            ?>
                (<a href="administrationindex.php?action=ValidateComment&id=<?= $unvalidatedComment->identifier ?>">Valider le commentaire</a>)</p>
    <?php } ?>
    <p>
        <?php echo $unvalidatedComment->comment?>
    </p>
<?php
    
}
?>

<?php $contentAdmin = ob_get_clean();
require('./templates/administration.php');
?>
