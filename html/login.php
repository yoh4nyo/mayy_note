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
session_start();
include '../include/connexionBD.php'; // Inclure le fichier de connexion à la base de données

if($_SERVER["REQUEST_METHOD"] == "POST"){

$mdp = $_POST['mdp'];
$identifiant = $_POST['identifiant'];

try {
    $stmt = $connexion->prepare("SELECT * FROM enseignants WHERE Identifiant_Ens = :identifiant AND Mdp_Ens = :mdp AND role = 'enseignant'");
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION["Identifiant_Ens"] = $identifiant;
        $_SESSION["Mdp_Ens"] = $mdp;
        $_SESSION['role'] = 'enseignant';
        header("Location: prof_accueil.php");
        exit;
    }   

    $stmt = $connexion->prepare("SELECT * FROM etudiants WHERE Identifiant_Etu = :identifiant AND Mdp_Etu = :mdp");
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION["Identifiant_Etu"] = $identifiant;
        $_SESSION["Mdp_etu"] = $mdp;
        header("Location: etudiant_accueil.php");
        exit;
    }   

    $stmt = $connexion->prepare("SELECT * FROM enseignants WHERE Identifiant_Ens = :identifiant AND Mdp_Ens = :mdp AND role = 'administrateur'");
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION["Identifiant_admin"] = $identifiant;
        $_SESSION["Mdp_admin"] = $mdp;
        $_SESSION['role'] = 'administrateur';
        header("Location: admin_accueil.php");
        exit;
    }

    echo "<script>alert('Les identifiants saisis sont incorrects. Veuillez réessayer.');</script>";

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$connexion = null;
}
?>

</body>
</html>
