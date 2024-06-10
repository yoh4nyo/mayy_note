<?php
session_start();
if (!isset($_SESSION['Identifiant_Ens']) || empty($_SESSION['Identifiant_Ens'])) {
    header("Location: login.php");
    exit();
} 

include '../include/connexionBD.php'; 

$data_by_category = [
    'Groupe' => [],
];

$resultat = $connexion->prepare("SELECT DISTINCT Nom_Grp FROM groupe");

$resultat->execute(); 
while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
    $data_by_category['Groupe'][] = $row['Nom_Grp']; 
}

foreach ($data_by_category as &$category) {
    $category = array_unique($category);
    sort($category);
}
unset($category);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_prof_consultation.css">
    <title>Consulter les notes</title>
</head>
<body>
<header>
    <?php include '../include/logo.php'?>
</header>
<?php include '../include/menu_prof.php'?>
<br>
<h1>Consulter les notes</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="data">Sélectionnez :</label>
    <select name="category" id="data">
        <option value="">Sélectionnez une option</option>
        <?php foreach ($data_by_category as $category => $data) : ?>
            <optgroup label="<?php echo $category; ?>">
                <?php foreach ($data as $item) : ?>
                    <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                <?php endforeach; ?>
            </optgroup>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Valider">
</form>


<table>
    <thead>
        <tr>
            <th>Numéro étudiant</th>
            <th>Type de note</th>
            <th>Nom de l'UE</th>
            <th>Nom de la ressource</th>
            <th>Numéro de la ressource</th>
            <th>Note</th>
            <th>Coefficient</th>
            <th>Date</th>
            <th>Actions</th> 
        </tr>
    </thead>
    <tbody>
        <?php
$category = isset($_POST['category']) ? $_POST['category'] : '';

$sql = "SELECT notation.id_note, notation.Type_Note, ue.Nom_UE, ressources.Nom_Res, notation.Numero_Etu, notation.Note, notation.Numero_Res, notation.Coefficient_Note, notation.Date
        FROM notation 
        JOIN ressources ON notation.Numero_Res = ressources.Numero_Res 
        JOIN ue ON ressources.Numero_UE = ue.Numero_UE
        JOIN etudiants ON notation.Numero_Etu = etudiants.Numero_Etu
        JOIN groupe ON etudiants.Numero_Grp = groupe.Numero_Grp
        WHERE notation.Numero_Ens = :Numero_Ens";

if (!empty($category)) {
    $sql .= " AND groupe.Nom_Grp = :category";
}

$sql .= " ORDER BY notation.Numero_Etu"; 

$stmt = $connexion->prepare($sql);
$stmt->bindParam(':Numero_Ens', $_SESSION['Numero_Ens'], PDO::PARAM_INT);

if (!empty($category)) {
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
}

$stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Numero_Etu']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Type_Note']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nom_UE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nom_Res']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Numero_Res']) . "</td>";
            echo "<td><input type='number' value='" . htmlspecialchars($row['Note']) . "' id='note_" . htmlspecialchars($row['id_note']) . "' disabled></td>"; 
            echo "<td>" . htmlspecialchars($row['Coefficient_Note']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
            echo "<td><button onclick='enableInput(this)'>Modifier</button></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<form action="../script/update_note.php" method="POST" id="updateForm">
    <input type="hidden" name="updatedNotes" id="updatedNotes">
    <input type="submit" value="Valider" onclick="validateChanges()">
</form>


<script>
function enableInput(button) {
    var row = button.parentNode.parentNode;
    var inputs = row.querySelectorAll('input[type="number"]');
    inputs.forEach(function(input) {
        input.disabled = !input.disabled;
    });
}

function validateChanges() {
    var updatedNotes = {};
    var inputs = document.querySelectorAll('input[type="number"]:not([disabled])');
    inputs.forEach(function(input) {
        var idNote = input.id.replace('note_', ''); 
        updatedNotes[idNote] = input.value;
    });

    document.getElementById('updatedNotes').value = JSON.stringify(updatedNotes);
}
</script>


<?php include '../include/footer.php'?>
</body>
</html>
