<a href="/">Accueil</a>
<?php if (!isset($_SESSION["user"])) : ?>
<a href="/signup">S'enregistrer</a>
<a href="/signin">Se connecter</a>
<?php else : ?>
<a href="/article/new">Ajouter un article</a>
<a href="/user">Liste des utilisateurs</a>
<a href="/user/<?= ($_SESSION["user"])->getId_user(); ?>/show">Afficher mon profil</a>
<a href="/signout">Se déconnecter</a>
<?php endif; ?>