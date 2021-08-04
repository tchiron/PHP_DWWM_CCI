<?php

include "../../vendor/autoload.php";

session_start();

$article_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($article_id !== false) {

    if (empty($_POST)) {

        include "../Dao/article_dao.php";

        try {
            $article = get_article_by_id($article_id);

            if (!empty($article)) {
                include "../View/edit_article.php";
            } else {
                header("location:display_articles_controller.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {

        $args = [
            "title" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => [
                    "regexp" => "#^[A-Z]#u"
                ]
            ],
            "description" => []
        ];


        $article = filter_input_array(
            INPUT_POST,
            $args
        );
        $article["id_article"] = $article_id;

        if (isset($article["title"]) && isset($article["description"])) {
            if ($article["title"] === false) {
                $error_messages[] = "Titre inexistant";
            }

            if (empty(trim($article["description"]))) {
                $error_messages[] = "Description inexistante";
            }
        }

        if (!(isset($article["title"]) && isset($article["description"])) || !empty($error_messages)) {
            include "../View/edit_article.php";
        } else {
            include "../Dao/article_dao.php";
            try {
                update_article($article);
                header(sprintf("location:display_one_article_controller.php?id=%d", $article["id_article"]));
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
} else {
    header("location:display_articles_controller.php");
}
