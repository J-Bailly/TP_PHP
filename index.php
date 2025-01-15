<?php
session_start(); // Démarre la session pour vérifier l'état de connexion de l'utilisateur
$is_logged_in = isset($_SESSION['user_id']); // Vérifie si l'utilisateur est connecté
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur le Quiz</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <header>
        <nav class="navigation">
            <a href="index.php">Accueil</a>
            <?php if ($is_logged_in): ?>
                <a href="quiz.php">Faire le Quiz</a> <!-- Lien vers le quiz uniquement si l'utilisateur est connecté -->
            <?php else: ?>
                <a href="login.php">Se connecter</a> <!-- Si l'utilisateur n'est pas connecté, afficher le lien pour se connecter -->
            <?php endif; ?>
            <a href="score.php">Score</a>
        </nav>
        <div>
            <?php if (!$is_logged_in): ?>
                <a href="Template/signup.php"><button class="sign-up-button">S'inscrire</button></a>
                <a href="Template/login.php"><button class="sign-up-button">Se connecter</button></a>
            <?php else: ?>
                <span>Bienvenue, <?= $_SESSION['user_name'] ?> !</span> <!-- Si l'utilisateur est connecté, afficher son nom -->
            <?php endif; ?>
        </div>
    </header>
    <div class="main-banner">
        <h1>Bienvenue sur notre site de quiz !</h1>
        <p>Testez vos connaissances à travers différents quiz.</p>

        <!-- Si l'utilisateur est connecté, afficher un bouton pour commencer le quiz -->
        <?php if ($is_logged_in): ?>
            <a href="quiz.php"><button class="quiz-button">Commencer le Quiz</button></a>
        <?php else: ?>
            <!-- Si l'utilisateur n'est pas connecté, afficher un message pour l'inviter à se connecter -->
            <p>Pour participer au quiz, veuillez <a href="login.php">vous connecter</a>.</p>
        <?php endif; ?>
    </div>
    <div class="footer">
        <p>&copy; 2025 Site de Quiz | Tous droits réservés | Contactez-nous pour plus d'informations.</p>
    </div>
</body>

</html>
