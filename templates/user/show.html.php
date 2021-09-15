<?php
$title = ($this->session->getUser()->getId_user() === $user->getId_user()) ? "Mon profil" : sprintf("Le profil de %s", $user->getPseudo());
include TEMPLATES . DIRECTORY_SEPARATOR . 'header.php';
?>

<div><span>Nom : </span><span><?= $user->getNom() ?? 'N/A'; ?></span></div>
<div><span>Prénom : </span><span><?= $user->getPrenom() ?? 'N/A'; ?></span></div>
<div><span>Pseudo : </span><span><?= $user->getPseudo() ?></span></div>
<div><span>Email : </span><span><?= $user->getEmail() ?></span></div>
<div><span>Date de création : </span><span><?= $user->getDate_creation() ?></span></div>
<div><span>Genre : </span><span><?= $user->getGenre() ?? 'N/A'; ?></span></div>
<div><span>Groupe : </span><span><?= $user->getGroup() ?? 'N/A'; ?></span></div>

<a href="/user/<?= $user->getId_user() ?>/edit">Modifier le profil</a>

<?php include TEMPLATES . DIRECTORY_SEPARATOR . 'footer.php'; ?>