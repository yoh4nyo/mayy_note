<?php
include '../include/connexionBD.php';

if (isset($_GET['id'])) {
    $stmt = $connexion->prepare('SELECT * FROM ue WHERE Numero_UE = ?');
    $stmt->execute([$_GET['id']]);
    $ue = $stmt->fetch();
    if (!$ue) {
        die('UE non trouvée.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $connexion->prepare('UPDATE ue SET Nom_UE = ?, Coefficient_UE = ? WHERE Numero_UE = ?');
    $stmt->execute([
        $_POST['Nom_UE'], 
        $_POST['Coefficient_UE'], 
        $_POST['Numero_UE']
    ]);
    header('Location: ../html/admin_gestionue.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_page_modifier.css">
    <title>Modifier UE</title>
</head>
<body>
<div class="container">
    <div class="starter-template">
        <h1>Modifier une Unité d'Enseignement (UE)</h1>
        <form method="post" action="modifier_ue.php">
            <input type="hidden" name="Numero_UE" value="<?= htmlspecialchars($ue['Numero_UE']) ?>">
            <div class="form-group">
                <label for="Nom_UE">Nom</label>
                <input type="text" class="form-control" id="Nom_UE" name="Nom_UE" value="<?= htmlspecialchars($ue['Nom_UE']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Coefficient_UE">Coefficient</label>
                <input type="number" class="form-control" id="Coefficient_UE" name="Coefficient_UE" value="<?= htmlspecialchars($ue['Coefficient_UE']) ?>" required min="0" max="99">
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="../html/admin_gestionue.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
</body>
</html>
