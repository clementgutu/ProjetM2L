<?php
require_once '../src/admin_check.php';
require_once __DIR__ . '/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/listes.php');
    exit;
}

// Vérification CSRF
if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
    header('Location: ../pages/listes.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

// Empêcher la suppression de son propre compte
if (!$id || $id === (int)($_SESSION['user']['id'] ?? 0)) {
    header('Location: ../pages/listes.php');
    exit;
}

try {
    // Suppression de l'avatar en premier (clé étrangère)
    $stmtAvatar = $database->prepare("DELETE FROM avatars WHERE collaborateur_id = :id");
    $stmtAvatar->execute([':id' => $id]);

    $stmt = $database->prepare("DELETE FROM collaborateurs WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header('Location: ../pages/listes.php?success=suppression');
    exit;

} catch (PDOException $e) {
    header('Location: ../pages/listes.php?error=serveur');
    exit;
}
