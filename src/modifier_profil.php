<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db/database.php';

$userId = $_SESSION['user']['id'] ?? null;
if (!$userId) {
    echo "❌ Utilisateur non connecté.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Données modifiables par le collaborateur
    $civilite   = trim($_POST['civilite'] ?? '');
    $prenom     = trim($_POST['prenom'] ?? '');
    $nom        = trim($_POST['nom'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $telephone  = trim($_POST['telephone'] ?? '');
    $ville      = trim($_POST['ville'] ?? '');
    $pays       = trim($_POST['pays'] ?? '');

    $ancien_mdp = $_POST['ancien_mdp'] ?? null;
    $nouveau_mdp = $_POST['nouveau_mdp'] ?? null;

    try {
        // 1. Mise à jour des infos de base
        $stmt = $database->prepare("
            UPDATE collaborateurs 
            SET civilite = :civilite, prenom = :prenom, nom = :nom, email = :email, telephone = :telephone, ville = :ville, pays = :pays
            WHERE id = :id
        ");
        $stmt->bindParam(':civilite', $civilite);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':pays', $pays);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Met à jour la session
        $_SESSION['user']['civilite'] = $civilite;
        $_SESSION['user']['prenom'] = $prenom;
        $_SESSION['user']['nom'] = $nom;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['telephone'] = $telephone;
        $_SESSION['user']['ville'] = $ville;
        $_SESSION['user']['pays'] = $pays;

        // 2. Gestion du mot de passe (si demandé)
        if (!empty($ancien_mdp) && !empty($nouveau_mdp)) {
            $stmtPwd = $database->prepare("SELECT motdepasse FROM collaborateurs WHERE id = :id");
            $stmtPwd->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmtPwd->execute();
            $result = $stmtPwd->fetch(PDO::FETCH_ASSOC);

            if ($result && password_verify($ancien_mdp, $result['motdepasse'])) {
                $nouveau_mdp_hash = password_hash($nouveau_mdp, PASSWORD_DEFAULT);

                $stmtUpdatePwd = $database->prepare("UPDATE collaborateurs SET motdepasse = :mdp WHERE id = :id");
                $stmtUpdatePwd->bindParam(':mdp', $nouveau_mdp_hash);
                $stmtUpdatePwd->bindParam(':id', $userId, PDO::PARAM_INT);
                $stmtUpdatePwd->execute();
            } else {
                echo "❌ Ancien mot de passe incorrect.";
                exit;
            }
        }

        header("Location: ../pages/profil.php?success=1");
        exit;
    } catch (PDOException $e) {
        echo "❌ Erreur : " . $e->getMessage();
    }
}
?>
