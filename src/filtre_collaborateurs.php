<?php
require_once 'database.php';

// Récupération des paramètres GET avec valeurs par défaut
$searchTerm = isset($_GET['recherche']) ? trim($_GET['recherche']) : '';
$searchBy = isset($_GET['categorie']) ? $_GET['categorie'] : 'aucun';
$categorieSalarie = isset($_GET['categorie_salarie']) ? $_GET['categorie_salarie'] : 'aucun';

// Liste des champs autorisés pour sécuriser la requête
$champsAutorises = ['prenom', 'nom', 'profession', 'email'];

// Base de la requête SQL
$sql = "
    SELECT c.prenom, c.nom, c.email, c.telephone, c.pays, c.ville, c.date_de_naissance, c.profession,
           COALESCE(a.photo, 'asset/avatar_default.svg') AS photo
    FROM collaborateurs c
    LEFT JOIN avatars a ON c.id = a.collaborateur_id
    WHERE 1=1
";

$params = [];

// Ajout du filtre de recherche si valide
if (!empty($searchTerm) && in_array($searchBy, $champsAutorises)) {
    $sql .= " AND c.$searchBy LIKE :recherche";
    $params[':recherche'] = '%' . $searchTerm . '%';
}

// Ajout du filtre par catégorie de salarié
if (!empty($categorieSalarie) && $categorieSalarie !== 'aucun') {
    $sql .= " AND LOWER(c.profession) = :categorie_salarie";
    $params[':categorie_salarie'] = strtolower($categorieSalarie);
}

// Préparation et exécution de la requête
$stmt = $database->prepare($sql);
$stmt->execute($params);

// Résultats
$collaborateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
