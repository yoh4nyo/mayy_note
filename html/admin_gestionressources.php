<?php

session_start();
if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
    header("Location: login.php");
    exit();
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['Numero_Res'];
    $nom = $_POST['Nom_Res'];
    $coefficient = $_POST['Coefficient_Res'];
    $num_ue = $_POST['Numero_UE'];

    include '../include/connexionBD.php'; // Inclure le fichier de connexion à la base de données

    $sql = "INSERT INTO ressources (Numero_Res, Nom_Res, Coefficient_Res, Numero_UE) 
    VALUES (:numero, :nom, :coefficient, :num_ue)";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':coefficient', $coefficient);
    $stmt->bindParam(':num_ue', $num_ue);

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
    <link rel="stylesheet" href="../css/style_admin_gestion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Gestion des ressources</title>
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
<h1>Gestion des ressources</h1>
<button id="ajouter-button" onclick="AjouterRes()">Ajouter une ressource</button>

<div class="form-container">
    <form action="admin_gestionue.php" method="POST">
        <label for="Numero_Res">Numéro</label>
        <input type="number" name="Numero_Res" required min="0" max="1000"><br>

        <label for="Nom_Res">Nom de la ressource : </label>
        <input type="text" name="Nom_Res" required><br>

        <label for="Coefficient_Res">Coefficient de la ressource : </label>
        <input type="number" name="Coefficient_Res" min="0" max="99" required><br>

        <label for="Numero_UE">Numéro UE </label>
        <input type="number" name="Numero_UE" min="0" max="1000" required><br>


        <input class="button" type="submit" value="Ajouter">
    </form>
</div>


<br>
<h2>Liste des ressources</h2>
<?php
include '../include/connexionBD.php';

$resultat = $connexion->query("SELECT * FROM ressources");

if ($resultat->rowCount() > 0) {
    echo "<table border='1'>
                <tr>
                    <th>Numero_Res</th>
                    <th>Nom_Res</th>
                    <th>Coefficient_Res</th>
                    <th>Numero_UE</th>
                    <th>Action</th>
                </tr>";

    foreach ($resultat as $row) {
        echo "<tr>
                    <td>" . $row["Numero_Res"] . "</td>
                    <td>" . $row["Nom_Res"] . "</td>
                    <td>" . $row["Coefficient_Res"] . "</td>
                    <td>" . $row["Numero_UE"] . "</td>
                    <td>
                        <a href='../script/supprimer_ressource.php?id=" . $row["Numero_Res"] . "' class='delete-button' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cette ressource?');\"><i class='fas fa-trash fa-border fa-lg'></i>Effacer</a>
                    </td>
                </tr>";
    }
    echo "</table>";
} else {
    echo "<script>alert('Aucune Ressource trouvée');</script>";
}

$connexion = null;
?>

<script>
    function AjouterRes() {
        var formContainer = document.querySelector('.form-container');
        formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
}

</script>

<?php include '../include/footer.php'?>
</body>
</html>
