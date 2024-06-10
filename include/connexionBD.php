<?php
$serveur = "mysql-mayynotes.alwaysdata.net";
$utilisateur = "mayynotes";
$motDePasse = "wxcvbn0309"; 
$baseDeDonnees = "mayynotes_mayy";

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "La connexion a échoué : " . $e->getMessage();
}
?>
