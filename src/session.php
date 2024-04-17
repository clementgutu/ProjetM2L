<?php
session_start(); // Démarrage ou reprise de la session

// Vérifier si la variable de session 'loggedin' est définie et est vraie
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ) {
    $email = $_SESSION['email'];
    echo "Utilisateur est connecté.";
    // Ici, vous pouvez effectuer des opérations supplémentaires pour les utilisateurs connectés
} else {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: index.php");
    exit; // Assurez-vous d'arrêter l'exécution du script après une redirection
    
}

