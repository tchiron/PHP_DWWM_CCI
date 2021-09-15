<?php
$title = "Edition d'un commentaire";
include TEMPLATES . DIRECTORY_SEPARATOR . 'header.php';

if (!empty($error_messages)) : ?>
    <div>
        <ul>
            <?php foreach ($error_messages as $msg) : ?>
                <li><?= $msg ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="edit_commentaire_controller.php?article=<?= $commentaire->getIdArticle() ?>&amp;id=<?= $commentaire->getIdCommentaire() ?>" method="post">
    <textarea name="contenu" id="contenu" cols="30" rows="10"><?= $commentaire->getContenu() ?></textarea>
    <input type="submit" value="Envoyer">
</form>

<?php include TEMPLATES . DIRECTORY_SEPARATOR . 'footer.php'; ?>