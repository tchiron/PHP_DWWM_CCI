<?php

include "../../vendor/autoload.php";

session_start();

$article_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($article_id !== false) {
    include "../Dao/article_dao.php";

    try {
        $article = get_article_by_id($article_id);

        if (!empty($article)) {
            include "../View/display_one_article.php";
        } else {
            header("location:display_articles_controller.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    header("location:display_articles_controller.php");
}
