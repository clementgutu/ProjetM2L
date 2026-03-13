<?php
// Inclure le fichier de connexion à la base de données
require_once 'database.php';
// Récupérer les données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $civilite = isset($_POST['civilite']) ? $_POST['civilite'] : null;
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : null;
    $nom = isset($_POST['nom']) ? $_POST['nom'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $mdp = isset($_POST['motdepasse']) ? $_POST['motdepasse'] : null;
    $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : null;
    $date_de_naissance = isset($_POST['date_de_naissance']) ? $_POST['date_de_naissance'] : null;
    $pays = isset($_POST['pays']) ? $_POST['pays'] : null;
    $ville = isset($_POST['ville']) ? $_POST['ville'] : null;

    // Hasher le mot de passe
    $motdepasse = password_hash($mdp, PASSWORD_DEFAULT);

    // Requête d'insertion
    $stmt = $database->prepare("INSERT INTO collaborateurs (civilite, prenom, nom, email, motdepasse, telephone, date_de_naissance, pays, ville) VALUES (:civilite, :prenom, :nom, :email, :motdepasse, :telephone, :date_de_naissance, :pays, :ville)");

    $stmt->bindParam(':civilite', $civilite);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':motdepasse', $motdepasse);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':date_de_naissance', $date_de_naissance);
    $stmt->bindParam(':pays', $pays);
    $stmt->bindParam(':ville', $ville);

    try {
        $stmt->execute();
        echo "Inscription réussie !";
        // Redirection vers la page de connexion
        header('Location: ../index.php');
        exit;

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
