<?php
include '../include/connexionBD.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

        // Supprimer l'enseignant
        $stmt = $connexion->prepare('DELETE FROM enseignants WHERE Numero_Ens = ?');
        $stmt->execute([$id]);

        header('Location: ../html/admin_gestionenseignant.php');
} else {
    echo "ID de l'enseignant non spécifié.";
}
?>