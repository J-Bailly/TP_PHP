<?php
try {
    $db_path = __DIR__ . '/quiz.sqlite';
    $conn = new PDO("sqlite:$db_path");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $answers = $_POST['answers']; // Réponses de l'utilisateur
        $user_name = $_POST['user_name']; // Nom de l'utilisateur
        $score = 0;

        foreach ($answers as $question_id => $user_answer) {
            // Récupérer la bonne réponse
            $stmt = $conn->prepare("SELECT correct_option FROM questions WHERE id = :question_id");
            $stmt->bindValue(':question_id', $question_id, PDO::PARAM_INT);
            $stmt->execute();

            $correct_option = $stmt->fetchColumn();

            // Vérifier si la réponse est correcte
            if ($user_answer === $correct_option) {
                $score++;
            }
        }

        // Enregistrer le score dans la table "scores"
        $stmt = $conn->prepare("INSERT INTO scores (user_name, score) VALUES (:user_name, :score)");
        $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->bindValue(':score', $score, PDO::PARAM_INT);
        $stmt->execute();

        // Afficher le score
        echo "<h1>Merci, $user_name ! Votre score est : $score</h1>";
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
