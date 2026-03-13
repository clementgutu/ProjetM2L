<?php 
//connexion à la base de données
try{
    $database = new PDO('mysql:host=localhost;dbname=intranet', 'root', '');
}
catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
}
