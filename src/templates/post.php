<?php $title = "Alexis Troïtzky"; ?>

<?php ob_start(); ?>

<!-- Portfolio Grid Section -->
<section id="portfolio">
        <div class="container">
            <div class="row">
                <div id="list_of_posts" class="col-lg-12 text-center">
                    <h2><?php echo $post->title?></h2>
                    <hr class="star-primary">
                </div>
            </div>


        </div>
    </section>

<div class="news">

    <h3>
        <em>Par <?= $postUsername ?></em>
    </h3>
    <br>
    <h3>
        <em>le <?= $post->frenchCreationDate ?></em>
    </h3>

    <h4><?= htmlspecialchars($post->leadParagraph) ?></h4>

    <p>
        <?= nl2br(htmlspecialchars($post->content)) ?>
    </p>

    <?php if (!empty($loggedUserId) && $post->userId == $loggedUserId) {

    ?>
        (<a href="index.php?action=updatePost&id=<?= $post->identifier ?>">Modifier le post</a>)</p>
        <br>
        (<a id="deletePostButton" href="index.php?action=deletePost&id=<?= $post->identifier ?>">Supprimer le post</a>)</p>

    <?php } ?>
</div>

<h2>Commentaires</h2>

<form action="index.php?action=addComment&id=<?= $post->identifier ?>" method="post">
    <div>
        <label for="comment">Commentaire</label><br />
        <textarea id="comment" name="comment"></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>

<?php
foreach ($comments as $comment) {
    if ($comment->validated == 1 && $comment->deleted == 0) {
?>
        <p><strong><?= htmlspecialchars($users[$comment->identifier]) ?></strong> dernière modifiaction le <?= $comment->frenchModifiedDate ?>
        <p><?= nl2br(htmlspecialchars($comment->comment)) ?></p>

            <?php if (!empty($loggedUserId) && $comment->author == $loggedUserId) {

            ?>
        <br>
        (<a href="index.php?action=updateComment&id=<?= $comment->identifier ?>">modifier le commentaire</a>)</p>
        <br>
        (<a id="deleteCommentButton" href="index.php?action=deleteComment&id=<?= $comment->identifier ?>">Supprimer le commentaire</a>)</p>
    <?php } ?>
<?php
    }
}
?>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
