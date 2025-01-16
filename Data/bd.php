<?php
// Configuration de la connexion SQLite
$dbFile = 'Data/bd.db'; // Chemin vers votre fichier de base de données SQLite

try {
    // Connexion à la base de données SQLite avec PDO
    $pdo = new PDO("sqlite:$dbFile");

    // Configuration des attributs PDO pour gérer les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Test de la connexion en récupérant les tables existantes
    $query = "SELECT name FROM sqlite_master WHERE type='table' ORDER BY name";
    $result = $pdo->query($query);

    if ($result->rowCount() > 0) {
        foreach ($result as $row) {
            echo "- " . htmlspecialchars($row['name']) . "<br>";
        }
    } else {
        echo "";
    }
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    echo "<h2>Erreur de connexion :</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    die();
}
?>
