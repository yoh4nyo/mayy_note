<?php
session_start();
if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroEtu = $_POST['numero_etu'];

    $serveur = "localhost";
    $utilisateur = "root";
    $motDePasse = "";
    $baseDeDonnees = "mayynote";
    $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

    if ($connexion->connect_error) {
        die("La connexion a échoué : " . $connexion->connect_error);
    }

    $sql = "DELETE FROM etudiants WHERE Numero_Etu = '$numeroEtu'";

    if ($connexion->query($sql) === TRUE) {
        echo "L'étudiant a été supprimé avec succès.";
    } else {
        echo "Erreur : " . $sql . "<br>" . $connexion->error;
    }

    $connexion->close();
}
?>