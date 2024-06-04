<?php

session_start();
if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
} 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['Numero_Ens'];
    $prenom = $_POST['Prenom_Ens'];
    $nom = $_POST['Nom_Ens'];
    $identifiant = $_POST['Identifiant_Ens'];
    $mdp = $_POST['Mdp_Ens'];
    $role = $_POST['role'];

    $serveur = "localhost";
    $utilisateur = "root";
    $motDePasse = ""; 
    $baseDeDonnees = "mayynote";
    $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

    if ($connexion->connect_error) {
        die("La connexion a échoué : " . $connexion->connect_error);
    }

    $sql = "INSERT INTO enseignants (Numero_Ens, Prenom_Ens, Nom_Ens, Identifiant_Ens, Mdp_Ens, role) 
    VALUES ('$numero', '$prenom', '$nom', '$identifiant', '$mdp', '$role')";

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
    <title>Gestion Professeur</title>
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
<h1>Gestion des professeurs</h1>
<button id="ajouter-button" onclick="AjouterEtu()">Ajouter un professeur</button>

<div class="form-container">
    <form action="admin_gestionenseignant.php" method="POST">
        <label for="Numero_Ens">Numéro</label>
        <input type="number" name="Numero_Ens" required min="0" max="99"><br>

        <label for="Prenom_Ens">Prénom : </label>
        <input type="text" name="Prenom_Ens" required><br>

        <label for="Nom_Ens">Nom : </label>
        <input type="text" required><br>

        <label for="Identifiant_Ens">Identifiant : </label>
        <input type="text" name="Identifiant_Ens" required><br>

        <label for="Mdp_Ens">Mot de passe : </label>
        <input type="text" name="Mdp_Ens" required><br>

        <label for="Role">Role :</label>
        <select>
            <option disabled selected>...</option>
            <option>Enseignant</option>
            <option>Administrateur</option>
        </select> <br>

        <input class="button" type="submit" value="Ajouter">
    </form>
</div>


<br>
<h2>Liste des professeurs</h2>
<?php
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = ""; 
$baseDeDonnees = "mayynote";

$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}

$resultat = $connexion->query("SELECT * FROM enseignants");

if ($resultat->num_rows > 0) {
    echo "<table border='1'>
                <tr>
                    <th>Numero_Ens</th>
                    <th>Prenom_Ens</th>
                    <th>Nom_Ens</th>
                    <th>Identifiant_Ens</th>
                    <th>Mdp_Ens</th>
                    <th>Role</th>
                </tr>";

    while ($row = $resultat->fetch_assoc()) {
        echo "<tr>
                    <td>" . $row["Numero_Ens"] . "</td>
                    <td>" . $row["Prenom_Ens"] . "</td>
                    <td>" . $row["Nom_Ens"] . "</td>
                    <td>" . $row["Identifiant_Ens"] . "</td>
                    <td>" . $row["Mdp_Ens"] . "</td>
                    <td>" . $row["role"] . "</td>
                </tr>";
    }
    echo "</table>";
} else {
    echo "<script>alert('Aucun professeur trouvé');</script>";
}

$connexion->close();
?>

<button id="ajouter-button" onclick="EffacerEns()">Effacer un enseignant</button>

<script>
    function AjouterEtu() {
        var formContainer = document.querySelector('.form-container');
        formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
    }

    function EffacerEns() {
    var numeroEns = prompt("Entrez le numéro de l'enseignant à supprimer :");
    if (numeroEns !== null && numeroEns !== "") {
        if (confirm("Êtes-vous sûr de vouloir supprimer l'enseignant avec le numéro " + numeroEns + " ?")) {
            // Envoyer une requête AJAX pour supprimer l'étudiant
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../script/supprimer_enseignant.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Actualiser la page après la suppression
                    location.reload();
                }
            };
            xhr.send("numero_ens=" + numeroEns);
        }
    }
}


</script>

<?php include '../include/footer.php'?>
</body>
</html>
