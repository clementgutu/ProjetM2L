<?php
session_start();
require_once '../src/database.php';
require_once '../src/filtre_collaborateurs.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet de l'entreprise</title>
    <link rel="stylesheet" href="../css/menu_connecter.css">
    <link rel="stylesheet" href="../css/liste.css">
    <link rel="stylesheet" href="../css/footer.css">

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
    
    <form method="GET" class="recherche">
        <input type="search" name="recherche" placeholder="Rechercher..." value="<?= htmlspecialchars($_GET['recherche'] ?? '') ?>">

        <span>Rechercher par :</span>
        <select name="categorie">
            <option value="aucun" <?= ($_GET['categorie'] ?? '') === 'aucun' ? 'selected' : '' ?>>Aucun</option>
            <option value="nom" <?= ($_GET['categorie'] ?? '') === 'nom' ? 'selected' : '' ?>>Nom</option>
            <option value="prenom" <?= ($_GET['categorie'] ?? '') === 'prenom' ? 'selected' : '' ?>>Prénom</option>
            <option value="profession" <?= ($_GET['categorie'] ?? '') === 'profession' ? 'selected' : '' ?>>Service</option>
            <option value="email" <?= ($_GET['categorie'] ?? '') === 'email' ? 'selected' : '' ?>>Email</option>
        </select>

        <span>Catégories des salariés :</span>
        <select name="categorie_salarie">
            <option value="aucun" <?= ($_GET['categorie_salarie'] ?? '') === 'aucun' ? 'selected' : '' ?>>Aucun</option>
            <option value="cadre" <?= ($_GET['categorie_salarie'] ?? '') === 'cadre' ? 'selected' : '' ?>>Cadre</option>
            <option value="technicien" <?= ($_GET['categorie_salarie'] ?? '') === 'technicien' ? 'selected' : '' ?>>Technicien</option>
            <option value="ouvrier" <?= ($_GET['categorie_salarie'] ?? '') === 'ouvrier' ? 'selected' : '' ?>>Ouvrier</option>
            <option value="employe" <?= ($_GET['categorie_salarie'] ?? '') === 'employe' ? 'selected' : '' ?>>Employé</option>
            <option value="stagiaire" <?= ($_GET['categorie_salarie'] ?? '') === 'stagiaire' ? 'selected' : '' ?>>Stagiaire</option>
        </select>

        <button type="submit">Rechercher</button>
    </form>

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

    </div>

    <footer class="site-footer">
        <p class="copyright">&copy;Copyright M2L.</p>
    </footer>


</body>
</html>