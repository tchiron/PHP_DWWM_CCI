<?php

use repository\ArticleRepository;

include "../../vendor/autoload.php";

session_start();

$article_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($article_id !== false) {
    include "../Repository/commentaire_dao.php";
    try {
        $article = (new ArticleRepository())->getArticleById($article_id);

        if (!is_null($article)) {
            $commentaires = get_commentaire_by_article_id($article_id);
            include "../View/display_one_article.php";
        } else {
            header("location:display_articles_controller.php");
            exit;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    header("location:display_articles_controller.php");
    exit;
}
