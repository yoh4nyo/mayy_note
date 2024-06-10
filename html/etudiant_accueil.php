<?php 
session_start();
if (!isset($_SESSION['Identifiant_Etu']) || empty($_SESSION['Identifiant_Etu'])) {
    header("Location: login.php");
    exit();
} 

$identifiantEtu = $_SESSION['Identifiant_Etu'];

include '../include/connexionBD.php'; 

    $stmt = $connexion->prepare("SELECT Numero_Etu, Nom_Etu, Prenom_Etu FROM etudiants WHERE Identifiant_Etu = :identifiant");
    $stmt->execute(['identifiant' => $identifiantEtu]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $numeroEtu = $result['Numero_Etu'];
    $nom = $result['Nom_Etu'];
    $prenom = $result['Prenom_Etu'];

    $stmt = $connexion->prepare("
        WITH Moyennes_UE AS (
            SELECT 
                notation.Numero_Etu,
                ue.Numero_UE,
                SUM(notation.Note * ressources.Coefficient_Res) / SUM(ressources.Coefficient_Res) AS Moyenne_UE,
                ue.Coefficient_UE
            FROM 
                notation
            INNER JOIN 
                ressources ON notation.Numero_Res = ressources.Numero_Res
            INNER JOIN 
                ue ON ressources.Numero_UE = ue.Numero_UE
            GROUP BY 
                notation.Numero_Etu, 
                ue.Numero_UE
        )
        SELECT 
            Numero_Etu,
            SUM(Moyenne_UE * Coefficient_UE) / SUM(Coefficient_UE) AS Moyenne_Generale
        FROM 
            Moyennes_UE
        GROUP BY 
            Numero_Etu
        ORDER BY 
            Moyenne_Generale DESC
    ");
    $stmt->execute();
    $moyennes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $moyenneGenerale = null;
    foreach ($moyennes as $index => $etudiant) {
        if ($etudiant['Numero_Etu'] == $numeroEtu) {
            $moyenneGenerale = $etudiant['Moyenne_Generale'];
            $rangEtudiant = $index + 1;
            break;
        }
    }

    $sommeMoyennes = array_sum(array_column($moyennes, 'Moyenne_Generale'));
    $nombreEtudiants = count($moyennes);
    $moyenneGeneralePromo = $sommeMoyennes / $nombreEtudiants;

    $appreciation = ($moyenneGenerale > 10) ? 'Bon travail' : 'Ne lâche rien !';
    $validationSemestre = ($moyenneGenerale > 10) ? 'OUI' : 'NON';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mayy Notes - Statistique</title>
    <link rel="stylesheet" href="../css/style_etudiant_accueil.css">
</head>
<body>
<header>
<?php include '../include/logo.php'?>
</header>
<?php include '../include/menu_etudiant.php'?>

    <div class="main">
        <div>
            <h1>Statistique | <?php echo $nom . " " . $prenom; ?></h1> <br>
        </div>
        <div class="stats">
            <div class="stat-box">
                <h2>rang sur la promo:</h2>
                <p><?php echo $rangEtudiant . '/' . $nombreEtudiants; ?></p>
            </div>
            <div class="stat-box">
                <h2>moyenne générale de la promo:</h2>
                <p><?php echo number_format($moyenneGeneralePromo, 2); ?></p>
            </div>
            <div class="stat-box">
                <h2>moyenne générale:</h2>
                <p><?php echo number_format($moyenneGenerale, 2); ?></p>
            </div>
        </div>
        <div class="content">
            <div class="chart">
                <h3>Vos moyennes:</h3>
                <img src="https://www.lecfomasque.com/wp-content/uploads/2014/03/moyenne-sur-graphique-3.jpg" alt="Histogramme des notes">
            </div>
            <div class="right-content">
                <div class="appreciation <?php echo $couleur?>">
                    <h3>Appréciation:</h3>
                    <p><?php echo $appreciation; ?></p>
                </div>
                <div class="validation" style="color: <?php echo $couleurValidation; ?>">
                    <h3>Validation du semestre:</h3>
                    <p><?php echo $validationSemestre; ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php include '../include/footer.php'?>