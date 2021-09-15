<?php

namespace controller;

use PDOException;
use entity\Commentaire;
use repository\CommentaireRepository;
use framework\{Request, Router, Session};

class CommentaireController
{
    public function __construct(
        private Request $request,
        private Router $router,
        private Session $session
    )
    {
    }

    public function new(int $article_id) {
        if ($this->request->getMethod() === "GET") {
            require TEMPLATES . DIRECTORY_SEPARATOR . "add.html.php";
        } elseif ($this->request->getMethod() === "POST") {
            $commentaire_post = [
                "article_id" => $article_id,
                "contenu" => filter_input(INPUT_POST, "contenu")
            ];

            if (isset($commentaire_post["contenu"]) && empty(trim($commentaire_post["contenu"]))) {
                $error_messages[] = "Commentaire inexistante";
            }

            if (!isset($commentaire_post["contenu"]) || !empty($error_messages)) {
                require TEMPLATES . DIRECTORY_SEPARATOR . "add.html.php";
            } else {
                $commentaire = (new Commentaire())
                    ->setIdArticle($commentaire_post["article_id"])
                    ->setContenu($commentaire_post["contenu"]);

                try {
                    (new CommentaireRepository())->addCommentaire($commentaire);
                    $this->router->redirectToRoute(sprintf("article/%d/show", $article_id));
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }
    }

    public function edit(int $article_id, int $commentaire_id) {
        $commentaire = (new Commentaire())
            ->setIdCommentaire($commentaire_id)
            ->setIdArticle($article_id);

        if ($this->request->getMethod() === "GET") {
            try {
                $commentaire = (new CommentaireRepository())->getCommentaireById($commentaire_id);
                require TEMPLATES . DIRECTORY_SEPARATOR . "edit.html.php";
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } elseif ($this->request->getMethod() === "POST") {
            $commentaire_post["contenu"] = filter_input(INPUT_POST, "contenu");

            if (isset($commentaire_post["contenu"]) && empty(trim($commentaire_post["contenu"]))) {
                $error_messages[] = "Commentaire inexistante";
            }

            if (!empty($error_messages)) {
                require TEMPLATES . DIRECTORY_SEPARATOR . "edit.html.php";
            } else {
                $commentaire->setContenu($commentaire_post["contenu"]);

                try {
                    (new CommentaireRepository())->updateCommentaire($commentaire);
                    $this->router->redirectToRoute(sprintf("article/%d/show", $commentaire->getIdArticle()));
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }
    }

    public function delete(int $article_id, int $commentaire_id) {
        try {
            (new CommentaireRepository())->deleteCommentaire($commentaire_id);
            $this->router->redirectToRoute(sprintf("article/%d/show", $article_id));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}