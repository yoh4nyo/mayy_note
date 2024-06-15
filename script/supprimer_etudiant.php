<?php
include '../include/connexionBD.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    try {
        // Supprimer les entrées correspondantes dans notation
        $stmt = $connexion->prepare('DELETE FROM notation WHERE Numero_Etu = ?');
        $stmt->execute([$id]);

        // Supprimer l'étudiant
        $stmt = $connexion->prepare('DELETE FROM etudiants WHERE Numero_Etu = ?');
        $stmt->execute([$id]);

        header('Location: ../html/admin_gestionetudiants.php');
        exit();
    } catch (Exception $e) {
        echo 'Erreur lors de la suppression : ' . $e->getMessage();
    }
} else {
    echo "ID de l'étudiant non spécifié.";
}
$connexion = null;
?>
