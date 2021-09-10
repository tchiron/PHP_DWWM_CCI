<?php

namespace controller;

use PDOException;
use entity\Article;
use repository\{ArticleRepository, CommentaireRepository};
use framework\{Request, Session, Router};

class ArticleController
{
    public function __construct(
        private Request $request,
        private Router $router,
        private Session $session
    ) {
    }

    public function index()
    {
        try {
            $articles = (new ArticleRepository())->getAllArticle();
            include TEMPLATES . DIRECTORY_SEPARATOR . "display_articles.php";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function new()
    {
        if ("GET" === $this->request->getMethod()) {
            require TEMPLATES . DIRECTORY_SEPARATOR . "add_article.php";
        } elseif ("POST" === $this->request->getMethod()) {
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
                require TEMPLATES . DIRECTORY_SEPARATOR . "add_article.php";
            } else {
                $article = (new Article())
                    ->setTitle($article_post["title"])
                    ->setDescription($article_post["description"]);

                try {
                    $id = (new ArticleRepository())->addArticle($article);
                    $this->router->redirectToRoute("article", $id, "show");
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }
    }

    public function show(int $id)
    {
        try {
            $article = (new ArticleRepository())->getArticleById($id);
    
            if (!is_null($article)) {
                $commentaires = (new CommentaireRepository())->getCommentaireByArticleId($id);
                require TEMPLATES . DIRECTORY_SEPARATOR ."display_one_article.php";
            } else {
                $this->router->redirectToRoute();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function edit(int $id)
    {
        if ($this->request->getMethod() === 'GET') {
            try {
                $article = (new ArticleRepository())->getArticleById($id);
    
                if (!is_null($article)) {
                    require TEMPLATES . DIRECTORY_SEPARATOR . "edit_article.php";
                } else {
                    $this->router->redirectToRoute();
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } elseif ($this->request->getMethod() === 'POST') {
            $args = [
                "title" => [
                    "filter" => FILTER_VALIDATE_REGEXP,
                    "options" => [
                        "regexp" => "#^[A-Z]#u"
                    ]
                ],
                "description" => []
            ];
    
            $article_post = filter_input_array(
                INPUT_POST,
                $args
            );
    
            if (isset($article_post["title"]) && isset($article_post["description"])) {
                if ($article_post["title"] === false) {
                    $error_messages[] = "Titre inexistant";
                }
    
                if (empty(trim($article_post["description"]))) {
                    $error_messages[] = "Description inexistante";
                }
            }
    
            if (!(isset($article_post["title"]) && isset($article_post["description"])) || !empty($error_messages)) {
                require TEMPLATES . DIRECTORY_SEPARATOR . "edit_article.php";
            } else {
                $article = (new Article())
                    ->setId_article($id)
                    ->setTitle($article_post["title"])
                    ->setDescription($article_post["description"]);
    
                try {
                    (new ArticleRepository())->updateArticle($article);
                    $this->router->redirectToRoute(sprintf("article/%d/show", $article->getId_article()));
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }
    }

    public function delete(int $id)
    {
        try {
            (new ArticleRepository())->deleteArticle($id);
            $this->router->redirectToRoute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
