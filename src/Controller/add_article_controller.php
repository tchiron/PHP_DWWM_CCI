<?php

use dao\ArticleDao;
use model\Article;

include "../../vendor/autoload.php";

session_start();

$args = [
    "title" => [
        "filter" => FILTER_VALIDATE_REGEXP,
        "options" => [
            "regexp" => "#^[A-Z]#u"
        ]
    ],
    "description" => []
];

$article_post = filter_input_array(INPUT_POST, $args);

if (isset($article_post["title"]) && isset($article_post["description"])) {
    if ($article_post["title"] === false) {
        $error_messages[] = "Titre inexistant";
    }

    if (empty(trim($article_post["description"]))) {
        $error_messages[] = "Description inexistante";
    }
}

if (!(isset($article_post["title"]) && isset($article_post["description"])) || !empty($error_messages)) {
    include "../View/add_article.php";
} else {
    $article = (new Article())
        ->setTitle($article_post["title"])
        ->setDescription($article_post["description"]);

    try {
        $id = (new ArticleDao())->addArticle($article);
        header(sprintf("Location: display_one_article_controller.php?id=%d", $id));
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
