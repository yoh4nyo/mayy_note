<?php

session_start();
if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
} 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['Numero_UE'];
    $nom = $_POST['Nom_UE'];
    $coefficient = $_POST['Coefficient_UE'];

    $serveur = "localhost";
    $utilisateur = "root";
    $motDePasse = ""; 
    $baseDeDonnees = "mayynote";
    $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

    if ($connexion->connect_error) {
        die("La connexion a échoué : " . $connexion->connect_error);
    }

    $sql = "INSERT INTO ue (Numero_UE, Nom_UE, Coefficient_UE) 
    VALUES ('$numero', '$nom', '$coefficient')";

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
    <title>Gestion des UE</title>
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
<h1>Gestion des UE</h1>
<button id="ajouter-button" onclick="AjouterEtu()">Ajouter une UE</button>

<div class="form-container">
    <form action="admin_gestionue.php" method="POST">
        <label for="Numero_UE">Numéro</label>
        <input type="number" name="Numero_UE" required min="0" max="99"><br>

        <label for="Nom_UE">Nom UE : </label>
        <input type="text" name="Nom_UE" required><br>

        <label for="Coefficient_UE">Coefficient UE : </label>
        <input type="number" name="Coefficient_UE" required><br>


        <input class="button" type="submit" value="Ajouter">
    </form>
</div>


<br>
<h2>Liste des UE</h2>
<?php
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = ""; 
$baseDeDonnees = "mayynote";

$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}

$resultat = $connexion->query("SELECT * FROM ue");

if ($resultat->num_rows > 0) {
    echo "<table border='1'>
                <tr>
                    <th>Numero_UE</th>
                    <th>Nom_UE</th>
                    <th>Coefficient_UE</th>
                </tr>";

    while ($row = $resultat->fetch_assoc()) {
        echo "<tr>
                    <td>" . $row["Numero_UE"] . "</td>
                    <td>" . $row["Nom_UE"] . "</td>
                    <td>" . $row["Coefficient_UE"] . "</td>
                </tr>";
    }
    echo "</table>";
} else {
    echo "<script>alert('Aucune UE trouvée');</script>";
}

$connexion->close();
?>

<button id="ajouter-button" onclick="EffacerUE()">Effacer une UE</button>

<script>
    function AjouterEtu() {
        var formContainer = document.querySelector('.form-container');
        formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
    }

    function EffacerUE() {
    var numeroUE = prompt("Entrez le numéro de l'UE à supprimer :");
    if (numeroUE !== null && numeroUE !== "") {
        if (confirm("Êtes-vous sûr de vouloir supprimer l'UE avec le numéro " + numeroUE + " ?")) {
            // Envoyer une requête AJAX pour supprimer l'étudiant
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../script/supprimer_ue.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Actualiser la page après la suppression
                    location.reload();
                }
            };
            xhr.send("numero_ue=" + numeroUE);
        }
    }
}


</script>

<?php include '../include/footer.php'?>
</body>
</html>
