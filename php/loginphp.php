<?php

$serveur = "localhost";
$utilisateur = "root";
$motDePasse = ""; 
$baseDeDonnees = "mayynote";

$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}

$mdp = $_POST['mdp'];
$identifiant = $_POST['identifiant'];

$sql = "SELECT * FROM enseignants WHERE Identifiant_Ens = '$identifiant' AND Mdp_Ens = '$mdp'AND role = 'enseignant'";
$resultat = $connexion->query($sql);

if ($resultat->num_rows > 0) {
    header("Location: accueil_prof.php");
    exit();
}

$sql = "SELECT * FROM etudiants WHERE Identifiant_Etu = '$identifiant' AND Mdp_Etu = '$mdp'";
$resultat = $connexion->query($sql);

if ($resultat->num_rows > 0) {
    header("Location: page_eleve.php");
    exit();
}

$sql = "SELECT * FROM enseignants WHERE Identifiant_Ens = '$identifiant' AND Mdp_Ens = '$mdp' AND role = 'administrateur'";
$resultat = $connexion->query($sql);

if ($resultat->num_rows > 0) {
    header("Location: dashboard_admin.php");
    exit();
}

echo "Nom d'utilisateur ou mot de passe incorrect.";

$connexion->close();
?>