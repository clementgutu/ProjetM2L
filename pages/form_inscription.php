<?php

require_once '../src/database.php';
require_once '../src/modifier_profil.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet de l'entreprise</title>
    <link rel="stylesheet" href="../css/menu_formulaire.css ">
    <link rel="stylesheet" href="../css/profil.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
    <!----------Menu---------->

    <header class="site-header">
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="#" class="nav-link"><img src="../asset/intra.png" alt="Home" class="logo"> Intranet</a></li>
                <li class="nav-item"><a href="../index.php" class="nav-link">Connexion</a></li>
            </ul>
        </nav>
    </header>

    <form action="../src/inscription.php" method="POST" id="formulaire-modifier-profil">
        <h2>Inscription</h2>

        <div class="champ-formulaire">
            <label for="civilite">Civilité :</label>
            <select id="civilite" name="civilite" required>
                <option value="M."> M.</option>
                <option value="Mme"> Mme</option>
                <option value="Autre"> Autre</option>
            </select>
        </div>

        <div class="champ-formulaire">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="" required>
        </div>

        <div class="champ-formulaire">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="" required>
        </div>

        <div class="champ-formulaire">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="" required>
        </div>

        <div class="champ-formulaire">
            <label for="login-pass"> mot de passe :</label>
            <input type="password" id="login-pass" name="motdepasse">
        </div>

        <div class="champ-formulaire">
            <label for="telephone">Téléphone :</label>
            <input type="text" id="telephone" name="telephone" value="" required>
        </div>

        <div class="champ-formulaire">
            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" value="" required>
        </div>

        <div class="champ-formulaire">
            <label for="pays">Pays :</label>
            <input type="text" id="pays" name="pays" value="" required>
        </div>
        
        <button type="submit" id="bouton-modifier">S'inscrire</button>
    </form>

    <footer class="site-footer">
        <p class="copyright">&copy;Copyright M2L.</p>
    </footer>

</body>

</html>