<?php
// Guard admin — à inclure sur les pages réservées aux admins
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pas connecté → page de connexion
if (empty($_SESSION['user']) || !is_array($_SESSION['user'])) {
    header('Location: ../pages/form_connexion.php');
    exit;
}

// Connecté mais pas admin → page d'accueil
if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../pages/acceuil.php');
    exit;
}
