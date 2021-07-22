<?php
$title = "Ajout d'un nouvel article";
include 'header.php';

foreach ($articles as $article) : ?>
    <article>
        <h1><?= $article["title"] ?></h1>
        <p><?= $article["description"] ?></p>
    </article>

<?php endforeach;
include 'footer.php'; ?>