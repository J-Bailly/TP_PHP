<?php
try {
    require('Data/bd.php'); // Connexion à la base de données via $pdo

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $answers = $_POST['answers']; // Réponses de l'utilisateur
        $user_name = $_POST['user_name']; // Nom de l'utilisateur
        $score = 0;

        foreach ($answers as $question_id => $user_answer) {
            // Récupérer la bonne réponse et le type de question
            $stmt = $pdo->prepare("SELECT type_question_id, reponse_correcte FROM questions WHERE id = :question_id");
            $stmt->bindValue(':question_id', $question_id, PDO::PARAM_INT);
            $stmt->execute();
            $question = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification de la réponse
            if ($question['type_question_id'] == 1) { // Écriture
                // Comparer les réponses en ignorant la casse
                if (strtolower(trim($user_answer)) == strtolower($question['reponse_correcte'])) {
                    $score++;
                }
            } else { // Pour les autres types (QCM, Vrai/Faux)
                if (strtolower(trim($user_answer)) == strtolower($question['reponse_correcte'])) {
                    $score++;
                }
            }
        }

        // Vérifier si l'utilisateur existe déjà dans la table Utilisateur
        $stmt = $pdo->prepare("SELECT score FROM Utilisateur WHERE id = :user_name");
        $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Si l'utilisateur existe, mettre à jour le score
            $new_score = $user['score'] + $score;  // Ajouter au score existant
            $update_stmt = $pdo->prepare("UPDATE Utilisateur SET score = :score WHERE id = :user_name");
            $update_stmt->bindValue(':score', $new_score, PDO::PARAM_INT);
            $update_stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $update_stmt->execute();
        } else {
            // Si l'utilisateur n'existe pas, l'ajouter avec son score
            // L'ID de l'utilisateur est maintenant son nom (texte), donc pas d'incrémentation ici
            $insert_stmt = $pdo->prepare("INSERT INTO Utilisateur (id, mot_de_passe, score) VALUES (:user_name, :password, :score)");
            $insert_stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $insert_stmt->bindValue(':password', 'defaultpassword', PDO::PARAM_STR); // Mot de passe par défaut, à personnaliser si nécessaire
            $insert_stmt->bindValue(':score', $score, PDO::PARAM_INT);
            $insert_stmt->execute();
        }

        // Afficher le score
        echo "<h1>Merci, $user_name ! Votre score est : $score</h1>";
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
