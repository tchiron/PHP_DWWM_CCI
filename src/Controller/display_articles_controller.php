<?php

use repository\ArticleRepository;

try {
    $articles = (new ArticleRepository())->getAllArticle();
    include TEMPLATES . DIRECTORY_SEPARATOR . "display_articles.php";
} catch (PDOException $e) {
    echo $e->getMessage();
}
