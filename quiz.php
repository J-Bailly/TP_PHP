<?php
try {
    $db_path = __DIR__ . '/quiz.sqlite';
    $conn = new PDO("sqlite:$db_path");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les questions depuis la base de données
    $stmt = $conn->query("SELECT * FROM questions");
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h1>Questionnaire</h1>
    <form action="result.php" method="POST">
        <?php foreach ($questions as $question): ?>
            <p>
                <strong><?= htmlspecialchars($question['question_text']) ?></strong><br>
                <input type="radio" name="answers[<?= $question['id'] ?>]" value="A" required> <?= htmlspecialchars($question['option_a']) ?><br>
                <input type="radio" name="answers[<?= $question['id'] ?>]" value="B"> <?= htmlspecialchars($question['option_b']) ?><br>
                <input type="radio" name="answers[<?= $question['id'] ?>]" value="C"> <?= htmlspecialchars($question['option_c']) ?><br>
                <input type="radio" name="answers[<?= $question['id'] ?>]" value="D"> <?= htmlspecialchars($question['option_d']) ?><br>
            </p>
        <?php endforeach; ?>
        <p>
            <label for="user_name">Votre nom :</label>
            <input type="text" name="user_name" id="user_name" required>
        </p>
        <button type="submit">Soumettre</button>
    </form>
</body>
</html>
