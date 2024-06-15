<?php
include '../include/connexionBD.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $stmt = $connexion->prepare('DELETE FROM ressources WHERE Numero_Res = ?');
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            header('Location: ../html/admin_gestionressources.php');
            exit();
        } else {
            throw new Exception("La ressource avec l'ID $id n'existe pas.");
        }
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') {
            echo "<script>alert('Impossible de supprimer cette ressource : elle est utilisée dans une autre table.');
                  window.location.href = '../html/admin_gestionressources.php';</script>";
        } else {
            echo "Erreur PDO : " . $e->getMessage();
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "ID de la ressource non spécifié.";
}
?>
