<?php
// Inclusion du fichier de connexion à la BDD
require_once 'database.php';

// Préparation de la requête
$stmt = $database->prepare("
    SELECT c.prenom, c.nom, c.email, c.telephone, c.pays, c.ville, c.date_de_naissance, c.profession, a.photo
    FROM collaborateurs c
    INNER JOIN avatars a ON c.id = a.collaborateur_id
");
// Exécution de la requête
$stmt->execute();

// Récupération des résultats
$collaborateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$liste_collaborateurs = [];

if ($collaborateurs) {
    foreach ($collaborateurs as $collaborateur) {
        $prenom = $collaborateur['prenom'];
        $nom = $collaborateur['nom'];
        $email = $collaborateur['email'];
        $telephone = $collaborateur['telephone'];
        $pays = $collaborateur['pays'];
        $ville = $collaborateur['ville'];
        $photo = $collaborateur['photo'];
        $date_de_naissance = $collaborateur['date_de_naissance'];
        $profession = $collaborateur['profession'];

        // Calcul de l'âge
        $naissance = new DateTime($date_de_naissance);
        $aujourd_hui = new DateTime();
        $age = $aujourd_hui->diff($naissance)->y;

    }
    
} else {
    echo "Aucun collaborateur trouvé.";
}