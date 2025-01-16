<?php require("Template/main.php"); ?>
<?php
//session_start(); // Démarre la session pour vérifier l'état de connexion de l'utilisateur
//$is_logged_in = isset($_SESSION['user_id']); // Vérifie si l'utilisateur est connecté
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
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
</body>

</html>
