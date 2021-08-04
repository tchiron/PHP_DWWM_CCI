<?php

session_start();

use dao\UserDao;
use model\User;

include "../../vendor/autoload.php";

try {
    $userDao = new UserDao();
    $listUsers = $userDao->getAllUser();

    foreach ($listUsers as $key => $user) {
        $listUsers[$key] = (new User())
            ->setId_user($user["id"])
            ->setNom($user["nom"])
            ->setPrenom($user["prenom"])
            ->setPseudo($user["pseudo"])
            ->setEmail($user["email"])
            ->setDate_creation($user["date_creation"])
            ->setGenre($user["genre"])
            ->setGroup($user["groupe"]);
    }

    include "../View/show_users.php";
} catch (PDOException $e) {
    echo $e->getMessage();
}
