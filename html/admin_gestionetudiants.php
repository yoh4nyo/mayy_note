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

    include '../include/connexionBD.php'; // Inclure le fichier de connexion à la base de données

    $sql = "INSERT INTO etudiants (Numero_Etu, Prenom_Etu, Nom_Etu, Identifiant_Etu, Mdp_Etu, Cursus, Annee, Numero_Grp) 
    VALUES (:numero, :prenom, :nom, :identifiant, :mdp, :cursus, :annee, :groupe)";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->bindParam(':cursus', $cursus);
    $stmt->bindParam(':annee', $annee);
    $stmt->bindParam(':groupe', $groupe);

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
include '../include/connexionBD.php';

$resultat = $connexion->query("SELECT * FROM etudiants");

if ($resultat->rowCount() > 0) {
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
                    <th>Action</th>
                </tr>";

    foreach ($resultat as $row) {
        echo "<tr>
                    <td>" . $row["Numero_Etu"] . "</td>
                    <td>" . $row["Prenom_Etu"] . "</td>
                    <td>" . $row["Nom_Etu"] . "</td>
                    <td>" . $row["Identifiant_Etu"] . "</td>
                    <td>" . $row["Mdp_Etu"] . "</td>
                    <td>" . $row["Cursus"] . "</td>
                    <td>" . $row["Annee"] . "</td>
                    <td>" . $row["Numero_Grp"] . "</td>
                    <td>
                        <div class='button-container'>
                            <a href='../script/modifier_etudiant.php?id=" . $row["Numero_Etu"] . "' class='edit-button'><i class='fas fa-edit'></i> Modifier</a> <br>
                            <a href='../script/supprimer_etudiant.php?id=" . $row["Numero_Etu"] . "' class='delete-button' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant?');\"><i class='fas fa-trash fa-border fa-lg'></i>Effacer</a>
                        </div>
                    </td>
                </tr>";
    }
    echo "</table>";
} else {
    echo "<script>alert('Aucun étudiant trouvé');</script>";
}

$connexion = null;
?>

<script>
    function AjouterEtu() {
        var formContainer = document.querySelector('.form-container');
        formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
}
</script>

<?php include '../include/footer.php'?>
</body>
</html>
