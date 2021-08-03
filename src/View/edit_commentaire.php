<?php
$title = "Edition d'un commentaire";
include 'header.php';

if (!empty($error_messages)) : ?>
    <div>
        <ul>
            <?php foreach ($error_messages as $msg) : ?>
                <li><?= $msg ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="edit_commentaire_controller.php?article=<?= $commentaire["id_article"] ?>&amp;id=<?= $commentaire["id_commentaire"] ?>" method="post">
    <textarea name="contenu" id="contenu" cols="30" rows="10"><?= $commentaire["contenu"] ?></textarea>
    <input type="submit" value="Envoyer">
</form>

<?php include 'footer.php'; ?>