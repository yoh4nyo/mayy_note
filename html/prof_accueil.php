<?php 
    session_start();
    include '../include/connexionBD.php';
        if (!isset($_SESSION['Identifiant_Ens']) || empty($_SESSION['Identifiant_Ens'])) {
            header("Location: login.php");
            exit();
} 

$identifiant_ens = $_SESSION['Identifiant_Ens'];
$stmt = $connexion->prepare('SELECT Prenom_Ens, Nom_Ens FROM enseignants WHERE Identifiant_Ens = ?');
$stmt->execute([$identifiant_ens]);
$ens_info = $stmt->fetch(PDO::FETCH_ASSOC);

$nom_ens = $ens_info['Nom_Ens'];
$prenom_ens = $ens_info['Prenom_Ens'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_prof_accueil.css">
    <title>Bienvenue professeur</title>
</head>
<body>
<header>
<?php include '../include/logo.php'?>
</header>

    <h1>BIENVENUE</h1>
    <h3>Bonjour : <?php echo $nom_ens ." ". $prenom_ens; ?></h3>
    
   <table align="center">
    <tr>
        <td>
            <a href="prof_saisir.php" class="button">Gestion</a>
            <a href="prof_consultation.php" class="button">Consulter</a>
        </td>
    </tr>
   </table>

   <?php include '../include/footer.php'?>
   
</body>
</html>