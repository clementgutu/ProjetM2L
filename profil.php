<?php 

include_once("src/session.php");
include_once("src/data.inc.php");

$first_name = $_POST['nom'] ?? null ;
$last_name = $_POST['prenom'] ?? null ;
$email = $_POST['email'] ?? null ;
$password1 = $_POST['password1'] ?? null ;
$password2 = $_POST['password2'] ?? null ;
$phone = $_POST['tel'] ?? null ;
$birthday = $_POST['date'] ?? null ;
$city = $_POST['ville'] ?? null ;
$country = $_POST['pays'] ?? null ;

echo "<pre>";
var_dump($_POST);
echo "</pre>";

$user_has_update = isset($first_name) && isset($last_name) && isset($email) && isset($password1) && isset($password2) && isset($phone) && isset($birthday) && isset($city) && isset($country);
$password_are_similar = $password1 === $password2;

if ($user_has_update && $password_are_similar) {
    // Préparer la requête d'UPDATE
    $updateQuery = $dataBase->prepare(
        "UPDATE collaborateurs 
        SET nom = :nom, prenom = :prenom, motdepasse = :password, telephone = :tel, 
            date_de_naissance = :date, ville = :ville, pays = :pays
        WHERE email = :email"
    );

    // Exécuter la requête en liant les valeurs
    $updateQuery->execute([
        ':nom' => $first_name,
        ':prenom' => $last_name,
        ':password' => $password1,
        ':tel' => $phone,
        ':date' => $birthday,
        ':ville' => $city,
        ':pays' => $country,
        ':email' => $email
    ]);

    // Vérifier si l'update a été effectué
    if ($updateQuery->rowCount() > 0) {
        echo "Les informations du collaborateur ont été mises à jour.";
    } else {
        echo "Aucune information n'a été mise à jour.";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet</title>
    <link rel="stylesheet" href="css/menu_login.css">
    <link rel="stylesheet" href="css/formulaire_index.css">
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
<!--formulaire-->
    <main>
        <h1>Modifier mon profil</h1>
    <fieldset class="fs_connection">
        <form method="POST">
            <label for="">Civilité :</label>
            <select name="civilite" id="">
                <option value="M">M.</option>
                <option value="Mme">Mme</option>
                <option value="Mlle">Mlle</option>
            </select>
            <label for="">Catégorie :</label>
            <select name="categorie" id="">
                <option value="client">Client</option>
                <option value="Technique">Technique</option>
                <option value="Marketing">Marketing</option>
            </select>
            <label for="">Nom :</label>
            <input type="text" name="nom" placeholder="Admin" id="nom" required>
            <label for="">Prénom :</label>
            <input type="text" name="prenom" placeholder="User" id="prenom" required>
            <label for="">Email :</label>
            <input type="email" name="email" placeholder="Votre mail" id="email" required>
            <label for="">Mot de passe :</label>
            <input type="password" name="password1" placeholder="(min 8 caractères)" id="password" required>
            <label for="">Confirmation :</label>
            <input type="password" name="password2" placeholder="(min 8 caractères)" id="password" required>
            <label for="">Télephone :</label>
            <input type="tel" name="tel" placeholder="+33" id="tel" required>
            <label for="">Date de naissance :</label>
            <input type="date" name="date" id="date" required>
            <label for="">Ville :</label>
            <input type="text" name="ville" placeholder="City" id="ville" required>
            <label for="">Pays :</label>
            <input type="text" name="pays" placeholder="Country" id="pays" required>
            <input type="submit" value="Modifier">
            <?php if ($user_has_update && $password_are_similar) { ?>
                <p>La modification à été effectuer</p> 
            <?php }?>
            <?php if ($user_has_update && !$password_are_similar) { ?>
                <p>Le mot de passe n'es pas bon</p> 
            <?php }?>
            
        </form>
    </fieldset>
    </main>
</body>
</html>