<?php

require_once "Pdo/pdo_dao.php";

function add_commentaire(array $commentaire): void
{
    $dbh = getPDO();
    $req = $dbh->prepare("INSERT INTO commentaire (contenu, id_article) VALUES (:contenu, :id_article)");
    $req->execute([
        ":id_article" => $commentaire["article_id"],
        ":contenu" => $commentaire["contenu"]
    ]);
}

function get_commentaire_by_article_id(int $article_id): array
{
    $dbh = getPDO();
    $req = $dbh->prepare("SELECT * 
                        FROM commentaire 
                        WHERE id_article = :article_id 
                        ORDER BY date_creation DESC
    ");
    $req->execute([":article_id" => $article_id]);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}
