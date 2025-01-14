<?php
try {
    // Connexion à la base SQLite
    $db = new PDO('sqlite:database.sqlite');
    
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insérer dans la base de données
    $query = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $query->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPassword,
    ]);

    echo "Inscription réussie ! <a href='login.php'>Connectez-vous</a>";
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        // Code 23000 : violation d'unicité (email déjà utilisé)
        echo "Erreur : cet email est déjà utilisé.";
    } else {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
