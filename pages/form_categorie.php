<?php
session_start();
require_once '../src/database.php';
require_once '../src/categories.php'; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Catégories</title>
    <link rel="stylesheet" href="../css/menu_connecter.css">
    <link rel="stylesheet" href="../css/profil.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>

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
            <li class="nav-item"><a href="./profil.php" class="nav-link"><img src="/asset/profil.png" alt="Profil" class="logo"></a></li>
            <li class="nav-item"><a href="../index.php" class="nav-link">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<form method="POST" id="formulaire-modifier-profil">
    <h2>Ajouter une catégorie</h2>

    <div class="champ-formulaire">
        <label for="nom">Nom de la catégorie :</label>
        <input type="text" id="nom" name="nom" required>
    </div>

    <button type="submit" name="ajouter_categorie" id="bouton-modifier">Ajouter</button>

    <hr>
</form>

<div id="formulaire-modifier-profil">
    <h3>Modifier/Supprimer les catégories existantes</h3>

    <?php foreach ($categories as $cat): ?>
        <form method="POST" class="champ-formulaire">
            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
            <label>Catégorie :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($cat['nom']) ?>" required>
            <button type="submit" name="modifier_categorie">Modifier</button>
            <a href="?supprimer=<?= $cat['id'] ?>" onclick="return confirm('Supprimer cette catégorie ?');">🗑️ Supprimer</a>
        </form>
    <?php endforeach; ?>
</div>

<footer class="site-footer">
    <p class="copyright">&copy;Copyright M2L.</p>
</footer>

</body>
</html>
