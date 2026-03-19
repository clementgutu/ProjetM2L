<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Détruire complètement la session
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

header('Location: /ProjetM2L/pages/form_connexion.php?deconnecte=1');
exit;
