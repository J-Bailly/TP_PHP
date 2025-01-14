<?php
session_start();

try {
    // Connexion à la base SQLite
    $db = new PDO('sqlite:database.sqlite');
    
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Rechercher l'utilisateur par email
    $query = $db->prepare("SELECT * FROM users WHERE email = :email");
    $query->execute([':email' => $email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Connexion réussie
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
        ];
        header('Location: dashboard.php'); // Redirige vers une page sécurisée
        exit;
    } else {
        echo "Email ou mot de passe incorrect.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
