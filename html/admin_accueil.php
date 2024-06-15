<?php
session_start();
include '../include/connexionBD.php';

if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
}

$identifiant_admin = $_SESSION['Identifiant_admin'];
$stmt = $connexion->prepare('SELECT Prenom_Ens, Nom_Ens FROM enseignants WHERE Identifiant_Ens = ?');
$stmt->execute([$identifiant_admin]);
$admin_info = $stmt->fetch(PDO::FETCH_ASSOC);

$nom_admin = $admin_info['Nom_Ens'];
$prenom_admin = $admin_info['Prenom_Ens'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_admin_accueil.css">
    <title>Admin Accueil</title>
</head>
<body>
<header>
    <?php include '../include/logo.php'?>
</header>

<h1>DASHBOARD</h1>
<h3>Bonjour : <?php echo $nom_admin ." ". $prenom_admin; ?></h3>

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
