<?php
$title = sprintf("Affiche l'article %d", $article->getId_article());
include 'header.php';
?>
<article>
    <h1><?= trim(filter_var($article->getTitle(), FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?></h1>
    <p><?= nl2br(trim(filter_var($article->getDescription(), FILTER_SANITIZE_FULL_SPECIAL_CHARS))) ?></p>
    <a href="edit_article_controller.php?id=<?= $article->getId_article() ?>">Editer l'article</a>
    <a href="delete_article_controller.php?id=<?= $article->getId_article() ?>">Supprimer l'article</a>
    <a href="add_commentaire_controller.php?id=<?= $article->getId_article() ?>">Ajouter un commentaire</a>
</article>
<?php if (!empty($commentaires)) : ?>
    <div>
        <?php foreach ($commentaires as $commentaire) : ?>
            <div><span><?= $commentaire["date_creation"] ?></span>
            <a href="edit_commentaire_controller.php?article=<?= $article->getId_article() ?>&amp;id=<?= $commentaire["id_commentaire"] ?>">Editer le commentaire</a>
            <a href="delete_commentaire_controller.php?article=<?= $article->getId_article() ?>&amp;id=<?= $commentaire["id_commentaire"] ?>">Supprimer le commentaire</a>
                <p><?= $commentaire["contenu"] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>