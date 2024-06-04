<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_admin_accueil.css">
    <title>Admin Accueil</title>
<?php 
        session_start();
        if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
            // Redirection vers la page de connexion
            header("Location: login.php");
            exit();
        } 
?>

</head>
<body>
<header>
<?php include '../include/logo.php'?>
</header>

    <h1>DASHBOARD</h1>

    <table align="center">
        <tr>
            <td>
                <a href="admin_gestionressources.php" class="button">Gestion des ressources</a>
                <a href="admin_gestionue.php" class="button">Gestion des UE</a>
            </td>
        </tr>

        <tr>
            <td>
                <a href="admin_gestionetudiants.php" class="button">Gestion des Étudiants</a>
                <a href="admin_gestionenseignant.php" class="button">Gestion des Enseignants</a>
            </td>
        </tr>



    </table> 
    <?php include '../include/footer.php'?>
</body>
</html>