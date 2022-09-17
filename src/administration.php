<?php

require_once('../src/lib/database.php');
require_once('../src/model/post.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Post\PostRepository;

ob_start();

$postRepository = new PostRepository();
$postRepository->connection = new DatabaseConnection();
$posts = $postRepository->getPosts();
?>



<?php
foreach ($posts as $post) {
    if ($post->validated == 0) {

?>
        <div class="news">
            <h3>
                <?= htmlspecialchars($post->title); ?>
                <em>le <?= $post->frenchCreationDate; ?></em>
                <em><a href="index.php?action=post&id=<?= urlencode($post->validatePost()) ?>">Valider le post</a></em>
            </h3>
            <h4><?= htmlspecialchars($post->leadParagraph) ?></h4>
            <p>
                <?= nl2br(htmlspecialchars($post->content)); ?>
                <br />
            </p>
        </div>
<?php
    }
}
?>

<?php $contentAdmin = ob_get_clean();
require('../templates/administration.php');
?>