<?php
session_start();
if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroEns = $_POST['numero_ens'];

    include '../include/connexionBD.php';

    $sql = "DELETE FROM enseignants WHERE Numero_Ens = :numeroEns";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':numeroEns', $numeroEns);

    if ($stmt->execute()) {
        echo "L'enseignant a été supprimé avec succès.";
    } else {
        echo "Erreur : " . $sql . "<br>" . $stmt->errorInfo()[2];
    }

    $connexion = null;
}
?>
