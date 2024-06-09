<?php
include '../include/connexionBD.php';

if (isset($_GET['id'])) {
    $stmt = $connexion->prepare('SELECT * FROM etudiants WHERE Numero_Etu = ?');
    $stmt->execute([$_GET['id']]);
    $etudiant = $stmt->fetch();
    if (!$etudiant) {
        die('Étudiant non trouvé.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $connexion->prepare('UPDATE etudiants SET Prenom_Etu = ?, Nom_Etu = ?, Identifiant_Etu = ?, Mdp_Etu = ?, Cursus = ?, Annee = ?, Numero_Grp = ? WHERE Numero_Etu = ?');
    $stmt->execute([
        $_POST['Prenom_Etu'], 
        $_POST['Nom_Etu'], 
        $_POST['Identifiant_Etu'], 
        $_POST['Mdp_Etu'], 
        $_POST['Cursus'], 
        $_POST['Annee'], 
        $_POST['Numero_Grp'], 
        $_POST['Numero_Etu']
    ]);
    header('Location: ../html/admin_gestionetudiants.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_page_modifier.css">
    <title>Modifier Étudiant</title>
</head>
<body>
<div class="container">
    <div class="starter-template">
        <h1>Modifier un Étudiant</h1>
        <form method="post" action="modifier_etudiant.php">
            <input type="hidden" name="Numero_Etu" value="<?= htmlspecialchars($etudiant['Numero_Etu']) ?>">
            <div class="form-group">
                <label for="Prénom_Etu">Prénom</label>
                <input type="text" class="form-control" id="Prenom_Etu" name="Prenom_Etu" value="<?= htmlspecialchars($etudiant['Prenom_Etu']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Nom_Etu">Nom</label>
                <input type="text" class="form-control" id="Nom_Etu" name="Nom_Etu" value="<?= htmlspecialchars($etudiant['Nom_Etu']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Identifiant_Etu">Identifiant</label>
                <input type="text" class="form-control" id="Identifiant_Etu" name="Identifiant_Etu" value="<?= htmlspecialchars($etudiant['Identifiant_Etu']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Mdp_Etu">Mot de passe</label>
                <input type="text" class="form-control" id="Mdp_Etu" name="Mdp_Etu" value="<?= htmlspecialchars($etudiant['Mdp_Etu']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Cursus">Cursus</label>
                <input type="text" class="form-control" id="Cursus" name="Cursus" value="<?= htmlspecialchars($etudiant['Cursus']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Annee">Année</label>
                <input type="text" class="form-control" id="Annee" name="Annee" value="<?= htmlspecialchars($etudiant['Annee']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Numero_Grp">Groupe</label>
                <input type="number" class="form-control" id="Numero_Grp" name="Numero_Grp" value="<?= htmlspecialchars($etudiant['Numero_Grp']) ?>" required min="0" max="99">
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="../html/admin_gestionetudiants.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
</body>
</html>
