<?php 
// Vérifier si les données 'mail' ou 'psw' ont été soumises.
if (isset($_POST["email"]) && isset($_POST["password"])){
    // requete preparé qui renvois le mail de la base de données
    try {
        $stmt = $dataBase->prepare("SELECT email, motdepasse FROM collaborateurs WHERE email = :email LIMIT 1");
        // Exécuter la requête en liant le paramètre email avec la valeur entrée par l'utilisateur.
        $stmt->execute(array(':email' => $_POST["email"]));
        // Récupérer la ligne correspondante de la bdd.
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Si un utilisateur est trouvé avec ce mail.
        if ($result) {
            // Vérifiez le mot de passe.
            if ($_POST["password"] === $result['motdepasse']) {
                // Si le mot de passe est correct, redirigez l'utilisateur vers sa page de profil.
                // (Ici, vous définiriez probablement des variables de session, comme indiqué précédemment.)
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $result['email'];               
              

                header("Location: login.php");
                exit;
            }
            else {           
                echo "<p class=\"warning\">Erreur de mot de passe.</p>";
            }
        }
        else {
            echo "<p class=\"warning\">Aucun utilisateur enregistré avec cet email.</p>";
        }
    }
    catch (Exception $e) {
        die($e->getMessage());
    }
} 
