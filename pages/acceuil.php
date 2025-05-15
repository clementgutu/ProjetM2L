<?php
require_once '../src/database.php';
require_once '../src/collaborateur.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'acceuil</title>
    <link rel="stylesheet" href="../css/menu_connecter.css">
    <link rel="stylesheet" href="../css/acceuil-style.css">
    <link rel="stylesheet" href="../css/footer.css ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header class="site-header">
        <nav class="main-nav">
            <div class="intranet">
                <a href="#" class="nav-link">
                    <img src="../asset/intra.png" alt="Home" class="logo">
                    Intranet
                </a>
            </div>
            <ul class="nav-list">
                <li class="nav-item"><a href="./listes.php" class="nav-link">Listes</a></li>
                <li class="nav-item profil">
                    <a href="./profil.php" class="nav-link">
                        <img src="/asset/profil.png" alt="Profil" class="logo">
                    </a>
                </li>
                <li class="nav-item"><a href="../index.php" class="nav-link">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <h1 class="titre">Bienvenu sur l'intranet</h1>
    <p class="sous-titre">La plate-forme de l'entreprise qui vous permet de retrouver vos collaborateurs.</p>
    <p>Avez-vous dit bonjour à :</p>

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

    <footer class="site-footer">
        <p class="copyright">&copy;Copyright M2L.</p>
    </footer>
</body>
</html>