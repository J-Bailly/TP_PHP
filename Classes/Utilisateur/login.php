<?php
// login.php

ob_start(); // Démarre un tampon de sortie
?>

<h1>Connexion</h1>
<form action="process_login.php" method="post">
    <label for="numEtu">Numéro É :</label>
    <input type="email" id="email" name="email" required><br>
    
    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br>
    
    <button type="submit">Se connecter</button>
</form>

<p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>

<?php
$content = ob_get_clean(); // Capture le contenu généré
include 'template.php'; // Inclut le template principal
?>
