<?php $title = "Alexis Troïtzky"; ?>

<?php ob_start(); ?>

<div class="news">
    <h3>
        <?= htmlspecialchars($post->title) ?>
        <em>le <?= $post->frenchCreationDate ?></em>
    </h3>
    <?php if (!empty($loggedUserId) && $post->userId == $loggedUserId) {

?>
    (<a href="index.php?action=updatePost&id=<?= $post->identifier ?>">Modifier le post</a>)</p>
    <br>
    (<a id="deletePostButton" href="index.php?action=deletePost&id=<?= $post->identifier ?>">Supprimer le post</a>)</p>

<?php } ?>
    <h4><?= htmlspecialchars($post->leadParagraph) ?></h4>

    <p>
        <?= nl2br(htmlspecialchars($post->content)) ?>
    </p>
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

            <?php if (!empty($loggedUserId) && $comment->author == $loggedUserId) {

            ?>
            <p><?= nl2br(htmlspecialchars($comment->comment)) ?></p>
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