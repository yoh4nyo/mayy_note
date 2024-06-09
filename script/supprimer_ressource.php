<?php
include '../include/connexionBD.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

        // Supprimer la ressource
        $stmt = $connexion->prepare('DELETE FROM ressources WHERE Numero_Res = ?');
        $stmt->execute([$id]);

        header('Location: ../html/admin_gestionressources.php');
} else {
    echo "ID de la ressource non spécifié.";
}
?>