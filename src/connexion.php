<?php
// Examens mdp hashé : $motdepasse = password_hash("123456", PASSWORD_DEFAULT);
// Inclure le fichier de connexion à la base de données
require_once 'database.php';

// Récupérer les données du formulaire

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $mdp = isset($_POST['motdepasse']) ? $_POST['motdepasse'] : null;

    // Préparer la requête
    $stmt = $database->prepare("SELECT * FROM collaborateurs WHERE (email = :email) AND (motdepasse = :motdepasse)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':motdepasse', $mdp);

    try { //permet de contrôler les erreurs liées à l'exécution de la requête
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        var_dump($user);

        if ($user) {
            // Si l'utilisateur est trouvé, on le connecte
            session_start();
            $_SESSION['user'] = $user;
            header('Location: ./pages/acceuil.php');
            exit;
        } else {
            // Si l'utilisateur n'est pas trouvé, on affiche un message d'erreur
            echo "❌ Identifiants incorrects";
        }
    } catch (PDOException $e) {
        echo "❌ Erreur lors de la connexion : " . $e->getMessage();
    }
}