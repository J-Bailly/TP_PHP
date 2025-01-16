<?php
session_start(); // Pour gérer l'état de connexion

function renderNav() {
    if (isset($_SESSION['user_id'])) {
        // Utilisateur connecté
        $pseudonyme = htmlspecialchars($_SESSION['pseudonyme']);
        $score = isset($_SESSION['score']) ? $_SESSION['score'] : 0; // Récupération du score depuis la session
        echo "
        <nav>
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
            <a href='quiz.php'>Quizz</a> |
            <a href='classement.php'>Classement</a> |
            <a href='login.php'>Connexion</a> |
            <a href='register.php'>Inscription</a>
        </nav>
        ";
    }
}
?>
