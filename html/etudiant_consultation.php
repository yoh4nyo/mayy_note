<?php 
session_start();
if (!isset($_SESSION['Identifiant_Etu']) || empty($_SESSION['Identifiant_Etu'])) {
    // Redirection vers la page de connexion
    header("Location: login.php");
    exit();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_etudiant_consultation.css">
    <title>Document</title>
</head>
<body>
<header>
<?php include '../include/logo.php'?>
</header>
<?php include '../include/menu_etudiant.php'?>

<?php include '../include/footer.php'?> 
</body>
</html>