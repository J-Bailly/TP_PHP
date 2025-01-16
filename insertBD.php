<?php
try {
    // Inclure la configuration de la connexion à la base de données
    require('Data/bd.php'); // Assurez-vous que ce fichier configure correctement votre connexion PDO

    // Supprimer toutes les lignes de la table Questions
    $pdo->exec("DELETE FROM Questions");

    // Préparation des questions avec plusieurs propositions
    $questions = [
        // Questions de type "Écriture" (type_question_id = 1)
        [1, 1, 'Quel est le plus grand pays du monde par superficie ?', 'Russie', 'Canada', 'Chine', 'États-Unis'],
        [1, 1, 'Quel scientifique a développé la théorie de la relativité ?', 'Albert Einstein', 'Isaac Newton', 'Galilée', 'Nikola Tesla'],
        [1, 1, 'Nommez la planète la plus proche du Soleil.', 'Mercure', 'Vénus', 'Terre', 'Mars'],
        [1, 1, 'Quelle est la valeur de Pi (au moins deux décimales) ?', '3.14', '3.00', '3.16', '3.141'],
        [1, 1, 'Donnez le nom de l\'auteur de "Les Misérables".', 'Victor Hugo', 'Émile Zola', 'Molière', 'Albert Camus'],

        // Questions de type "Vrai/Faux" (type_question_id = 2)
        [2, 2, 'Les dauphins sont des mammifères.', 'vrai', 'vrai', 'faux', null],
        [2, 2, 'Le Mont Everest est la montagne la plus haute du monde.', 'vrai', 'vrai', 'faux', null],
        [2, 2, 'La Grande Muraille de Chine est visible depuis l\'espace.', 'faux', 'vrai', 'faux', null],
        [2, 2, 'La lumière voyage plus vite que le son.', 'vrai', 'vrai', 'faux', null],
        [2, 2, 'Le Sahara est le plus grand désert de sable du monde.', 'vrai', 'vrai', 'faux', null],

        // Questions de type "QCM" (type_question_id = 3)
        [3, 3, 'Quelle est la plus grande planète du système solaire ?', 'Jupiter', 'Mars', 'Terre', 'Jupiter'],
        [3, 3, 'Quelle est la couleur du sang dans le corps humain ?', 'Rouge', 'Rouge', 'Bleu', 'Vert'],
        [3, 3, 'Combien d\'os compte le corps humain adulte ?', '206', '206', '180', '220'],
        [3, 3, 'Quelle est la capitale de l\'Espagne ?', 'Madrid', 'Madrid', 'Barcelone', 'Séville'],
        [3, 3, 'Quel est le symbole chimique de l\'or ?', 'Au', 'O', 'Ag', 'Au'],
    ];

    // Requête SQL préparée pour insérer les questions
    $sql = "INSERT INTO Questions (quiz_id, type_question_id, question, reponse_correcte, reponse_1, reponse_2, reponse_3) 
            VALUES (:quiz_id, :type_question_id, :question, :reponse_correcte, :reponse_1, :reponse_2, :reponse_3)";
    $stmt = $pdo->prepare($sql);

    // Boucler sur les questions et insérer chaque ligne dans la base de données
    foreach ($questions as $question) {
        $stmt->execute([
            'quiz_id' => $question[0],
            'type_question_id' => $question[1],
            'question' => $question[2],
            'reponse_correcte' => $question[3],
            'reponse_1' => $question[4],
            'reponse_2' => $question[5],
            'reponse_3' => $question[6],
        ]);
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
