<?php
include 'config.php';

$id = $_GET['id'];

$pdo = connexionDB();
$stmt = $pdo->prepare('DELETE FROM Epreuve WHERE idEpr = ?');
$stmt->execute([$id]);

echo "<script type='text/javascript'>
        alert('Suppression réussie');
        window.location.href = 'epreuves.php';
      </script>";
?>
