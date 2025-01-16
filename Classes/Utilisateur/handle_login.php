<?php
session_start(); // Démarre la session

require_once '../Provider/DataLoader.php';

// Connexion à la base de données SQLite
$pdo = new PDO('sqlite:../../Data/bd.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // Recherche de l'utilisateur par son identifiant
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // Connexion réussie : on stocke l'identifiant dans la session
        $_SESSION['user_id'] = $id;
        echo "Connexion réussie. Bienvenue, $id !";
        header("Location: ../../index.php");
        exit;
    } else {
        echo "Identifiant ou mot de passe incorrect.";
    }
}
?>
