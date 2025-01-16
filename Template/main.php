<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz de Culture Général</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <header>
    <?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        // Utilisateur connecté
        $pseudonyme = htmlspecialchars($_SESSION['pseudonyme']);
        $score = isset($_SESSION['score']) ? $_SESSION['score'] : 0; // Récupération du score depuis la session
        echo "
        <nav>
            <a href='index.php'>Accueil</a> |
            <a href='quiz.php'>Quizz</a> |
            <a href='classement.php'>Classement</a> |
            <span>Bonjour, $pseudonyme (Score : $score)</span> |
            <a href='logout.php'>Déconnexion</a>
        </nav>
        ";
    } else {
        // Utilisateur non connecté
        echo "
        <nav>
            <a href='index.php'>Accueil</a> |
            <a href='quiz.php'>Quizz</a> |
            <a href='classement.php'>Classement</a> |
            <a href='login.php'>Connexion</a> |
            <a href='register.php'>Inscription</a>
        </nav>
        ";
    }
    ?>
    
    </header>
    <div class="footer">
        <p>&copy; 2025 Grand Quiz Culture Générale | Tous droits réservés | Contactez-nous pour plus d'informations.</p>
    </div>
</body>

</html>

