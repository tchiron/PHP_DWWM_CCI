<?php

namespace repository;

use entity\Groupe;
use PDO;

class GroupeDao
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

    public function getAllGroupe(): array
    {
        $req = $this->pdo->prepare("SELECT * FROM groupe");
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $key => $groupe) {
            $result[$key] = (new Groupe)
                ->setId_group($groupe["id_group"])
                ->setNom($groupe["nom"])
                ->setId_user($groupe["id_user"]);
        }

        return $result;
    }
}
