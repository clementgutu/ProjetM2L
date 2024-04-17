<?php

include_once("src/session.php");

$search = $_GET['search'] ?? "";
$choice = $_GET['choice'] ?? "";

// $mysqli = new mysqli('127.0.0.1', $accountId, $password, $database, $port);
// if ($mysqli->connect_error) {
//     die('Connect Error (' . $mysqli->connect_errno . ') '
//             . $mysqli->connect_error);
// }

include_once("src/data.inc.php");

$data = ["name"=>'bob', "age"=>65];
$dataStringified = json_encode($data);
echo "<script>console.log($dataStringified)</script>";

$users = [];

switch ($choice) {
    case 'age':
        // $users = $mysqli->query("SELECT * FROM user WHERE age LIKE '%$name%'")->fetch_all(MYSQLI_ASSOC);

        //Faille SQL injection
        // $users = $dataBase->query("SELECT * FROM user WHERE age=$search")->fetchAll();

        function getIntervalDates($age){
            $date1 = date('Y') - $age - 1 . '/' . date('m/d');
            $date2 = date('Y') - $age . '/' . date('m/d');

            return [$date1, $date2];
        }

        $intervalDates = getIntervalDates($search);
        $date1 = $intervalDates[0];
        $date2 = $intervalDates[1];

        // $request = $dataBase->prepare("SELECT * FROM user WHERE birthday BETWEEN ? AND ?");
        $request = $dataBase->prepare("SELECT * FROM collaborateurs WHERE date_de_naissance BETWEEN ? AND ?");
        $request->execute([$date1, $date2]);
        $users = $request->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        var_dump ($users);
        echo "</pre>";

        break;
    
    case 'name' :
    default:
        $request = $dataBase->prepare("SELECT * FROM collaborateurs WHERE prenom LIKE ?"); 
        $request->execute(["%$search%"]);
        $users = $request->fetchAll();
        break;
        
}

// $log = json_encode($users);
// echo "<script>console.log('aaaaa')</script>";
// echo "<script>console.log($log)</script>";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet</title>
    <link rel="stylesheet" href="css/menu_login.css">
    <link rel="stylesheet" href="css/liste_collab.css">    
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
        <h1>Liste des collaborateurs</h1>
        <form method="get">
            <input type="text" name="search" placeholder="Recherche ..." class="search-input" id="search" required/>
            <label for="">Rechercher par :</label>
            <select name="choice" class="custom-select">
                <option value="name">Nom</option>
                <option value="age">Age</option>                
            </select>
            <label for="">Catégorie:</label>
            <select name="choice" class="custom-select">
                <option value="Starter">Starter</option>
                <option value="Regular">Regular</option>
                <option value="Prenium">Prenium</option>                 
            </select>
           
            <button type="submit">Rechercher</button>
            
        </form>
        
        <section class="say_hello">
        <?php foreach ($users as $user) : 
                $firstName = $user['prenom'];
                $lastName = $user['nom'];
                $city= $user['ville'];
                $country= $user['pays'];
                $mail = $user['email'];
                $number= $user['telephone'];
                $photo= $user['url_de_la_photo'];
                $birthday = new DateTime($user['date_de_naissance']);
                $now = new DateTime();
                $interval = $now->diff($birthday);
                $user['age'] = $interval->y; 
                $user['anniversaire'] = $birthday->format('d M'); 
                
            ?>
                <figure>
                    <img class="img_collab_1" src="asset/collaborateur.png" alt="collaborateurs" />                 
                    <figcaption class="boite">
                        <div class="cont_technique"><p class="pole_technique">Marketing</p></div>                   
                        <p class="nom_collab"><strong><?= "$firstName $lastName" ?></strong><span class="age"><?='(' . $user['age'] .'ans)'?></span></p>
                        <p class="lieu"><?= "$city" .', ' . "$country" ?></p>
                        <ul class="listes">
                            <li><a href=""> <?= "$mail" ?> </a></li>
                            <li><a href=""> <?= "$number" ?></a></li>
                            <li>Anniversaire: <?= $user['anniversaire']?></li>
                        </ul>
                    </figcaption>
                </figure>
            <?php endforeach; ?>

                 
        </section>        
    </main>
</body>
</html>