<?php

use dao\GenreDao;
use dao\GroupeDao;
use dao\UserDao;

require "../../vendor/autoload.php";

session_start();

$user_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($user_id !== false) {
    if (empty($_POST)) {
        try {
            $user = (new UserDao())->getUserById($user_id);
            $genres = (new GenreDao())->getAllGenre();
            $groupes = (new GroupeDao())->getAllGroupe();

            if (!is_null($user)) {
                require "../View/edit_user.php";
            } else {
                header("Location: display_articles_controller.php");
                exit;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        # code...
    }
} else {
    header("Location: display_articles_controller.php");
    exit;
}
