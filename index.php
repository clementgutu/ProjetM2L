<?php 
    session_start();
    include_once("./src/data.inc.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet</title>
    <link rel="stylesheet" href="css/menu_index.css">
    <link rel="stylesheet" href="css/formulaire_index.css">
</head>
<body>
<!--Menu-->
    <header>
        <a class="btn_intra" href="index.php"><img src="asset/intra.png" alt=""> Intranet </a>
        <nav>                 
            <a class="btn_connect" href=""><img src="asset/door.png" alt=""> Connexion</a>            
        </nav>
    </header>
<!--formulaire-->
    <main>
        <h1>Connexion</h1>
    <fieldset class="fs_connection">
        <p>Pour vous connecter à l'intranet, entrez votre identifiant et mot de passe.</p>
        <form method="post">
            <label for="email">Email :</label>
            <input type="email" name="email" placeholder="Votre mail" id="email" >
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" placeholder="Mot de passe" id="password" >
            <input type="submit" value="CONNEXION">
        </form>
    </fieldset>
    <?php
    include_once "./src/connexion.php";
    ?>
    </main>
</body>
</html>












