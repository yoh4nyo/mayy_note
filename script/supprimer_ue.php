<?php
include '../include/connexionBD.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $stmt = $connexion->prepare('DELETE FROM ue WHERE Numero_UE = ?');
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            header('Location: ../html/admin_gestionue.php');
            exit();
        } else {
            throw new Exception("L'UE avec l'ID $id n'existe pas.");
        }
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') {
            echo "<script>alert('Impossible de supprimer cette UE : elle est utilisée dans une autre table.');
                  window.location.href = '../html/admin_gestionue.php';</script>";
        } else {
            echo "Erreur PDO : " . $e->getMessage();
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "ID de l'UE non spécifié.";
}
?>
