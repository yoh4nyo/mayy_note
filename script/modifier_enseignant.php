<?php
include '../include/connexionBD.php';

if (isset($_GET['id'])) {
    $stmt = $connexion->prepare('SELECT * FROM enseignants WHERE Numero_Ens = ?');
    $stmt->execute([$_GET['id']]);
    $enseignant = $stmt->fetch();
    if (!$enseignant) {
        die('Enseignant non trouvé.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $connexion->prepare('UPDATE enseignants SET Prenom_Ens = ?, Nom_Ens = ?, Identifiant_Ens = ?, Mdp_Ens = ?, role = ? WHERE Numero_Ens = ?');
    $stmt->execute([
        $_POST['Prenom_Ens'], 
        $_POST['Nom_Ens'], 
        $_POST['Identifiant_Ens'], 
        $_POST['Mdp_Ens'], 
        $_POST['role'], 
        $_POST['Numero_Ens']
    ]);
    header('Location: ../html/admin_gestionenseignant.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_page_modifier.css">
    <title>Modifier Enseignant</title>
</head>
<body>
<div class="container">
    <div class="starter-template">
        <h1>Modifier un Enseignant</h1>
        <form method="post" action="modifier_enseignant.php">
            <input type="hidden" name="Numero_Ens" value="<?= htmlspecialchars($enseignant['Numero_Ens']) ?>">
            <div class="form-group">
                <label for="Prenom_Ens">Prénom</label>
                <input type="text" class="form-control" id="Prenom_Ens" name="Prenom_Ens" value="<?= htmlspecialchars($enseignant['Prenom_Ens']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Nom_Ens">Nom</label>
                <input type="text" class="form-control" id="Nom_Ens" name="Nom_Ens" value="<?= htmlspecialchars($enseignant['Nom_Ens']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Identifiant_Ens">Identifiant</label>
                <input type="text" class="form-control" id="Identifiant_Ens" name="Identifiant_Ens" value="<?= htmlspecialchars($enseignant['Identifiant_Ens']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Mdp_Ens">Mot de passe</label>
                <input type="text" class="form-control" id="Mdp_Ens" name="Mdp_Ens" value="<?= htmlspecialchars($enseignant['Mdp_Ens']) ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select name="role">
                <option disabled selected>...</option>
                <option>enseignant</option>
                <option>administrateur</option>
        </select> <br>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="../html/admin_gestionenseignant.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
</body>
</html>
