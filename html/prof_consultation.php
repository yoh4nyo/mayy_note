<?php 
    session_start();
        if (!isset($_SESSION['Identifiant_Ens']) || empty($_SESSION['Identifiant_Ens'])) {
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
    <link rel="stylesheet" href="../css/style_prof_consultation.css">
    <title>Document</title>
</head>
<body>
<header>
<?php include '../include/logo.php'?>
</header>
<?php include '../include/menu_prof.php'?>
    
<?php include '../include/footer.php'?>
</body>
</html>