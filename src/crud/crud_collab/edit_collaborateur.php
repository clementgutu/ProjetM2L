<?php
require_once '../../admin_check.php';
require_once __DIR__ . '/../../database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /ProjetM2L/pages/listes.php');
    exit;
}

// Vérification CSRF
if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
    header('Location: /ProjetM2L/pages/listes.php');
    exit;
}

$id         = (int)($_POST['id'] ?? 0);
$civilite   = trim($_POST['civilite']          ?? '');
$prenom     = trim($_POST['prenom']            ?? '');
$nom        = trim($_POST['nom']               ?? '');
$email      = trim($_POST['email']             ?? '');
$telephone  = trim($_POST['telephone']         ?? '');
$profession = trim($_POST['profession']        ?? '');
$date_de_naissance = !empty($_POST['date_de_naissance']) ? $_POST['date_de_naissance'] : null;
$ville      = trim($_POST['ville']             ?? '');
$pays       = trim($_POST['pays']              ?? '');

if (!$id || empty($prenom) || empty($nom) || empty($email) || empty($telephone) || empty($profession)) {
    header("Location: form_edit_collaborateur.php?id=$id&error=champs");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: form_edit_collaborateur.php?id=$id&error=email");
    exit;
}

try {
    // Email unique sauf pour lui-même
    $check = $database->prepare("SELECT id FROM collaborateurs WHERE email = :email AND id != :id LIMIT 1");
    $check->execute([':email' => $email, ':id' => $id]);
    if ($check->fetch()) {
        header("Location: form_edit_collaborateur.php?id=$id&error=email_existe");
        exit;
    }

    $stmt = $database->prepare("
        UPDATE collaborateurs
        SET civilite = :civilite, prenom = :prenom, nom = :nom, email = :email,
            telephone = :telephone, profession = :profession,
            date_de_naissance = :date_de_naissance, ville = :ville, pays = :pays
        WHERE id = :id
    ");
    $stmt->execute([
        ':civilite'          => $civilite,
        ':prenom'            => $prenom,
        ':nom'               => $nom,
        ':email'             => $email,
        ':telephone'         => $telephone,
        ':profession'        => $profession,
        ':date_de_naissance' => $date_de_naissance,
        ':ville'             => $ville,
        ':pays'              => $pays,
        ':id'                => $id,
    ]);

    header("Location: form_edit_collaborateur.php?id=$id&success=1");
    exit;

} catch (PDOException $e) {
    header("Location: form_edit_collaborateur.php?id=$id&error=serveur");
    exit;
}
