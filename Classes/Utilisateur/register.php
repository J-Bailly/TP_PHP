<?php
// register.php

ob_start();
?>

<h1>Inscription</h1>
<form action="process_register.php" method="post">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required><br>
    
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required><br>
    
    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br>
    
    <button type="submit">S'inscrire</button>
</form>

<p>Déjà inscrit ? <a href="login.php">Connectez-vous</a></p>

<?php
$content = ob_get_clean(); // Capture le contenu généré

$template = new Template("Template");
$template->setLayout("main");
$template->setContent($content);
?>
