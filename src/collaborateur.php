<?php
// Inclusion du fichier de connexion à la BDD
require_once 'database.php';

// Préparation de la requête
$stmt = $database->prepare("
    SELECT c.prenom, c.nom, c.email, c.telephone, c.pays, c.ville, c.date_de_naissance, c.profession, a.photo
    FROM collaborateurs c
    INNER JOIN avatars a ON c.id = a.collaborateur_id
    ORDER BY RAND() LIMIT 1
");
// Exécution de la requête
$stmt->execute();

// Récupération des résultats
$collaborateur = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérification si un collaborateur a été trouvé
if ($collaborateur) {
    $prenom = $collaborateur['prenom'];
    $nom = $collaborateur['nom'];
    $email = $collaborateur['email'];
    $telephone = $collaborateur['telephone'];
    $pays = $collaborateur['pays'];
    $ville = $collaborateur['ville'];
    $photo = $collaborateur['photo'];
    $date_de_naissance = $collaborateur['date_de_naissance'];
    $profession = $collaborateur['profession'];

    //Calcul de l'age
    $naissance = new DateTime($date_de_naissance);
    $aujourd_hui = new DateTime();
    $age = $aujourd_hui->diff($naissance);
    $age = $age->y;

} else {
    $prenom = "Utilisateur Introuvable";
    $nom = "";
    $email = "";
    $telephone = "";
    $pays = "";
    $ville = "";
    $photo = "";
    $age = "";
    
}
