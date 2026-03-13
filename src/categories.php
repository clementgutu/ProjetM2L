<?php
// Inclusion du fichier de connexion à la BDD
require_once 'database.php';

//2) Ajout d'une catégorie
if (isset($_POST['ajouter_categorie']) && !empty($_POST['nom'])) {
    $nom = $_POST['nom'];
    $stmt = $database->prepare("INSERT INTO categories (nom) VALUES (?)");
    $stmt->execute([$nom]);
}

//2) Modification d'une catégorie
if (isset($_POST['modifier_categorie']) && !empty($_POST['nom']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $stmt = $database->prepare("UPDATE categories SET nom = ? WHERE id = ?");
    $stmt->execute([$nom, $id]);
}


//3) Suppression d'une catégorie
if (isset($_GET['supprimer'])) {
    $stmt = $database->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$_GET['supprimer']]);
}


// Récupération des catégories
$stmt = $database->prepare("SELECT * FROM categories ORDER BY nom ASC");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
