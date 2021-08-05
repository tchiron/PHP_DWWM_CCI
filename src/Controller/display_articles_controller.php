<?php

use dao\ArticleDao;

include "../../vendor/autoload.php";

session_start();

try {
    $articles = (new ArticleDao())->getAllArticle();
    include "../View/display_articles.php";
} catch (PDOException $e) {
    echo $e->getMessage();
}
