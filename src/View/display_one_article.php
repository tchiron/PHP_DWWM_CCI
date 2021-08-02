<?php
$title = sprintf("Affiche l'article %d", $article['id_article']);
include 'header.php';
?>
<article>
    <h1><?= trim(filter_var($article["title"], FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?></h1>
    <p><?= nl2br(trim(filter_var($article["description"], FILTER_SANITIZE_FULL_SPECIAL_CHARS))) ?></p>
    <a href="edit_article_controller.php?id=<?= $article["id_article"] ?>">Editer l'article</a>
</article>

<?php
include 'footer.php'; ?>