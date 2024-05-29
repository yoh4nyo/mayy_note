<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_login.css">
    <title>Document</title>
</head>
<body>
    <img src="../img/logo.png" alt="logo">
    <h1>SE CONNECTER</h1> <br>
 

    <form action="../php/loginphp.php" method="POST">
        <tr>
            <td><input name="identifiant" type="text" id="identifiant" placeholder="Identifiant ou Email" required></td>
        </tr><br>
        <tr>
            <td><input name="mdp" type="password" id="mdp" placeholder="Mot de passe" required></td>
        </tr><br>
        <td><input type="submit" value="Connexion" id="Connexion" /></td>




    </form>
    <?php include 'footer.php'?>
</body>
</html>