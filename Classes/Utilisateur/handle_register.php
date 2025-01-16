<?php
session_start(); // Démarre la session

require_once '../Provider/DataLoader.php';

// Connexion à la base de données SQLite
$pdo = new PDO('sqlite:../../Data/bd.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id']);
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);

    // Vérifie que l'identifiant n'est pas déjà utilisé
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE id = ?");
    $stmt->execute([$id]);
    if ($stmt->fetch()) {
        echo "Erreur : cet identifiant est déjà utilisé.";
        exit;
    }

    // Insertion de l'utilisateur dans la table Utilisateur
    $stmt = $pdo->prepare("INSERT INTO Utilisateur (id, mot_de_passe) VALUES (?, ?)");
    if ($stmt->execute([$id, $mot_de_passe])) {
        // Inscription réussie : on connecte l'utilisateur automatiquement
        $_SESSION['user_id'] = $id;
        echo "Inscription réussie. Bienvenue, $id !";
        header("Location: ../../index.php");
        exit;
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>
