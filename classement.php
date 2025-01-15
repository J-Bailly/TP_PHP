<?php
require('Data/bd.php');

try {
    // Requête pour récupérer les utilisateurs triés par score décroissant
    $stmt = $pdo->query("SELECT id, score FROM Utilisateur ORDER BY score DESC");
    $classement = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des Scores</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <nav class="navigation">
            <a href="index.php">Accueil</a>
            <a href="quiz.php">Faire le Quiz</a>
            <a href="classement.php">Classement</a>
        </nav>
    </header>
    <main>
        <h1>Classement des Utilisateurs</h1>
        <table class="classement-table">
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Nom d'utilisateur</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($classement) > 0): ?>
                    <?php foreach ($classement as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['score']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Aucun utilisateur dans le classement.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2025 Quiz App | Tous droits réservés</p>
    </footer>
</body>
</html>
