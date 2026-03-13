<?php
session_start();
require_once '../src/database.php';
require_once '../src/modifier_profil.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet de l'entreprise</title>
    <link rel="stylesheet" href="../css/menu_connecter.css ">
    <link rel="stylesheet" href="../css/profil.css">
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

    <form action="../src/modifier_profil.php" method="POST" id="formulaire-modifier-profil">
        <h2>Modifier mon profil</h2>

        <div class="champ-formulaire">
            <label for="civilite">Civilité :</label>
            <select id="civilite" name="civilite" required>
                <option value="M." <?= ($_SESSION['user']['civilite'] ?? '') === 'M.' ? 'selected' : '' ?>>M.</option>
                <option value="Mme" <?= ($_SESSION['user']['civilite'] ?? '') === 'Mme' ? 'selected' : '' ?>>Mme</option>
                <option value="Autre" <?= ($_SESSION['user']['civilite'] ?? '') === 'Autre' ? 'selected' : '' ?>>Autre</option>
            </select>
        </div>

        <div class="champ-formulaire">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($_SESSION['user']['prenom']) ?>" required>
        </div>

        <div class="champ-formulaire">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($_SESSION['user']['nom']) ?>" required>
        </div>

        <div class="champ-formulaire">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" required>
        </div>

        <div class="champ-formulaire">
            <label for="telephone">Téléphone :</label>
            <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($_SESSION['user']['telephone']) ?>" required>
        </div>

        <div class="champ-formulaire">
            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($_SESSION['user']['ville']) ?>" required>
        </div>

        <div class="champ-formulaire">
            <label for="pays">Pays :</label>
            <input type="text" id="pays" name="pays" value="<?= htmlspecialchars($_SESSION['user']['pays']) ?>" required>
        </div>

        <hr>
        <h3>Changer le mot de passe (optionnel)</h3>

        <div class="champ-formulaire">
            <label for="ancien_mdp">Ancien mot de passe :</label>
            <input type="password" id="ancien_mdp" name="ancien_mdp">
        </div>

        <div class="champ-formulaire">
            <label for="nouveau_mdp">Nouveau mot de passe :</label>
            <input type="password" id="nouveau_mdp" name="nouveau_mdp">
        </div>

        <button type="submit" id="bouton-modifier">Modifier</button>
    </form>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="message-success">
            ✅ Vos informations ont bien été mises à jour.
        </div>
    <?php endif; ?>


    <footer class="site-footer">
        <p class="copyright">&copy;Copyright M2L.</p>
    </footer>

</body>

</html>