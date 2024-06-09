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

    include '../include/connexionBD.php';

    $sql = "INSERT INTO enseignants (Numero_Ens, Prenom_Ens, Nom_Ens, Identifiant_Ens, Mdp_Ens, role) 
    VALUES (:numero, :prenom, :nom, :identifiant, :mdp, :role)";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Erreur : " . $sql . "<br>" . $connexion->errorInfo()[2];
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
        <input type="text" name="Nom_Ens" required><br>

        <label for="Identifiant_Ens">Identifiant : </label>
        <input type="text" name="Identifiant_Ens" required><br>

        <label for="Mdp_Ens">Mot de passe : </label>
        <input type="text" name="Mdp_Ens" required><br>

        <label for="Role">Role :</label>
        <select name="role">
            <option disabled selected>...</option>
            <option>enseignant</option>
            <option>administrateur</option>
        </select> <br>

        <input class="button" type="submit" value="Ajouter">
    </form>
</div>


<br>
<h2>Liste des professeurs</h2>
<?php
include '../include/connexionBD.php';

$resultat = $connexion->query("SELECT * FROM enseignants");

if ($resultat->rowCount() > 0) {
    echo "<table border='1'>
                <tr>
                    <th>Numero_Ens</th>
                    <th>Prenom_Ens</th>
                    <th>Nom_Ens</th>
                    <th>Identifiant_Ens</th>
                    <th>Mdp_Ens</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>";

    foreach ($resultat as $row) {
        echo "<tr>
                    <td>" . $row["Numero_Ens"] . "</td>
                    <td>" . $row["Prenom_Ens"] . "</td>
                    <td>" . $row["Nom_Ens"] . "</td>
                    <td>" . $row["Identifiant_Ens"] . "</td>
                    <td>" . $row["Mdp_Ens"] . "</td>
                    <td>" . $row["role"] . "</td>
                    <td>
                        <div class='button-container'>
                            <a href='../script/modifier_enseignant.php?id=" . $row["Numero_Ens"] . "' class='edit-button'><i class='fas fa-edit'></i> Modifier</a> <br>
                            <a href='../script/supprimer_enseignant.php?id=" . $row["Numero_Ens"] . "' class='delete-button' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant?');\"><i class='fas fa-trash fa-border fa-lg'></i>Effacer</a>
                        </div>
                    </td>
                </tr>";
    }
    echo "</table>";
} else {
    echo "<script>alert('Aucun professeur trouvé');</script>";
}
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
