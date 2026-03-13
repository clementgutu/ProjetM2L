<?php
// Examens mdp hashé : $motdepasse = password_hash("123456", PASSWORD_DEFAULT);
// Inclure le fichier de connexion à la base de données
require_once 'database.php';

// Récupérer les données du formulaire

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $mdp = isset($_POST['motdepasse']) ? $_POST['motdepasse'] : null;

    // Requête uniquement par email
    $stmt = $database->prepare("SELECT * FROM collaborateurs WHERE email = :email");
    $stmt->bindParam(':email', $email);

    try {
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp, $user['motdepasse'])) {
            session_start();
            $_SESSION['user'] = $user;
            header('Location: ./pages/acceuil.php');
            exit;
        } else {
            echo "❌ Identifiants incorrects";
        }
    } catch (PDOException $e) {
        echo "❌ Erreur : " . $e->getMessage();
    }
}
