<?php require("Template/main.php"); ?>
<?php
require 'config.php';
include 'nav.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Vous devez être connecté pour accéder aux quiz.";
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT Quiz.id, Quiz.titre, Categories.nom AS categorie 
                     FROM Quiz
                     LEFT JOIN Categories ON Quiz.categorie_id = Categories.id");
$quizList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Quiz - <?= htmlspecialchars($type_question['type_question']) ?></title>
</head>
<body>
    
   

    <h2>Liste des Quiz</h2>
    <ul>
        <?php foreach ($quizList as $quiz): ?>
            <li>
                <a href="take_quiz.php?quiz_id=<?= $quiz['id'] ?>">
                    <?= htmlspecialchars($quiz['titre']) ?> (Catégorie : <?= htmlspecialchars($quiz['categorie']) ?>)
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
