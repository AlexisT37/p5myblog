<?php $title = "Alexis Troïtzky"; ?>

<?php ob_start(); ?>
<h1>Alexis Troïtzky</h1>
<p><a href="index.php?action=post&id=<?= $comment->post ?>">Retour au billet</a></p>

<h2>Modification du commentaire</h2>

<form action="index.php?action=updateComment&id=<?= $comment->identifier ?>" method="post">
   <div>
      <label for="comment">Commentaire</label><br />
      <textarea id="comment" name="comment"><?= htmlspecialchars($comment->comment) ?></textarea>
   </div>
   <div>
      <input type="submit" />
   </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>