<?php
// Connexion à la base de données quizz.db avec PDO
try {
    $pdo = new PDO('sqlite:quizz.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    die();
}
?>
