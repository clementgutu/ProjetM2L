<?php
// Guard d'authentification — à inclure en haut de chaque page protégée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user'])) {
    header('Location: ../pages/connexion.php');
    exit;
}
