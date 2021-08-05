<?php
$title = sprintf("Affiche l'article %d", $article->getId_article());
include 'header.php';
?>
<article>
    <h1><?= trim(filter_var($article->getTitle(), FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?></h1>
    <p><?= nl2br(trim(filter_var($article->getDescription(), FILTER_SANITIZE_FULL_SPECIAL_CHARS))) ?></p>
    <a href="edit_article_controller.php?id=<?= $article->getId_article() ?>">Editer l'article</a>
    <a href="delete_article_controller.php?id=<?= $article->getId_article() ?>">Supprimer l'article</a>
</article>

<?php
include 'footer.php'; ?>