<?php $title = "Alexis Troïtzky"; ?>

<?php ob_start(); ?>
<p><a href="index.php?action=post&id=<?= $post->identifier ?>">Retour au billet</a></p>

<h2>Modification du post</h2>

<form action="index.php?action=updatePost&id=<?= $post->identifier ?>" method="post">
   <div>
      <label for="title">Titre</label><br />
      <textarea id="title" name="title"><?= htmlspecialchars($post->title) ?></textarea>
   </div>
   <div>
      <label for="leadParagraph">Chapô</label><br />
      <textarea id="leadParagraph" name="leadParagraph"><?= htmlspecialchars($post->leadParagraph) ?></textarea>
   </div>
   <div>
      <label for="content">Titre</label><br />
      <textarea id="content" name="content"><?= htmlspecialchars($post->content) ?></textarea>
   </div>
   <div>
      <input type="submit" value="Modifier le post" />
   </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
