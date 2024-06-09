<?php
session_start();
if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroUE = $_POST['numero_ue'];

    include '../include/connexionBD.php'; 

    $sql = "DELETE FROM ue WHERE Numero_UE = :numeroUE";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':numeroUE', $numeroUE);

    if ($stmt->execute()) {
        echo "L'UE a été supprimée avec succès.";
    } else {
        echo "Erreur : " . $sql . "<br>" . $stmt->errorInfo()[2];
    }

    $connexion = null;
}
?>
