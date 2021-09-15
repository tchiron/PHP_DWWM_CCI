<?php
$title = "Affiche tous les articles";
include TEMPLATES . DIRECTORY_SEPARATOR . 'header.php';

foreach ($articles as $article) : ?>
    <article>
        <h1><?= trim(filter_var($article->getTitle(), FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?></h1>
        <p><?= nl2br(trim(filter_var($article->getDescription(), FILTER_SANITIZE_FULL_SPECIAL_CHARS))) ?></p>
        <a href="article/<?= $article->getId_article() ?>/show">Lire l'article</a>
    </article>

<?php endforeach;
include TEMPLATES . DIRECTORY_SEPARATOR . 'footer.php'; ?>