<?php
session_start();
if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroUE = $_POST['numero_ue'];

    $serveur = "localhost";
    $utilisateur = "root";
    $motDePasse = "";
    $baseDeDonnees = "mayynote";
    $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

    if ($connexion->connect_error) {
        die("La connexion a échoué : " . $connexion->connect_error);
    }

    $sql = "DELETE FROM ue WHERE Numero_UE = '$numeroUE'";

    if ($connexion->query($sql) === TRUE) {
        echo "L'UE a été supprimé avec succès.";
    } else {
        echo "Erreur : " . $sql . "<br>" . $connexion->error;
    }

    $connexion->close();
}
?>