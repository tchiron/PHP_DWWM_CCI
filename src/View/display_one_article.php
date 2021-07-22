<?php
$title = sprintf("Affiche l'article %d", $article['id_article']);
include 'header.php';
?>
<article>
    <h1><?= $article["title"] ?></h1>
    <p><?= $article["description"] ?></p>
</article>

<?php
include 'footer.php'; ?>