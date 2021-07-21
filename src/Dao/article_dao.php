<?php

function add_article(string $title, string $description)
{
    $dbh = new PDO(
        "mysql:host=localhost;dbname=ccib;charset=UTF8",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    $req = $dbh->prepare("INSERT INTO article (title, description) VALUES (:title, :description)");

    $req->execute([
        ":title" => $title,
        ":description" => $description
    ]);
}
