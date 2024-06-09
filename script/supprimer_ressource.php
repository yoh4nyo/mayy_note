<?php
session_start();
if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroRes = $_POST['numero_res'];

    include '../include/connexionBD.php';

    $sql = "DELETE FROM ressources WHERE Numero_Res = :numeroRes";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':numeroRes', $numeroRes);

    if ($stmt->execute()) {
        echo "La ressource a été supprimée avec succès.";
    } else {
        echo "Erreur : " . $sql . "<br>" . $stmt->errorInfo()[2];
    }

    $connexion = null;
}
?>
