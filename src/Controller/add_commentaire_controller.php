<?php

$article_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($article_id !== false) {
    if (empty($_POST)) {
        include "../View/add_commentaire.php";
    } else {
        $commentaire = [
            "article_id" => $article_id,
            "contenu" => filter_input(INPUT_POST, "contenu")
        ];

        if (isset($commentaire["contenu"]) && empty(trim($commentaire["contenu"]))) {
            $error_messages[] = "Commentaire inexistante";
        }

        if (!isset($commentaire["contenu"]) || !empty($error_messages)) {
            include "../View/add_commentaire.php";
        } else {
            include "../Dao/commentaire_dao.php";
            try {
                add_commentaire($commentaire);
                header(sprintf("location: display_one_article_controller.php?id=%d", $commentaire["article_id"]));
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
} else {
    header("Location: display_articles_controller.php");
}
