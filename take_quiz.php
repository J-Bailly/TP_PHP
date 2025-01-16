<?php require("Template/main.php"); ?>
<?php
require 'config.php';
include 'nav.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Vous devez être connecté pour accéder à ce quiz.";
    header("Location: login.php");
    exit;
}

$quizId = $_GET['quiz_id'];

// Récupérer les questions du quiz
$stmt = $pdo->prepare("SELECT Questions.*, TypeQuestion.type_question 
                       FROM Questions 
                       LEFT JOIN TypeQuestion ON Questions.type_question_id = TypeQuestion.id 
                       WHERE quiz_id = ?");
$stmt->execute([$quizId]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($questions as $question) {
        $userAnswer = $_POST['question_' . $question['id']];
        if ($userAnswer === $question['reponse_correcte']) {
            $score++;
        }
    }

    // Mettre à jour le score dans la base de données
    $stmt = $pdo->prepare("UPDATE Utilisateur SET score = score + ? WHERE id = ?");
    $stmt->execute([$score, $_SESSION['user_id']]);

    // Mettre à jour le score dans la session pour le nav
    $_SESSION['score'] += $score;

    // Message de confirmation et redirection
    echo "<p style='color: green'>Quiz terminé ! Vous avez marqué $score points. Redirection vers la liste des quiz...</p>";
    header("Refresh: 2; url=quiz.php"); // Rediriger vers la page des quiz après 3 secondes
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>
</head>
<body>
    <

    <h2>Quiz</h2>
    <form method="post">
        <?php foreach ($questions as $question): ?>
            <p><?= htmlspecialchars($question['question']) ?></p>
            <?php if ($question['type_question'] === 'qcm'): ?>
                <label><input type="radio" name="question_<?= $question['id'] ?>" value="<?= htmlspecialchars($question['reponse_1']) ?>"> <?= htmlspecialchars($question['reponse_1']) ?></label><br>
                <label><input type="radio" name="question_<?= $question['id'] ?>" value="<?= htmlspecialchars($question['reponse_2']) ?>"> <?= htmlspecialchars($question['reponse_2']) ?></label><br>
                <label><input type="radio" name="question_<?= $question['id'] ?>" value="<?= htmlspecialchars($question['reponse_3']) ?>"> <?= htmlspecialchars($question['reponse_3']) ?></label>
            <?php elseif ($question['type_question'] === 'vrai/faux'): ?>
                <label><input type="radio" name="question_<?= $question['id'] ?>" value="vrai"> Vrai</label><br>
                <label><input type="radio" name="question_<?= $question['id'] ?>" value="faux"> Faux</label>
            <?php elseif ($question['type_question'] === 'ecriture'): ?>
                <input type="text" name="question_<?= $question['id'] ?>">
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit">Soumettre</button>
    </form>
</body>
</html>
