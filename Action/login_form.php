<?php
require_once '../Classes/tools/type/Text.php';
require_once '../Classes/tools/type/Password.php';

use tools\type\Text;
use tools\type\Password;

// Champs de connexion
$idField = new Text('id', required: true);
$passwordField = new Password('mot_de_passe', required: true);
?>

<form method="POST" action="../Classes/Utilisateur/handle_login.php">
    <?= $idField->render(); ?><br>
    <?= $passwordField->render(); ?><br>
    <button type="submit">Se connecter</button>
</form>
