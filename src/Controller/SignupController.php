<?php

namespace controller;

use PDOException;
use entity\User;
use repository\UserRepository;
use framework\{Request, Router, Session};

class SignupController
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
            require TEMPLATES . DIRECTORY_SEPARATOR . "signup/index.html.php";
        } elseif ($this->request->getMethod() === "POST") {
            $args = [
                "pseudo" => [
                    "filter" => FILTER_VALIDATE_REGEXP,
                    "options" => [
                        "regexp" => "#^[\w\s-]+$#u"
                    ]
                ],
                "email" => [
                    "filter" => FILTER_VALIDATE_EMAIL
                ],
                "pwd" => []
            ];

            $signup_post = filter_input_array(INPUT_POST, $args);

            if ($signup_post["pseudo"] === false) {
                $error_messages[] = "Pseudo inexistant";
            }

            if ($signup_post["email"] === false) {
                $error_messages[] = "Email inexistant";
            }

            if (empty(trim($signup_post["pwd"]))) {
                $error_messages[] = "Mot de passe inexistant";
            }

            if (empty($error_messages)) {
                try {
                    $userDao = new UserRepository();
                    $exist_user = $userDao->getUserByEmail($signup_post["email"]);

                    if (is_null($exist_user)) {
                        $signup_user = (new User())
                            ->setPseudo($signup_post["pseudo"])
                            ->setEmail($signup_post["email"])
                            ->setPwd(password_hash($signup_post["pwd"], PASSWORD_DEFAULT));
                        $userDao->newUser($signup_user);
                        $this->router->redirectToRoute();
                    } else {
                        $error_messages[] = "Cet email est déjà utilisé";
                        require TEMPLATES . DIRECTORY_SEPARATOR . "signup/index.html.php";
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            } else {
                require TEMPLATES . DIRECTORY_SEPARATOR . "signup/index.html.php";
            }
        }
    }
}