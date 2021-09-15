<?php

namespace controller;

use PDOException;
use entity\User;
use repository\UserRepository;
use framework\{Request, Router, Session};

class SigninController
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
        if ($this->request->getMethod() === "GET") {
            require TEMPLATES . DIRECTORY_SEPARATOR . "index.html.php";
        } elseif ($this->request->getMethod() === "POST") {
            $args = [
                "email" => [
                    "filter" => FILTER_VALIDATE_EMAIL
                ],
                "pwd" => []
            ];

            $signin_user = filter_input_array(INPUT_POST, $args);

            if ($signin_user["email"] === false) {
                $error_messages[] = "Email inexistant";
            }

            if (empty(trim($signin_user["pwd"]))) {
                $error_messages[] = "Mot de passe inexistant";
            }

            if (empty($error_messages)) {
                $signin_user = (new User())
                    ->setEmail($signin_user["email"])
                    ->setPwd($signin_user["pwd"]);

                try {
                    $userDao = new UserRepository();
                    $user = $userDao->getUserByEmail($signin_user->getEmail());

                    if (!is_null($user)) {
                        if (password_verify($signin_user->getPwd(), $user->getPwd())) {
                            $user = $userDao->getUserById($user->getId_user());
                            session_regenerate_id(true);
                            $_SESSION["user"] = $user;
                            $this->router->redirectToRoute();
                        } else {
                            $error_messages[] = "Mot de passe erroné";
                            require TEMPLATES . DIRECTORY_SEPARATOR . "index.html.php";
                        }
                    } else {
                        $error_messages[] = "Email erroné";
                        require TEMPLATES . DIRECTORY_SEPARATOR . "index.html.php";
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            } else {
                require TEMPLATES . DIRECTORY_SEPARATOR . "index.html.php";
            }
        }
    }
}