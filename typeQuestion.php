<?php require("Template/main.php"); ?>

<?php
try {
    // Inclure le fichier de configuration pour la connexion PDO
    require('Data/bd.php'); // Assurez-vous que ce fichier configure correctement la connexion PDO

    // Obtenir les types de question disponibles depuis la table TypeQuestion
    $stmt = $pdo->query("SELECT id, type_question FROM TypeQuestion");
    $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Définir le type de question par défaut ou celui choisi par l'utilisateur
    $type_question_id = $_POST['type_question'] ?? $types[0]['id']; // Par défaut, le premier type de question

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
</head>
<body>
    <h1>Choisir le type de question</h1>

    <!-- Formulaire pour sélectionner le type de question -->
    <form action="quiz.php" method="POST">
        <label for="type_question">Choisissez un type de question :</label>
        <select name="type_question" id="type_question">
            <?php foreach ($types as $type): ?>
                <option value="<?= $type['id'] ?>" <?= $type['id'] == $type_question_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($type['type_question']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Commencer le quiz</button>
    </form>
</body>
</html>
