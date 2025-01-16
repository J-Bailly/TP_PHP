<?php require("Template/main.php"); ?>
<?php
require 'config.php';
include 'nav.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudonyme = $_POST['pseudonyme'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    // Vérifier si le pseudonyme existe déjà
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Utilisateur WHERE pseudonyme = ?");
    $stmt->execute([$pseudonyme]);
    if ($stmt->fetchColumn() > 0) {
        echo "<p style='color: red'>Ce pseudonyme est déjà utilisé. Veuillez en choisir un autre.</p>";
    } else {
        // Insérer le nouvel utilisateur
        $stmt = $pdo->prepare("INSERT INTO Utilisateur (pseudonyme, mot_de_passe) VALUES (?, ?)");
        if ($stmt->execute([$pseudonyme, $mot_de_passe])) {
            echo "<p style='color: green'>Inscription réussie ! Redirection vers la page de connexion...</p>";
            header("Refresh: 0; url=login.php"); // Redirection vers la page de connexion après 2 secondes
            exit;
        } else {
            echo "<p style='color: red'>Erreur lors de l'inscription. Veuillez réessayer.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    
    <h2>Inscription</h2>
    <form method="post">
        <label>Pseudonyme: <input type="text" name="pseudonyme" required></label><br>
        <label>Mot de passe: <input type="password" name="mot_de_passe" required></label><br>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
