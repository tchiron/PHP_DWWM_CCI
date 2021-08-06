<?php

$commentaire_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$article_id = filter_input(INPUT_GET, "article", FILTER_VALIDATE_INT);

if ($commentaire_id !== false && $article_id !== false) {
    $commentaire = [
        "id_commentaire" => $commentaire_id,
        "id_article" => $article_id
    ];

    if (empty($_POST)) {
        include "../Repository/commentaire_dao.php";

        try {
            $commentaire = get_commentaire_by_id($commentaire_id);
            include "../View/edit_commentaire.php";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        $commentaire["contenu"] = filter_input(INPUT_POST, "contenu");

        if (isset($commentaire["contenu"]) && empty(trim($commentaire["contenu"]))) {
            $error_messages[] = "Commentaire inexistante";
        }

        if (!isset($commentaire["contenu"]) || !empty($error_messages)) {
            include "../View/edit_commentaire.php";
        } else {
            include "../Repository/commentaire_dao.php";

            try {
                update_commentaire($commentaire);
                header(sprintf("location: display_one_article_controller.php?id=%d", $commentaire["id_article"]));
                exit;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
} else {
    header("Location: display_articles_controller.php");
    exit;
}
