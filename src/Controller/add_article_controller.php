<?php

$options_title = ["options" => [
    "regexp" => "#^[A-Z]#u"
]];

$article_title = filter_input(
    INPUT_POST,
    "title",
    FILTER_VALIDATE_REGEXP,
    $options_title
);

$article_description =  filter_input(
    INPUT_POST,
    "description"
);

if (isset($article_title) && isset($article_description)) {
    if ($article_title === false) {
        $error_messages[] = "Titre inexistant";
    }

    if (empty(trim($article_description))) {
        $error_messages[] = "Description inexistante";
    }
}

if (!(isset($article_title) && isset($article_description)) || !empty($error_messages)) {
    include "../View/add_article.php";
} else {
    include "../Dao/article_dao.php";
    try {
        add_article($article_title, $article_description);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}