<?php 
session_start();
if (!isset($_SESSION['Identifiant_Ens']) || empty($_SESSION['Identifiant_Ens'])) {
    header("Location: login.php");
    exit();
}

include '../include/connexionBD.php'; 

// Récupérer les données des étudiants pour le menu déroulant
$sql_etudiants = "SELECT Numero_Etu, Nom_Etu, Prenom_Etu, Numero_Grp FROM etudiants ORDER BY Nom_Etu, Prenom_Etu";
$stmt_etudiants = $connexion->query($sql_etudiants);
$etudiants = $stmt_etudiants->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $module = $_POST['module'];
    $coefficient = $_POST['coefficient'];
    $libelle = $_POST['libelle'];
    $date = $_POST['date'];
    $numero_etu = $_POST['numero_etu'];
    $note = $_POST['note'];
    $numero_grp = $_POST['numero_grp'];

    // Vérifier si l'étudiant sélectionné est valide
    $sql = "SELECT * FROM etudiants WHERE Numero_Etu = :numero_etu"; 
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':numero_etu', $numero_etu, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Mettre à jour le numéro du groupe en fonction de l'étudiant sélectionné
        $numero_grp = $result['Numero_Grp'];
    }

    $numero_ens = $_SESSION['Numero_Ens']; 

    $sql = "INSERT INTO notation (Type_Note, Note, Coefficient_Note, Date, Numero_Etu, Numero_Res, Numero_Ens, Numero_Grp) 
            VALUES (:libelle, :note, :coefficient, :date, :numero_etu, :module, :numero_ens, :numero_grp)"; 
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':libelle', $libelle, PDO::PARAM_STR);
    $stmt->bindParam(':note', $note, PDO::PARAM_INT);
    $stmt->bindParam(':coefficient', $coefficient, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':numero_etu', $numero_etu, PDO::PARAM_INT);
    $stmt->bindParam(':module', $module, PDO::PARAM_INT);
    $stmt->bindParam(':numero_ens', $numero_ens, PDO::PARAM_INT);
    $stmt->bindParam(':numero_grp', $numero_grp, PDO::PARAM_INT); 

    if ($stmt->execute()) {
        echo "<script>alert('Entrée réussie.');</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'insertion des données : " . $stmt->errorInfo()[2] . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_prof_saisir.css">
    <title>Gestion des notes</title>
    <script>
        function updateNumeroGroupe() {
            var select = document.getElementById("numero_etu");
            var numero_grp_input = document.getElementById("numero_grp");
            var selected_numero_etu = select.value;
            
            // Requête AJAX pour récupérer le numéro du groupe associé à l'étudiant sélectionné
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    numero_grp_input.value = this.responseText;
                }
            };
            xhr.open("GET", "get_numero_grp.php?numero_etu=" + selected_numero_etu, true);
            xhr.send();
        }
    </script>
</head>
<body>
<header>
<?php include '../include/logo.php'?>
</header>
<?php include '../include/menu_prof.php'?>

<form method="post" action="">
    <h1>Gestion des Notes</h1>

    <label for="module">Numéro de la Ressource :</label>
    <select name="module" required>
        <option disabled selected>...</option>
        <?php
            $sql = "SELECT Numero_Res FROM ressources ORDER BY 1";
            $stmt = $connexion->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($_POST['module'] == $row['Numero_Res']) ? 'selected' : '';
                echo "<option value='{$row['Numero_Res']}' $selected>{$row['Numero_Res']}</option>";
            }
        ?>
    </select>

    <label for="coefficient">Coefficient :</label>
    <input type="number" name="coefficient" min="0" max="99" required placeholder="0" value="<?php echo $_POST['coefficient'] ?? ''; ?>">

    <label for="libelle">Type de note :</label>
    <select name="libelle" required>
        <option disabled selected>...</option>
        <?php
            $types_notes = array("SAE", "QCM", "Contrôle écrit", "Oral", "Partiel", "Soutenance");
            foreach ($types_notes as $type) {
                $selected = ($_POST['libelle'] == $type) ? 'selected' : '';
                echo "<option value='$type' $selected>$type</option>";
            }
        ?>
    </select>

    <label for="date">Date :</label>
    <input type="date" name="date" required value="<?php echo $_POST['date'] ?? ''; ?>">

    <label for="numero_etu">Nom de l'étudiant :</label>
    <select name="numero_etu" id="numero_etu" required onchange="updateNumeroGroupe()">
        <option disabled selected>...</option>
        <?php
            foreach ($etudiants as $etudiant) {
                $selected = ($_POST['numero_etu'] == $etudiant['Numero_Etu']) ? 'selected' : '';
                echo "<option value='{$etudiant['Numero_Etu']}' $selected>{$etudiant['Nom_Etu']} {$etudiant['Prenom_Etu']}</option>";
            }
        ?>
    </select>

    <label for="numero_grp">Numéro du groupe :</label> 
    <input type="number" name="numero_grp" id="numero_grp" min="0" max="9999" required placeholder="0">

    <label for="note">Note :</label>
    <input type="number" name="note" min="0" max="20" required placeholder="0">

    <button type="submit" class="btn">Suivant</button>
</form>


<?php include '../include/footer.php'?>

</body>
</html>
