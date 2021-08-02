<?php

$article_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($article_id !== false) {
    include "../Dao/article_dao.php";
    include "../Dao/commentaire_dao.php";

    try {
        $article = get_article_by_id($article_id);

        if (!empty($article)) {
            $commentaires = get_commentaire_by_article_id($article_id);
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
