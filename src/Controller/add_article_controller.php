<?php

use dao\ArticleDao;

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

$article = filter_input_array(INPUT_POST, $args);

if (isset($article["title"]) && isset($article["description"])) {
    if ($article["title"] === false) {
        $error_messages[] = "Titre inexistant";
    }

    if (empty(trim($article["description"]))) {
        $error_messages[] = "Description inexistante";
    }
}

if (!(isset($article["title"]) && isset($article["description"])) || !empty($error_messages)) {
    include "../View/add_article.php";
} else {
    try {
        (new ArticleDao())->addArticle($article["title"], $article["description"]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
