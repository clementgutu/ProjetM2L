<?php   
try{
    $dataBase = new PDO('mysql:host=localhost;dbname=intranet', 'root', '');
}
catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
}

