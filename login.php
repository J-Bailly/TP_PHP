<?php
require 'config.php';
include 'nav.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudonyme = $_POST['pseudonyme'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE pseudonyme = ?");
    $stmt->execute([$pseudonyme]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['pseudonyme'] = $user['pseudonyme'];
        $_SESSION['score'] = $user['score']; // Charger le score pour le nav

        echo "<p style='color: green'>Connexion réussie ! Redirection vers la liste des quiz...</p>";
        header("Refresh: 0; url=quiz.php"); // Redirection après 2 secondes
        exit;
    } else {
        echo "<p style='color: red'>Pseudonyme ou mot de passe incorrect.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <?php renderNav(); ?>
    <h2>Connexion</h2>
    <form method="post">
        <label>Pseudonyme: <input type="text" name="pseudonyme" required></label><br>
        <label>Mot de passe: <input type="password" name="mot_de_passe" required></label><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
