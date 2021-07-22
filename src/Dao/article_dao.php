<?php

function getPDO(): PDO
{
    static $dbh = "";

    if (!($dbh instanceof PDO)) {
        $dbh = new PDO(
            "mysql:host=localhost;dbname=ccib;charset=UTF8",
            "root",
            "",
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
    return $dbh;
}

function add_article(string $title, string $description): void
{
    $dbh = getPDO();
    $req = $dbh->prepare("INSERT INTO article (title, description) VALUES (:title, :description)");
    $req->execute([
        ":title" => $title,
        ":description" => $description
    ]);
}

function get_all_article(): array
{
    $dbh = getPDO();
    $req = $dbh->prepare("SELECT * FROM article");
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
