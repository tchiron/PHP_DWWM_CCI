<?php
$title = "Editer un article";
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
<form action="edit_article_controller.php?id=<?= $article["id_article"] ?>" method="post">
    <input type="text" name="title" value="<?= $article["title"] ?>">
    <textarea name="description" id="description" cols="30" rows="10">
    <?= $article["description"] ?>
    </textarea>
    <input type="submit" value="Envoyer">
</form>
<?php include 'footer.php'; ?>