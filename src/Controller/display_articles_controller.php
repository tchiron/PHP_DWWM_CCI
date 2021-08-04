<?php

session_start();

include "../Dao/article_dao.php";

try {
    $articles = get_all_article();
    include "../View/display_articles.php";
} catch (PDOException $e) {
    echo $e->getMessage();
}
