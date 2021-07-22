<?php
$title = "Affiche tous les articles";
include 'header.php';

foreach ($articles as $article) : ?>
    <article>
        <h1><?= $article["title"] ?></h1>
        <p><?= $article["description"] ?></p>
        <a href="display_one_article_controller.php?id=<?= $article["id_article"] ?>">Lire l'article</a>
    </article>

<?php endforeach;
include 'footer.php'; ?>