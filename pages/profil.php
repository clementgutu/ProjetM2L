<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet de l'entreprise</title>
    <link rel="stylesheet" href="../css/menu_connecter.css ">
    <link rel="stylesheet" href="../css/profil.css">
</head>
<body>
    <!----------Menu---------->

    <header class="site-header">
        <nav class="main-nav">
            <div class="intranet">
                <a href="./acceuil.php" class="nav-link">
                    <img src="../asset/intra.png" alt="Home" class="logo">
                    Intranet
                </a>
            </div>
            <ul class="nav-list">
                <li class="nav-item"><a href="./listes.php" class="nav-link">Listes</a></li>
                <li class="nav-item profil">
                    <a href="#" class="nav-link">
                        <img src="/asset/profil.png" alt="Profil" class="logo">
                    </a>
                </li>
                <li class="nav-item"><a href="../index.php" class="nav-link">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <form id="formulaire-modifier-profil">
        <h2>Modifier mon profil</h2>
        <div class="champ-formulaire">
            <label for="civilité">Civilité :</label>
            <select id="civilité" name="civilité">
                <option value="homme">Homme</option>
                <option value="femme">Femme</option>
            </select>
        </div>
        <div class="champ-formulaire">
            <label for="categorie">Catégorie :</label>
            <select id="categorie" name="categorie">
                <option value="cadre">Cadre</option>
                <option value="technicien">Technicien</option>
                <option value="ouvrier">Ouvrier</option>
                <option value="employe">Employé</option>
                <option value="stagiaire">Stagiaire</option>
            </select>
        </div>
        <div class="champ-formulaire">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="champ-formulaire">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="champ-formulaire">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="champ-formulaire">
            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" required>
        </div>
        <div class="champ-formulaire">
            <label for="confirmation">Confirmation du mot de passe :</label>
            <input type="password" id="confirmation" name="confirmation" required>
        </div>
        <button type="submit" id="bouton-modifier">Modifier</button>
    </form>