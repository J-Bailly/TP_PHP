<?php
try {
    // Chemin du fichier SQLite
    $db_path = __DIR__ . '/quiz.sqlite'; // Le fichier de la base de données sera créé ici.

    // Connexion à la base de données SQLite
    $conn = new PDO("sqlite:$db_path");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Créer la table "questions"
    $conn->exec("
        CREATE TABLE IF NOT EXISTS questions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            question_text TEXT NOT NULL,
            option_a TEXT NOT NULL,
            option_b TEXT NOT NULL,
            option_c TEXT NOT NULL,
            option_d TEXT NOT NULL,
            correct_option CHAR(1) NOT NULL
        );
    ");

    // Créer la table "scores"
    $conn->exec("
        CREATE TABLE IF NOT EXISTS scores (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_name TEXT NOT NULL,
            score INTEGER NOT NULL
        );
    ");

    // Insérer des questions dans la table "questions"
    $conn->exec("
        INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_option) VALUES
        ('Quelle est la capitale de la France ?', 'Paris', 'Berlin', 'Rome', 'Madrid', 'A'),
        ('Combien font 5 + 3 ?', '6', '7', '8', '9', 'C'),
        ('Quel langage est utilisé pour le développement web ?', 'Python', 'PHP', 'Java', 'C++', 'B')
    ");

    echo "Base de données et tables créées avec succès, et les questions ont été ajoutées.";
} catch (PDOException $e) {
    die("Erreur lors de la configuration : " . $e->getMessage());
}
?>
