<?php
$title = sprintf("Affiche l'article %d", $article->getId_article());
include 'header.php';
?>
<article>
    <h1><?= trim(filter_var($article->getTitle(), FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?></h1>
    <p><?= nl2br(trim(filter_var($article->getDescription(), FILTER_SANITIZE_FULL_SPECIAL_CHARS))) ?></p>
    <a href="/article/<?= $article->getId_article() ?>/edit">Editer l'article</a>
    <a href="/article/<?= $article->getId_article() ?>/delete">Supprimer l'article</a>
    <a href="/commentaire/<?= $article->getId_article() ?>/new">Ajouter un commentaire</a>
</article>
<?php if (!empty($commentaires)) : ?>
    <div>
        <?php foreach ($commentaires as $commentaire) : ?>
            <div><span><?= $commentaire->getDateCreation() ?></span>
            <a href="/commentaire/<?= $article->getId_article() ?>/<?= $commentaire->getIdCommentaire() ?>/edit">Editer le commentaire</a>
            <a href="/commentaire/<?= $article->getId_article() ?>/<?= $commentaire->GetIdCommentaire() ?>/delete">Supprimer le commentaire</a>
                <p><?= $commentaire->getContenu() ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>