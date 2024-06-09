<?php
session_start();
if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroEtu = $_POST['numero_etu'];

    include '../include/connexionBD.php';

    $sql = "DELETE FROM etudiants WHERE Numero_Etu = :numeroEtu";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':numeroEtu', $numeroEtu);

    if ($stmt->execute()) {
        echo "L'étudiant a été supprimé avec succès.";
    } else {
        echo "Erreur : " . $sql . "<br>" . $stmt->errorInfo()[2];
    }

    $connexion = null;
}
?>
