<?php
require_once '../src/database.php';
require_once '../src/all_collaborators.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet de l'entreprise</title>
    <link rel="stylesheet" href="../css/menu_connecter.css">
    <link rel="stylesheet" href="../css/liste.css">
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
                <li class="nav-item"><a href="#" class="nav-link">Listes</a></li>
                <li class="nav-item profil">
                    <a href="./profil.php" class="nav-link">
                        <img src="/asset/profil.png" alt="Profil" class="logo">
                    </a>
                </li>
                <li class="nav-item"><a href="../index.php" class="nav-link">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <!----------Option de recherche---------->

    <h1 class="titre">Liste des collaborateurs</h1>
    
    <div class="recherche">
        <input type="search" id="recherche-input" placeholder="Rechercher...">
        <span>Rechercher par :</span>
        <select id="categorie-select">
            <option value="aucun">Aucun</option>
            <option value="nom">Nom</option>
            <option value="prenom">Prénom</option>
            <option value="service">Service</option>
            <option value="email">Email</option>
        </select>

        <span>Catégories des salariés :</span>
        <select id="categorie-salarie-select">
            <option value="aucun">Aucun</option>
            <option value="cadre">Cadre</option>
            <option value="technicien">Technicien</option>
            <option value="ouvrier">Ouvrier</option>
            <option value="employe">Employé</option>
            <option value="stagiaire">Stagiaire</option>
        </select>
        <button id="recherche-btn">Rechercher</button>
    </div>
    <!----------Carte collaborateur---------->

    <div class="liste-collaborateurs">
    <?php foreach ($collaborateurs as $collaborateur): ?>
        <?php
            $prenom = $collaborateur['prenom'];
            $nom = $collaborateur['nom'];
            $email = $collaborateur['email'];
            $telephone = $collaborateur['telephone'];
            $pays = $collaborateur['pays'];
            $ville = $collaborateur['ville'];
            $photo = $collaborateur['photo'];
            $date_de_naissance = $collaborateur['date_de_naissance'];
            $profession = $collaborateur['profession'];

            // Calcul de l'âge
            $naissance = new DateTime($date_de_naissance);
            $aujourd_hui = new DateTime();
            $age = $aujourd_hui->diff($naissance)->y;
        ?>
        <div class="carte-collaborateur">
            <img src="../<?= htmlspecialchars($photo) ?>" alt="Photo du collaborateur" class="photo">
            <div class="infos">
                <p class="profession"><?php echo $profession; ?></p>
                <h2 id="nom-collaborateur"><?php echo $prenom . " " . $nom; ?> <span class="age" style="font-size: 12px; color: #ccc; font-style: italic;">(<?php echo $age; ?>)</span></h2>
                <p class="ville"><?php echo $ville; ?>, <?php echo $pays; ?></p>
                <div class="coordonnees">
                    <p><i class="fas fa-envelope"></i> <?php echo $email; ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo $telephone; ?></p>
                    <p><i class="fas fa-birthday-cake"></i> Anniversaire : <?php echo $date_de_naissance; ?></p>
                </div>
            </div>
        </div>
        
    <?php endforeach; ?>

</body>
</html>