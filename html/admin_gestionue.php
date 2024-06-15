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

    include '../include/connexionBD.php'; 

    $sql = "INSERT INTO ue (Numero_UE, Nom_UE, Coefficient_UE) 
    VALUES (:numero, :nom, :coefficient)";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':coefficient', $coefficient);

    if ($stmt->execute()) {
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Erreur : " . $sql . "<br>" . $stmt->errorInfo()[2];
    }

    $connexion = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
<button id="ajouter-button" onclick="AjouterUe()">Ajouter une UE</button>

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
include '../include/connexionBD.php';

$resultat = $connexion->query("SELECT * FROM ue");

if ($resultat->rowCount() > 0) {
    echo "<table border='1'>
                <tr>
                    <th>Numero_UE</th>
                    <th>Nom_UE</th>
                    <th>Coefficient_UE</th>
                    <th>Action</th>
                </tr>";

    foreach ($resultat as $row) {
        echo "<tr>
                    <td>" . $row["Numero_UE"] . "</td>
                    <td>" . $row["Nom_UE"] . "</td>
                    <td>" . $row["Coefficient_UE"] . "</td>
                    <td>
                        <div class='button-container'>
                            <a href='../script/modifier_ue.php?id=" . $row["Numero_UE"] . "' class='edit-button'><i class='fas fa-edit'></i> Modifier</a> <br>
                            <a href='../script/supprimer_ue.php?id=" . $row["Numero_UE"] . "' class='delete-button' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cette ue?');\"><i class='fas fa-trash fa-border fa-lg'></i>Effacer</a>
                        </div>
                    </td>
                </tr>";
    }
    echo "</table>";
} else {
    echo "<script>alert('Aucune UE trouvée');</script>";
}

$connexion = null;
?>

<script>
    function AjouterUe() {
        var formContainer = document.querySelector('.form-container');
        formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
}


</script>

<?php include '../include/footer.php'?>
</body>
</html>
