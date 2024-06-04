<?php

session_start();
if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
} 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['Numero_Etu'];
    $prenom = $_POST['Prenom_Etu'];
    $nom = $_POST['Nom_Etu'];
    $identifiant = $_POST['Identifiant_Etu'];
    $mdp = $_POST['Mdp_Etu'];
    $cursus = $_POST['Cursus'];
    $annee = $_POST['Annee'];
    $groupe = $_POST['Numero_Grp'];

    $serveur = "localhost";
    $utilisateur = "root";
    $motDePasse = ""; 
    $baseDeDonnees = "mayynote";
    $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

    if ($connexion->connect_error) {
        die("La connexion a échoué : " . $connexion->connect_error);
    }

    $sql = "INSERT INTO etudiants (Numero_Etu, Prénom_Etu, Nom_Etu, Identifiant_Etu, Mdp_Etu, Cursus, Annee, Numero_Grp) 
    VALUES ('$numero', '$prenom', '$nom', '$identifiant', '$mdp', '$cursus', '$annee', '$groupe')";

    if ($connexion->query($sql) === TRUE) {
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Erreur : " . $sql . "<br>" . $connexion->error;
    }

    $connexion->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_admin_gestion.css">
    <title>Gestion Étudiant</title>
    <style>
.form-container {
    display: <?php echo ($_SERVER["REQUEST_METHOD"] != "POST") ? 'none' : 'block'; ?>;
    width: 50%;
    margin: 20px auto; 
    padding: 20px;
    border-radius: 8px;
    text-align: center; 
}
    </style>
</head>
<body>
<header>
    <?php include '../include/logo.php'?>
</header>
<?php include '../include/menu_admin.php'?>
<br>
<h1>Gestion des étudiants</h1>
<button id="ajouter-button" onclick="AjouterEtu()">Ajouter un étudiant</button>

<div class="form-container">
    <form action="admin_gestionetudiants.php" method="POST">
        <label for="Numero_Etu">Numéro Etudiant :</label>
        <input type="number" name="Numero_Etu" required min="0" max="99"><br>

        <label for="Prenom_Etu">Prénom :</label>
        <input type="text" name="Prenom_Etu" required><br>

        <label for="Nom_Etu">Nom :</label>
        <input type="text" name="Nom_Etu" required><br>

        <label for="Identifiant_Etu">Identifiant :</label>
        <input type="text" name="Identifiant_Etu" required><br>

        <label for="Mdp_Etu">Mot de passe :</label>
        <input type="text" name="Mdp_Etu" required><br>

        <label for="Cursus">Cursus :</label>
        <input type="text" name="Cursus" required><br>

        <label for="Annee">Année :</label>
        <input type="text" name="Annee" required><br>

        <label for="Numero_Grp">Groupe :</label>
        <input type="number" name="Numero_Grp" required min="0" max="99"><br>

        <input class="button" type="submit" value="Ajouter">
    </form>
</div>


<br>
<h2>Liste des étudiants</h2>
<?php
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = ""; 
$baseDeDonnees = "mayynote";

$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}

$resultat = $connexion->query("SELECT * FROM etudiants");

if ($resultat->num_rows > 0) {
    echo "<table border='1'>
                <tr>
                    <th>Numero_Etu</th>
                    <th>Prenom_Etu</th>
                    <th>Nom_Etu</th>
                    <th>Identifiant_Etu</th>
                    <th>Mdp_Etu</th>
                    <th>Cursus</th>
                    <th>Annee</th>
                    <th>Numero_Grp</th>
                </tr>";

    while ($row = $resultat->fetch_assoc()) {
        echo "<tr>
                    <td>" . $row["Numero_Etu"] . "</td>
                    <td>" . $row["Prénom_Etu"] . "</td>
                    <td>" . $row["Nom_Etu"] . "</td>
                    <td>" . $row["Identifiant_Etu"] . "</td>
                    <td>" . $row["Mdp_Etu"] . "</td>
                    <td>" . $row["Cursus"] . "</td>
                    <td>" . $row["Annee"] . "</td>
                    <td>" . $row["Numero_Grp"] . "</td>
                </tr>";
    }
    echo "</table>";
} else {
    echo "<script>alert('Aucun étudiant trouvé');</script>";
}

$connexion->close();
?>

<button id="ajouter-button" onclick="EffacerEtu()">Effacer un étudiant</button>

<script>
    function AjouterEtu() {
        var formContainer = document.querySelector('.form-container');
        formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
    }

    function EffacerEtu() {
    var numeroEtu = prompt("Entrez le numéro de l'étudiant à supprimer :");
    if (numeroEtu !== null && numeroEtu !== "") {
        if (confirm("Êtes-vous sûr de vouloir supprimer l'étudiant avec le numéro " + numeroEtu + " ?")) {
            // Envoyer une requête AJAX pour supprimer l'étudiant
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../script/supprimer_etudiant.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Actualiser la page après la suppression
                    location.reload();
                }
            };
            xhr.send("numero_etu=" + numeroEtu);
        }
    }
}


</script>

<?php include '../include/footer.php'?>
</body>
</html>
