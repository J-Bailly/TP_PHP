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

    // Récupérer les questions pour le type sélectionné, sans afficher la bonne réponse
    $stmt = $pdo->prepare("SELECT id, question, type_question_id, reponse_1, reponse_2, reponse_3, reponse_correcte
                           FROM Questions 
                           WHERE type_question_id = :type_question_id");
    $stmt->execute(['type_question_id' => $type_question_id]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si aucune question n'est trouvée
    if (empty($questions)) {
        $message = "Aucune question trouvée pour ce type.";
    }

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
    <!-- Formulaire pour sélectionner le type de question -->
    <form action="" method="POST">
        <label for="type_question">Choisissez un type de question :</label>
        <select name="type_question" id="type_question" onchange="this.form.submit()">
            <?php foreach ($types as $type): ?>
                <option value="<?= $type['id'] ?>" <?= $type['id'] == $type_question_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($type['type_question']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Afficher les questions du type sélectionné -->
    <form action="result.php" method="POST">
        <?php if (!empty($questions)): ?>
            <?php foreach ($questions as $question): ?>
                <p>
                    <!-- Afficher la question -->
                    <strong><?= htmlspecialchars($question['question']) ?></strong><br>
                    
                    <!-- Pour les questions de type "Écriture" -->
                    <?php if ($question['type_question_id'] == 1): ?>
                        <label for="answer_<?= $question['id'] ?>">Votre réponse :</label>
                        <input type="text" name="answers[<?= $question['id'] ?>]" id="answer_<?= $question['id'] ?>" required><br>
                    <?php else: ?>
                        <!-- Afficher les options de réponse pour les autres types (QCM, Vrai/Faux) -->
                        <?php if (!empty($question['reponse_1'])): ?>
                            <input type="radio" name="answers[<?= $question['id'] ?>]" value="A" required> <?= htmlspecialchars($question['reponse_1']) ?><br>
                        <?php endif; ?>
                        <?php if (!empty($question['reponse_2'])): ?>
                            <input type="radio" name="answers[<?= $question['id'] ?>]" value="B"> <?= htmlspecialchars($question['reponse_2']) ?><br>
                        <?php endif; ?>
                        <?php if (!empty($question['reponse_3'])): ?>
                            <input type="radio" name="answers[<?= $question['id'] ?>]" value="C"> <?= htmlspecialchars($question['reponse_3']) ?><br>
                        <?php endif; ?>
                    <?php endif; ?>
                </p>
            <?php endforeach; ?>
        <?php else: ?>
            <p><?= $message ?? '' ?></p>
        <?php endif; ?>

        <!-- Formulaire pour le nom de l'utilisateur -->
        <?php if (!empty($questions)): ?>
            <p>
                <label for="user_name">Votre nom :</label>
                <input type="text" name="user_name" id="user_name" required>
            </p>
            <button type="submit">Soumettre</button>
        <?php endif; ?>
    </form>
</body>
</html>


