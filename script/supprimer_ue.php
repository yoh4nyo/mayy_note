<?php
include '../include/connexionBD.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

        // Supprimer l'ue
        $stmt = $connexion->prepare('DELETE FROM ue WHERE Numero_UE = ?');
        $stmt->execute([$id]);

        header('Location: ../html/admin_gestionue.php');
} else {
    echo "ID de l'UE non spécifié.";
}
?>