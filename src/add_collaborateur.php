<?php
require_once '../src/admin_check.php';
require_once __DIR__ . '/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/listes.php');
    exit;
}

// Vérification CSRF
if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
    header('Location: ../pages/form_add_collaborateur.php?error=csrf');
    exit;
}

$civilite          = trim($_POST['civilite']          ?? '');
$prenom            = trim($_POST['prenom']            ?? '');
$nom               = trim($_POST['nom']               ?? '');
$email             = trim($_POST['email']             ?? '');
$mdp               = $_POST['motdepasse']             ?? '';
$telephone         = trim($_POST['telephone']         ?? '');
$profession        = trim($_POST['profession']        ?? '');
$date_de_naissance = !empty($_POST['date_de_naissance']) ? $_POST['date_de_naissance'] : null;
$ville             = trim($_POST['ville']             ?? '');
$pays              = trim($_POST['pays']              ?? '');

// Validation
if (empty($prenom) || empty($nom) || empty($email) || empty($mdp) || empty($telephone) || empty($profession)) {
    header('Location: ../pages/form_add_collaborateur.php?error=champs');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../pages/form_add_collaborateur.php?error=email');
    exit;
}

if (strlen($mdp) < 8) {
    header('Location: ../pages/form_add_collaborateur.php?error=mdp');
    exit;
}

try {
    // Email unique
    $check = $database->prepare("SELECT id FROM collaborateurs WHERE email = :email LIMIT 1");
    $check->execute([':email' => $email]);
    if ($check->fetch()) {
        header('Location: ../pages/form_add_collaborateur.php?error=email_existe');
        exit;
    }

    $stmt = $database->prepare("
        INSERT INTO collaborateurs (civilite, prenom, nom, email, motdepasse, telephone, profession, date_de_naissance, ville, pays, role)
        VALUES (:civilite, :prenom, :nom, :email, :motdepasse, :telephone, :profession, :date_de_naissance, :ville, :pays, 'client')
    ");
    $stmt->execute([
        ':civilite'          => $civilite,
        ':prenom'            => $prenom,
        ':nom'               => $nom,
        ':email'             => $email,
        ':motdepasse'        => password_hash($mdp, PASSWORD_DEFAULT),
        ':telephone'         => $telephone,
        ':profession'        => $profession,
        ':date_de_naissance' => $date_de_naissance,
        ':ville'             => $ville,
        ':pays'              => $pays,
    ]);

    header('Location: ../pages/listes.php?success=ajout');
    exit;

} catch (PDOException $e) {
    header('Location: ../pages/form_add_collaborateur.php?error=serveur');
    exit;
}
