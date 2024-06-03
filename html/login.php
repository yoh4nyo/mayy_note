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
 

    <form action="login.php" method="POST">
<table>
        <tr>
            <td><input name="identifiant" type="text" id="identifiant" placeholder="Identifiant ou Email" required></td>
        </tr><br>
        <tr>
            <td><input name="mdp" type="password" id="mdp" placeholder="Mot de passe" required></td>
        </tr><br>
        <td><input type="submit" value="Connexion" id="Connexion" /></td>
</table>
    </form>
    <?php include '../include/footer.php'?>
<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

session_start();

$serveur = "localhost";
$utilisateur = "root";
$motDePasse = ""; 
$baseDeDonnees = "mayynote";

$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}

$mdp = $_POST['mdp'];
$identifiant = $_POST['identifiant'];

$sql = "SELECT * FROM enseignants WHERE Identifiant_Ens = '$identifiant' AND Mdp_Ens = '$mdp'AND role = 'enseignant'";
$resultat = $connexion->query($sql);

if ($resultat->num_rows > 0) {
        $_SESSION["Identifiant_Ens"] = $identifiant;
        $_SESSION["Mdp_Ens"] = $mdp;
        $_SESSION['role'] = 'enseignant';
    header("Location: prof_accueil.php");
    exit;
}   


$sql = "SELECT * FROM etudiants WHERE Identifiant_Etu = '$identifiant' AND Mdp_Etu = '$mdp'";
$resultat = $connexion->query($sql);

if ($resultat->num_rows > 0) {
        $_SESSION["Identifiant_Etu"] = $identifiant;
        $_SESSION["Mdp_etu"] = $mdp;
    header("Location: etudiant_accueil.php");
    exit;
}   


$sql = "SELECT * FROM enseignants WHERE Identifiant_Ens = '$identifiant' AND Mdp_Ens = '$mdp' AND role = 'administrateur'";
$resultat = $connexion->query($sql);

if ($resultat->num_rows > 0) {
        $_SESSION["Identifiant_admin"] = $identifiant;
        $_SESSION["Mdp_admin"] = $mdp;
        $_SESSION['role'] = 'administrateur';
    header("Location: admin_accueil.php");
    exit;
}

echo "<script>alert('Les identifiants saisis sont incorrects. Veuillez réessayer.');</script>";

$connexion->close();
}
?>

</body>
</html>