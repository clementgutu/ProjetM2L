<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../db/database.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: ../index.php');
    exit;
}

// Vérification CSRF
if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
    header('Location: ../index.php?error=csrf');
    exit;
}

$civilite          = trim($_POST['civilite']          ?? '');
$prenom            = trim($_POST['prenom']            ?? '');
$nom               = trim($_POST['nom']               ?? '');
$email             = trim($_POST['email']             ?? '');
$mdp               = $_POST['motdepasse']             ?? '';
$telephone         = trim($_POST['telephone']         ?? '');
$date_de_naissance = !empty($_POST['date_de_naissance']) ? $_POST['date_de_naissance'] : null;
$pays              = trim($_POST['pays']              ?? '');
$ville             = trim($_POST['ville']             ?? '');
$profession        = trim($_POST['profession']        ?? '');
$role              = 'client'; // Toujours client à l'inscription

// Validation basique
if (empty($prenom) || empty($nom) || empty($email) || empty($mdp) || empty($telephone) || empty($profession)) {
    header('Location: ../index.php?error=champs');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../index.php?error=email');
    exit;
}

if (strlen($mdp) < 8) {
    header('Location: ../index.php?error=mdp');
    exit;
}

$motdepasse = password_hash($mdp, PASSWORD_DEFAULT);

try {
    // Vérification email unique
    $check = $database->prepare("SELECT id FROM collaborateurs WHERE email = :email LIMIT 1");
    $check->execute([':email' => $email]);
    if ($check->fetch()) {
        header('Location: ../index.php?error=email_existe');
        exit;
    }

    $stmt = $database->prepare(
        "INSERT INTO collaborateurs (civilite, prenom, nom, email, motdepasse, telephone, date_de_naissance, pays, ville, profession, role)
         VALUES (:civilite, :prenom, :nom, :email, :motdepasse, :telephone, :date_de_naissance, :pays, :ville, :profession, :role)"
    );
    $stmt->execute([
        ':civilite'          => $civilite,
        ':prenom'            => $prenom,
        ':nom'               => $nom,
        ':email'             => $email,
        ':motdepasse'        => $motdepasse,
        ':telephone'         => $telephone,
        ':date_de_naissance' => $date_de_naissance,
        ':pays'              => $pays,
        ':ville'             => $ville,
        ':profession'        => $profession,
        ':role'              => $role,
    ]);

    // Renouveler le token CSRF après inscription
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    header('Location: ../pages/form_connexion.php?registered=1');
    exit;

} catch (PDOException $e) {
    header('Location: ../index.php?error=serveur');
    exit;
}
