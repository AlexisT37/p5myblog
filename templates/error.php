<?php $title = "Alexis Troïtzky"; ?>

<?php ob_start(); ?>
<h1>Alexis Troïtzky</h1>
<p>Une erreur est survenue : <?= $errorMessage ?></p>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>