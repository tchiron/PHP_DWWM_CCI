<?php

include "../../vendor/autoload.php";

use dao\UserDao;
use model\User;

session_start();

if (isset($_SESSION["user"])) {
    header("Location: display_articles_controller.php");
    exit;
}

if (empty($_POST)) {
    include "../View/signin.php";
} else {
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
            $userDao = new UserDao();
            $result = $userDao->getUserByEmail($signin_user->getEmail());

            if (!empty($result)) {
                $user = (new User())
                    ->setId_user($result["id_user"])
                    ->setEmail($result["email"])
                    ->setPwd($result["pwd"]);

                if (password_verify($signin_user->getPwd(), $user->getPwd())) {
                    $result = $userDao->getUserById($user->getId_user());
                    $user = (new User())
                        ->setId_user($result["id"])
                        ->setNom($result["nom"])
                        ->setPrenom($result["prenom"])
                        ->setPseudo($result["pseudo"])
                        ->setEmail($result["email"])
                        ->setDate_creation($result["date_creation"])
                        ->setGenre($result["genre"])
                        ->setGroup($result["groupe"]);
                    $_SESSION["user"] = $user;
                    header("Location: display_articles_controller.php");
                    exit;
                } else {
                    $error_messages[] = "Mot de passe erroné";
                    include "../View/signin.php";
                    exit;
                }
            } else {
                $error_messages[] = "Email erroné";
                include "../View/signin.php";
                exit;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        include "../View/signin.php";
        exit;
    }
}
