<?php
$title = "Affiche tous les articles";
include 'header.php';

foreach ($articles as $article) : ?>
    <article>
        <h1><?= trim(filter_var($article->setTitle(), FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?></h1>
        <p><?= nl2br(trim(filter_var($article->setDescription(), FILTER_SANITIZE_FULL_SPECIAL_CHARS))) ?></p>
        <a href="display_one_article_controller.php?id=<?= $article->setId_article() ?>">Lire l'article</a>
    </article>

<?php endforeach;
include 'footer.php'; ?>