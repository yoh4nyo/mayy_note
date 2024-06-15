<?php
session_start();
if (!isset($_SESSION['Identifiant_Etu']) || empty($_SESSION['Identifiant_Etu'])) {
    header("Location: login.php");
    exit();
} 

include '../include/connexionBD.php'; 

$resultat = $connexion->query("SELECT DISTINCT Type_Note, Nom_UE, Nom_Res FROM notation JOIN ressources ON notation.Numero_Res = ressources.Numero_Res JOIN ue ON ressources.Numero_UE = ue.Numero_UE");

$data_by_category = [
    'UE' => [],
    'Ressources' => [],
    'Type_Note' => []
];

while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
    $data_by_category['UE'][] = $row['Nom_UE'];
    $data_by_category['Ressources'][] = $row['Nom_Res'];
    $data_by_category['Type_Note'][] = $row['Type_Note'];
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
    <link rel="stylesheet" href="../css/style_etudiant_consultation.css">
    <title>Consulter les notes</title>
</head>
<body>
<header>
    <?php include '../include/logo.php'?>
</header>
<?php include '../include/menu_etudiant.php'?>
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
            <th>Type de note</th>
            <th>Nom de l'UE</th>
            <th>Nom de la ressource</th>
            <th>Note</th>
            <th>Coefficient</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $category = isset($_POST['category']) ? $_POST['category'] : '';

        $identifiant_etu = $_SESSION['Identifiant_Etu'];
        $stmt = $connexion->prepare("SELECT Numero_Etu FROM etudiants WHERE Identifiant_Etu = :Identifiant_Etu");
        $stmt->bindParam(':Identifiant_Etu', $identifiant_etu);
        $stmt->execute();
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($etudiant) {
            $numero_etu = $etudiant['Numero_Etu'];

            if (!empty($category)) {
                $sql_ue = "SELECT notation.Type_Note, ue.Nom_UE, ressources.Nom_Res, notation.Note, notation.Coefficient_Note, notation.Date
                           FROM notation 
                           JOIN ressources ON notation.Numero_Res = ressources.Numero_Res 
                           JOIN ue ON ressources.Numero_UE = ue.Numero_UE
                           WHERE ue.Nom_UE = :category AND notation.Numero_Etu = :Numero_Etu";
                
                $sql_res = "SELECT notation.Type_Note, ue.Nom_UE, ressources.Nom_Res, notation.Note, notation.Coefficient_Note, notation.Date
                            FROM notation 
                            JOIN ressources ON notation.Numero_Res = ressources.Numero_Res 
                            JOIN ue ON ressources.Numero_UE = ue.Numero_UE
                            WHERE ressources.Nom_Res = :category AND notation.Numero_Etu = :Numero_Etu";
                
                $sql_type = "SELECT notation.Type_Note, ue.Nom_UE, ressources.Nom_Res, notation.Note, notation.Coefficient_Note, notation.Date
                             FROM notation 
                             JOIN ressources ON notation.Numero_Res = ressources.Numero_Res 
                             JOIN ue ON ressources.Numero_UE = ue.Numero_UE
                             WHERE notation.Type_Note = :category AND notation.Numero_Etu = :Numero_Etu";

                $stmt_ue = $connexion->prepare($sql_ue);
                $stmt_res = $connexion->prepare($sql_res);
                $stmt_type = $connexion->prepare($sql_type);

                $stmt_ue->bindParam(':Numero_Etu', $numero_etu);
                $stmt_res->bindParam(':Numero_Etu', $numero_etu);
                $stmt_type->bindParam(':Numero_Etu', $numero_etu);

                $stmt_ue->bindParam(':category', $category);
                $stmt_res->bindParam(':category', $category);
                $stmt_type->bindParam(':category', $category);

                $stmt_ue->execute();
                $stmt_res->execute();
                $stmt_type->execute();

                $results_ue = $stmt_ue->fetchAll(PDO::FETCH_ASSOC);
                $results_res = $stmt_res->fetchAll(PDO::FETCH_ASSOC);
                $results_type = $stmt_type->fetchAll(PDO::FETCH_ASSOC);

                foreach ($results_ue as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['Type_Note'] . "</td>";
                    echo "<td>" . $row['Nom_UE'] . "</td>";
                    echo "<td>" . $row['Nom_Res'] . "</td>";
                    echo "<td>" . $row['Note'] . "</td>";
                    echo "<td>" . $row['Coefficient_Note'] . "</td>";
                    echo "<td>" . $row['Date'] . "</td>";
                    echo "</tr>";
                }

                foreach ($results_res as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['Type_Note'] . "</td>";
                    echo "<td>" . $row['Nom_UE'] . "</td>";
                    echo "<td>" . $row['Nom_Res'] . "</td>";
                    echo "<td>" . $row['Note'] . "</td>";
                    echo "<td>" . $row['Coefficient_Note'] . "</td>";
                    echo "<td>" . $row['Date'] . "</td>";
                    echo "</tr>";
                }

                foreach ($results_type as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['Type_Note'] . "</td>";
                    echo "<td>" . $row['Nom_UE'] . "</td>";
                    echo "<td>" . $row['Nom_Res'] . "</td>";
                    echo "<td>" . $row['Note'] . "</td>";
                    echo "<td>" . $row['Coefficient_Note'] . "</td>";
                    echo "<td>" . $row['Date'] . "</td>";
                    echo "</tr>";
                }

            } else {
                $sql_all = "SELECT notation.Type_Note, ue.Nom_UE, ressources.Nom_Res, notation.Note, notation.Coefficient_Note, notation.Date
                            FROM notation 
                            JOIN ressources ON notation.Numero_Res = ressources.Numero_Res 
                            JOIN ue ON ressources.Numero_UE = ue.Numero_UE
                            WHERE notation.Numero_Etu = :Numero_Etu";

                $stmt_all = $connexion->prepare($sql_all);
                $stmt_all->bindParam(':Numero_Etu', $numero_etu);
                $stmt_all->execute();

                $results_all = $stmt_all->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results_all as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['Type_Note'] . "</td>";
                    echo "<td>" . $row['Nom_UE'] . "</td>";
                    echo "<td>" . $row['Nom_Res'] . "</td>";
                    echo "<td>" . $row['Note'] . "</td>";
                    echo "<td>" . $row['Coefficient_Note'] . "</td>";
                    echo "<td>" . $row['Date'] . "</td>";
                    echo "</tr>";
                }
            }
        }
        ?>
    </tbody>
</table>

<?php include '../include/footer.php'?>
</body>
</html>
