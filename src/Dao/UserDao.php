<?php

namespace dao;

use PDO;
use model\User;

class UserDao
{
    private PDO $pdo;

    public function __construct()
    {
        $conf = [
            "dsn" => "mysql:host=localhost;dbname=ccib;charset=UTF8",
            "user" => "root",
            "password" => "",
        ];
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $this->pdo = new PDO(
            $conf["dsn"],
            $conf["user"],
            $conf["password"],
            $options
        );
    }

    public function addUser(User $user)
    {
        $req = $this->pdo->prepare("INSERT INTO user (pseudo, email, pwd) VALUES (:pseudo, :email, :pwd)");
        $req->execute([
            ":pseudo" => $user->getPseudo(),
            ":email" => $user->getEmail(),
            ":pwd" => $user->getPwd()
        ]);
    }

    public function getAllUser(): array
    {
        $req = $this->pdo->prepare("SELECT u.id_user AS id,
                                        u.nom AS nom,
                                        u.prenom AS prenom,
                                        u.pseudo AS pseudo,
                                        u.email AS email,
                                        u.date_creation AS date_creation,
                                        g.type AS genre,
                                        r.nom AS groupe
                                    FROM user AS u
                                    LEFT OUTER JOIN genre AS g
                                        ON u.id_genre = g.id_genre
                                    LEFT OUTER JOIN groupe AS r
                                        ON u.id_group = r.id_group
        ");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
