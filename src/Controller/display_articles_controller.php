<?php

use repository\ArticleRepository;

include "../../vendor/autoload.php";

session_start();

try {
    $articles = (new ArticleRepository())->getAllArticle();
    include "../View/display_articles.php";
} catch (PDOException $e) {
    echo $e->getMessage();
}
