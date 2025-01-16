<?php require("Template/main.php"); ?>
<?php
try {
    // Inclure le fichier de configuration pour la connexion PDO
    require('Data/bd.php'); // Assurez-vous que ce fichier configure correctement la connexion PDO

    // Vérifier si le type de question a été sélectionné
    $type_question_id = $_POST['type_question'] ?? null;
    if (!$type_question_id) {
        die("Aucun type de question sélectionné.");
    }

    // Récupérer le nom du type de question choisi
    $stmt = $pdo->prepare("SELECT type_question FROM TypeQuestion WHERE id = :type_question_id");
    $stmt->execute(['type_question_id' => $type_question_id]);
    $type_question = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le type de question n'existe pas
    if (!$type_question) {
        die("Le type de question sélectionné n'existe pas.");
    }

    // Récupérer les questions pour le type sélectionné
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
    <title>Quiz - <?= htmlspecialchars($type_question['type_question']) ?></title>
</head>
<body>
    <h1>Quiz sur <?= htmlspecialchars($type_question['type_question']) ?></h1>

    <!-- Afficher les questions du type sélectionné -->
    <form action="result.php" method="POST">
        <?php if (!empty($questions)): ?>
            <?php foreach ($questions as $question): ?>
                <p>
                    <strong><?= htmlspecialchars($question['question']) ?></strong><br>
                    
                    <!-- Pour les questions de type "Écriture" -->
                    <?php if ($question['type_question_id'] == 1): ?>
                        <label for="answer_<?= $question['id'] ?>">Votre réponse :</label>
                        <input type="text" name="answers[<?= $question['id'] ?>]" id="answer_<?= $question['id'] ?>" required><br>
                    <?php else: ?>
                        <!-- Afficher les options de réponse pour les autres types (QCM, Vrai/Faux) -->
                        <?php if (!empty($question['reponse_1'])): ?>
                            <input type="radio" name="answers[<?= $question['id'] ?>]" value="<?= $question['reponse_1'] ?>" required> <?= htmlspecialchars($question['reponse_1']) ?><br>
                        <?php endif; ?>
                        <?php if (!empty($question['reponse_2'])): ?>
                            <input type="radio" name="answers[<?= $question['id'] ?>]" value="<?= $question['reponse_2'] ?>"> <?= htmlspecialchars($question['reponse_2']) ?><br>
                        <?php endif; ?>
                        <?php if (!empty($question['reponse_3'])): ?>
                            <input type="radio" name="answers[<?= $question['id'] ?>]" value="<?= $question['reponse_3'] ?>"> <?= htmlspecialchars($question['reponse_3']) ?><br>
                        <?php endif; ?>
                    <?php endif; ?>
                </p>
            <?php endforeach; ?>
        <?php else: ?>
            <p><?= $message ?? '' ?></p>
        <?php endif; ?>

        <!-- Formulaire pour le nom de l'utilisateur -->
        <?php if (!empty($questions)): ?>
            <button type="submit">Soumettre</button>
        <?php endif; ?>
    </form>
</body>
</html>
