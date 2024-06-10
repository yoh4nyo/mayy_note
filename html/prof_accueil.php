<?php 
    session_start();
        if (!isset($_SESSION['Identifiant_Ens']) || empty($_SESSION['Identifiant_Ens'])) {
            header("Location: login.php");
            exit();
} 
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