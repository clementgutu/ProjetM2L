<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/database.php';

$erreur_connexion = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Vérification CSRF
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        $erreur_connexion = "Requête invalide. Veuillez actualiser la page et réessayer.";
    } else {
        $email = trim($_POST['email'] ?? '');
        $mdp   = $_POST['motdepasse'] ?? '';

        if (empty($email) || empty($mdp)) {
            $erreur_connexion = "Veuillez remplir tous les champs.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreur_connexion = "Adresse email invalide.";
        } else {
            try {
                $stmt = $database->prepare("SELECT * FROM collaborateurs WHERE email = :email LIMIT 1");
                $stmt->execute([':email' => $email]);
                $user = $stmt->fetch();

                if ($user && password_verify($mdp, $user['motdepasse'])) {
                    session_regenerate_id(true);
                    $_SESSION['user'] = $user;
                    header('Location: acceuil.php');
                    exit;
                } else {
                    $erreur_connexion = "Identifiants incorrects. Veuillez réessayer.";
                }
            } catch (PDOException $e) {
                $erreur_connexion = "Erreur serveur. Veuillez réessayer plus tard.";
            }
        }
    }
}

// Génération du token CSRF (ou renouvellement)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
