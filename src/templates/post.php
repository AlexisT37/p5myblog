<?php $title = "Alexis Troïtzky"; ?>

<?php ob_start(); ?>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?= htmlspecialchars($post->title) ?>
        <em>le <?= $post->frenchCreationDate ?></em>
    </h3>
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
    if ($comment->validated == 1) {
?>
        <p><strong><?= htmlspecialchars($users[$comment->identifier]) ?></strong> le <?= $comment->frenchCreationDate ?>

            <?php if (!empty($loggedUserId) && $comment->author == $loggedUserId) {

            ?>
                (<a href="index.php?action=updateComment&id=<?= $comment->identifier ?>">modifier</a>)</p>
    <?php } ?>
    <p><?= nl2br(htmlspecialchars($comment->comment)) ?></p>
<?php
    }
}
?>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>