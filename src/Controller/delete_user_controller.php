<?php

use dao\UserDao;

require "../../vendor/autoload.php";

session_start();

$user_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($user_id !== false) {
    try {
        (new UserDao)->deleteUser($user_id);
        header("Location: show_users_controller");
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    header("Location: show_users_controller");
    exit;
}
