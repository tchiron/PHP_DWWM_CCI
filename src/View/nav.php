<a href="display_articles_controller.php">Accueil</a>
<?php if (!isset($_SESSION["user"])) : ?>
<a href="signup_controller.php">S'enregistrer</a>
<a href="signin_controller.php">Se connecter</a>
<?php else : ?>
<a href="add_article_controller.php">Ajouter un article</a>
<a href="show_users_controller.php">Liste des utilisateurs</a>
<a href="signout_controller.php">Se déconnecter</a>
<?php endif; ?>