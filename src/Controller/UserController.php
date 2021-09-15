<?php

namespace controller;

use PDOException;
use entity\User;
use repository\{UserRepository, GroupeRepository, GenreRepository};
use framework\{Request, Router, Session};

class UserController
{
    public function __construct(
        private Request $request,
        private Router  $router,
        private Session $session
    )
    {
    }

    public function index()
    {
        try {
            $listUsers = (new UserRepository())->getAllUser();
            require TEMPLATES . DIRECTORY_SEPARATOR . "index.html.php";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function show(int $id)
    {
        try {
            $userDao = new UserRepository();
            $user = $userDao->getUserById($id);

            if (!is_null($user)) {
                require TEMPLATES . DIRECTORY_SEPARATOR . "show.html.php";
            } else {
                $this->router->redirectToRoute();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function edit(int $id)
    {
        try {
            $userDao = new UserRepository();
            $user = $userDao->getUserById($id);
            $genres = (new GenreRepository())->getAllGenre();
            $groupes = (new GroupeRepository())->getAllGroupe();

            if ($this->request->getMethod() === "GET") {
                if (!is_null($user)) {
                    require TEMPLATES . DIRECTORY_SEPARATOR . "edit.html.php";
                } else {
                    $this->router->redirectToRoute();
                }
            } elseif ($this->request->getMethod() === "POST") {
                $args = [
                    "nom" => [
                        "filter" => FILTER_VALIDATE_REGEXP,
                        "options" => [
                            "regexp" => "#^[A-Z]#"
                        ]
                    ],
                    "prenom" => [
                        "filter" => FILTER_VALIDATE_REGEXP,
                        "options" => [
                            "regexp" => "#^[A-Z]#"
                        ]
                    ],
                    "pseudo" => [
                        "filter" => FILTER_VALIDATE_REGEXP,
                        "options" => [
                            "regexp" => "#^[\w\s-]+$#u"
                        ]
                    ],
                    "email" => [
                        "filter" => FILTER_VALIDATE_EMAIL
                    ],
                    "pwd" => [],
                    "genre" => [
                        "filter" => FILTER_VALIDATE_INT
                    ],
                    "groupe" => [
                        "filter" => FILTER_VALIDATE_INT
                    ]
                ];

                $edit_post = filter_input_array(INPUT_POST, $args);

                if (empty($_POST["nom"])) $edit_post["nom"] = null;
                if (empty($_POST["prenom"])) $edit_post["prenom"] = null;
                if (empty($_POST["genre"])) $edit_post["genre"] = null;
                if (empty($_POST["groupe"])) $edit_post["groupe"] = null;

                if ($edit_post["nom"] === false) {
                    $error_messages[] = "Nom inexistant";
                }

                if ($edit_post["prenom"] === false) {
                    $error_messages[] = "Prénom inexistant";
                }

                if ($edit_post["pseudo"] === false) {
                    $error_messages[] = "Pseudo inexistant";
                }

                if ($edit_post["email"] === false) {
                    $error_messages[] = "Email inexistant";
                }

                if (empty(trim($edit_post["pwd"]))) {
                    $error_messages[] = "Mot de passe inexistant";
                }

                if ($edit_post["genre"] === false) {
                    $error_messages[] = "Genre inexistant";
                }

                if ($edit_post["groupe"] === false) {
                    $error_messages[] = "Groupe inexistant";
                }

                if (empty($error_messages)) {
                    foreach ($genres as $genre) {
                        if ($genre->getId_genre() === $edit_post["genre"]) $edit_post["genre"] = $genre->getType();
                    }
                    foreach ($groupes as $groupe) {
                        if ($groupe->getId_group() === $edit_post["groupe"]) $edit_post["groupe"] = $groupe->getNom();
                    }

                    $edit_user = (new User)
                        ->setId_user($id)
                        ->setNom($edit_post["nom"])
                        ->setPrenom($edit_post["prenom"])
                        ->setPseudo($edit_post["pseudo"])
                        ->setEmail($edit_post["email"])
                        ->setPwd(password_hash($edit_post["pwd"], PASSWORD_DEFAULT))
                        ->setGenre($edit_post["genre"])
                        ->setGroup($edit_post["groupe"]);
                    $userDao->updateUser($edit_user);
                    $this->router->redirectToRoute(sprintf("user/%d/show", $id));
                } else {
                    require TEMPLATES . DIRECTORY_SEPARATOR . "edit.html.php";
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function delete(int $id)
    {
        try {
            (new UserRepository())->deleteUser($id);
            $this->router->redirectToRoute("user");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}