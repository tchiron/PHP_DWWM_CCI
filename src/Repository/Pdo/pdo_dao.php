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