<?php
require_once '../db/database.php';

$searchTerm       = isset($_GET['recherche'])         ? trim($_GET['recherche'])        : '';
$searchBy         = isset($_GET['categorie'])          ? $_GET['categorie']             : 'aucun';
$categorieSalarie = isset($_GET['categorie_salarie'])  ? $_GET['categorie_salarie']     : 'aucun';
$page             = max(1, (int)($_GET['page'] ?? 1));
$perPage          = 6;

$champsAutorises = ['prenom', 'nom', 'profession', 'email'];

$where  = "WHERE 1=1";
$params = [];

if (!empty($searchTerm) && in_array($searchBy, $champsAutorises)) {
    $where .= " AND c.$searchBy LIKE :recherche";
    $params[':recherche'] = '%' . $searchTerm . '%';
}

if (!empty($categorieSalarie) && $categorieSalarie !== 'aucun') {
    $where .= " AND LOWER(c.profession) = :categorie_salarie";
    $params[':categorie_salarie'] = strtolower($categorieSalarie);
}

// Comptage total pour la pagination
$countStmt = $database->prepare("SELECT COUNT(*) FROM collaborateurs c $where");
$countStmt->execute($params);
$totalCollaborateurs = (int)$countStmt->fetchColumn();
$totalPages = max(1, (int)ceil($totalCollaborateurs / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

// Requête paginée
$sql = "
    SELECT c.id, c.prenom, c.nom, c.email, c.telephone, c.pays, c.ville, c.date_de_naissance, c.profession,
           COALESCE(a.photo, 'asset/avatar_default.svg') AS photo
    FROM collaborateurs c
    LEFT JOIN avatars a ON c.id = a.collaborateur_id
    $where
    ORDER BY c.nom ASC, c.prenom ASC
    LIMIT :limit OFFSET :offset
";

$stmt = $database->prepare($sql);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset,  PDO::PARAM_INT);
$stmt->execute();

$collaborateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
