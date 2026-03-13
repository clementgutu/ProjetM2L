<?php
require_once './src/database.php';
require_once './src/connexion.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
    <link rel="stylesheet" href="css/menu_formulaire.css">
    <link rel="stylesheet" href="css/formulaire_connexion.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>
    <div class="page-container">
        <header class="site-header">
            <nav class="main-nav">
                <ul class="nav-list">
                    <li class="nav-item"><a href="#" class="nav-link"><img src="./asset/intra.png" alt="Home" class="logo"> Intranet</a></li>
                    <li class="nav-item"><a href="pages/form_inscription.php" class="nav-link">Inscription</a></li>
                </ul>
            </nav>
        </header>

        <main class="main-content">
            <div class="login-container">
                <div class="login-screen">
                    <div class="app-title">
                        <h1 class="title">Connexion</h1>
                    </div>
                    <div class="login-form">
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email" id="login-name" name="email">
                                <label class="form-label" for="login-name"><i class="fas fa-user"></i></label>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Mot de passe" id="login-pass" name="motdepasse">
                                <label class="form-label" for="login-pass"><i class="fas fa-lock"></i></label>
                            </div>
                            <input type="submit" class="btn" value="Login">
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <footer class="site-footer">
            <p class="copyright">©Copyright M2L.</p>
        </footer>
    </div>
</body>
</html>
