<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_dashboard_admin.css">
    <title>Admin Accueil</title>
</head>
<body>
    <header class="header">
        <img src="../img/logo.png" alt="logo" width="120px">
    </header>

    <h1>DASHBOARD</h1>

    <table align="center">
        <tr>
            <td>
                <input type="button" id="gestion_ressource" value="Gestion des ressources">
                <input type="button" id="gestion_ue" value="Gestion des UE"> 
            </td>
        </tr>

        <tr>
            <td>
                <input type="button" id="gestion_etudiants" value="Gestion des Étudiants">
                <input type="button" id="gestion_enseignants" value="Gestion des Enseignants">
            </td>
        </tr>



    </table> 
    

    <?php include 'footer.php'?>
</body>
</html>