<?php

use dao\UserDao;
use model\User;

include "../../vendor/autoload.php";

try {
    $userDao = new UserDao();
    $listUsers = $userDao->get_all_user();

    foreach ($listUsers as $key => $user) {
        $listUsers[$key] = (new User())
            ->setId_user($user["id_user"])
            ->setNom($user["nom"])
            ->setPrenom($user["prenom"])
            ->setPseudo($user["pseudo"])
            ->setEmail($user["email"])
            ->setDate_creation($user["date_creation"])
            ->setId_genre($user["id_genre"])
            ->setId_group($user["id_group"]);
    }

    include "../View/show_users.php";
} catch (PDOException $e) {
    echo $e->getMessage();
}
