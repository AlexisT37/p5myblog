<?php $title = "Alexis Troïtzky"; ?>

<?php ob_start(); ?>
<h1>Alexis Troïtzky</h1>
<p>Liste des posts :</p>



<?php
foreach ($posts as $post) {
    if ($post->validated == 1) {

?>
        <div class="news">
            <h3>
                <?= htmlspecialchars($post->title); ?>
                <em>le <?= $post->frenchCreationDate; ?></em>
            </h3>
            <h4><?= htmlspecialchars($post->leadParagraph) ?></h4>
            <p>
                <?= nl2br(htmlspecialchars($post->content)); ?>
                <br />
                <em><a href="index.php?action=post&id=<?= urlencode($post->identifier) ?>">Commentaires</a></em>
            </p>
        </div>
<?php
    }
}
?>

<form action="index.php?action=addPost" method="post">
    <div>
        <label for="title">Titre</label><br />
        <input type="text" id="title" name="title" />
    </div>
    <div>
        <label for="content">Contenu</label><br />
        <textarea id="content" name="content"></textarea>
    </div>
    <div>
        <label for="leadParagraph">Chapô</label><br />
        <textarea id="leadParagraph" name="leadParagraph"></textarea>
    </div>
    <div>
        <input type="submit" id="submitPost" value="Soumettre Post" />
    </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>