<?php 
    include_once("src/session.php");
    include_once("src/data.inc.php");

    $users = [];
    $request = $dataBase->query("SELECT * FROM collaborateurs");
    $users = $request->fetchAll(PDO::FETCH_ASSOC);

    $user = null; // Initialisation de $user à null
    if (!empty($users)) { // Vérifiez que $users n'est pas vide avant d'utiliser array_rand
        $randomIndex = array_rand($users);
        $user = $users[$randomIndex];

        $birthday = new DateTime($user['date_de_naissance']);
        $now = new DateTime();
        $interval = $now->diff($birthday);
        $user['age'] = $interval->y; 
        $user['anniversaire'] = $birthday->format('d M'); 
    } else {
        // Gérer le cas où aucun utilisateur n'est trouvé
        // Vous pourriez vouloir afficher un message ou faire une autre action
        echo "Aucun collaborateur trouvé.";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/menu_login.css">
    <link rel="stylesheet" href="css/carte_collab_login.css">
</head>
<body>
<!--Menu-->
    <header>
        <a class="btn_intra" href="login.php"><img src="asset/intra.png" alt=""> Intranet </a>
        <nav>
            <ul>
                <li><a class="btn_listes" href="liste.php"> Listes</a></li>
                <li><a class="profil_img" href="profil.php"><img src="asset/profil.png" alt=""></a></li>
                <li><a class="btn_connect" href="src/logout.php"><img src="asset/door.png" alt=""> Déconnexion</a></li>            
            </ul>                        
        </nav>
    </header>
<!--Carte Collaborateur-->
    <main>
        <h1>Bienvenue sur l'intranet <?= "$email"?></h1>
        <p>La plate-forme de l'entreprise qui vous permet de retrouver tous vos collaborateurs.</p>
        <section class="say_hello">

            <p class="p_hello">Avez-vous dit bonjour à : </p>
            <figure>
                <img class="img_collab_1" src="asset/collaborateur.png" alt="collaborateurs" />               
                <figcaption class="boite">
                    <div class="cont_technique"><p class="pole_technique">Technique</p></div>                   
                    <p class="nom_collab"><strong><?= $user['prenom'] . " " . $user['nom'] ?></strong><span class="age"><?='(' . $user['age'] .'ans)'?></span></p>
                    <p class="lieu"><?= $user['ville'] .", ". $user['pays'] ?></p>
                    <ul class="listes">
                        <li><a href=""> <?= $user['email'] ?> </a></li>
                        <li><a href=""> <?= $user['telephone'] ?></a></li>
                        <li>Anniversaire: <?= $user['anniversaire']?></li>
                    </ul>
                </figcaption>
            </figure>
            <div>
                <a href="login.php"class="button_user">DIRE BONJOUR À QUELQU'UN D'AUTRE</a>
            </div>           
        </section>        
    </main>
</body>
</html>