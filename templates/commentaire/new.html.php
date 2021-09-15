<?php
$title = "Ajout d'un nouveau commentaire";
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

<form action="" method="post">
    <textarea name="contenu" id="contenu" cols="30" rows="10"></textarea>
    <input type="submit" value="Envoyer">
</form>

<?php include TEMPLATES . DIRECTORY_SEPARATOR . 'footer.php'; ?>