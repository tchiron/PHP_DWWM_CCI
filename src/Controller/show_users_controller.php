<?php

include "../../vendor/autoload.php";

session_start();

use dao\UserDao;
use model\User;

try {
    $userDao = new UserDao();
    $listUsers = $userDao->getAllUser();
    include "../View/show_users.php";
} catch (PDOException $e) {
    echo $e->getMessage();
}
