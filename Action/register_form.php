<?php
require_once '../Classes/tools/type/Text.php';
require_once '../Classes/tools/type/Password.php';

use tools\type\Text;
use tools\type\Password;

// Champs d'inscription
$idField = new Text('id', required: true);
$passwordField = new Password('mot_de_passe', required: true);
?>

<form method="POST" action="../Classes/Utilisateur/handle_register.php">
    <?= $idField->render(); ?><br>
    <?= $passwordField->render(); ?><br>
    <button type="submit">S'inscrire</button>
</form>
