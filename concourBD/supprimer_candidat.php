<?php
include 'config.php';
include 'header.php';
$pdo = connexionDB();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Supprimer les entrées correspondantes dans Resultat
    $stmt = $pdo->prepare('DELETE FROM Resultat WHERE idCand = ?');
    $stmt->execute([$id]);

    // Supprimer le candidat
    $stmt = $pdo->prepare('DELETE FROM Candidat WHERE idCand = ?');
    $stmt->execute([$id]);

    header('Location: candidats.php');
} else {
    echo "ID de candidat non spécifié.";
}
?>
