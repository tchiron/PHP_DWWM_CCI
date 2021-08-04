<?php
$title = "Liste des utilisateurs";
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

<?php
if (empty($listUsers)) :
    echo "Rien à afficher";
else :
?>
    <table>
        <thead>
            <tr>
                <th>L'id de l'utilisateur</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Pseudonyme</th>
                <th>Email</th>
                <th>Date de création</th>
                <th>Genre</th>
                <th>Nom du groupe</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $user = current($listUsers);
            do {
            ?>
                <!-- liste d'utilisateur -->
                <tr>
                    <td><?= $user->getId_user() ?></td>
                    <td><?= $user->getNom() ?></td>
                    <td><?= $user->getPrenom() ?></td>
                    <td><?= $user->getPseudo() ?></td>
                    <td><?= $user->getEmail() ?></td>
                    <td><?= $user->getDate_creation() ?></td>
                    <td><?= $user->getGenre() ?></td>
                    <td><?= $user->getGroup() ?></td>
                </tr>
            <?php
            } while ($user = next($listUsers));
            ?>
        </tbody>
    </table>
<?php
endif;

include 'footer.php';
?>