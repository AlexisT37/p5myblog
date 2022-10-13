<?php $title = "Alexis Troïtzky"; ?>

<?php ob_start(); ?>
<p><a href="index.php?action=post&id=<?= $post->identifier ?>">Retour au billet</a></p>

<h2>Modification du post</h2>

<script src="./js/tinymce/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script src="./js/post.js"></script>

<form action="index.php?action=updatePost&id=<?= $post->identifier ?>" method="post">
   <div>
      <label for="title">Titre</label><br />
      <textarea id="modiftitle" name="modiftitle"><?= htmlspecialchars($post->title) ?></textarea>
   </div>
   <div>
      <label for="modifleadParagraph">Chapô</label><br />
      <textarea id="modifleadParagraph" name="modifleadParagraph"><?= htmlspecialchars($post->leadParagraph) ?></textarea>
   </div>
   <div>
      <label for="modifcontent">Titre</label><br />
      <textarea id="modifcontent" name="modifcontent"><?= htmlspecialchars($post->content) ?></textarea>
   </div>
   <div>
      <input type="submit" value="Modifier le post" />
   </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
