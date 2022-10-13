<?php $title = "Alexis Troïtzky"; ?>

<?php ob_start(); ?>

<?php
foreach ($posts as $post) {
    if ($post->validated == 1 && $post->deleted == 0) {

?>
        <div class="news">
            <h3>
                <?= htmlspecialchars($post->title); ?>
                <h3>
                    <em>Par <?= $users[$post->userId] ?></em>
                </h3>
                <em>le <?= $post->frenchCreationDate; ?></em>
                <em><a href="index.php?action=post&id=<?= urlencode($post->identifier) ?>">Détail du post</a></em>
            </h3>
            <h4><?= htmlspecialchars($post->leadParagraph) ?></h4>
            <p>
                <?php 
                echo $post->content
                ?>
                <br />
            </p>
        </div>
<?php
    }
}
?>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
