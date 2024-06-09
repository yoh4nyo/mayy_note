<?php
include '../include/connexionBD.php';

if (isset($_GET['id'])) {
    $stmt = $connexion->prepare('SELECT * FROM ressources WHERE Numero_Res = ?');
    $stmt->execute([$_GET['id']]);
    $ressource = $stmt->fetch();
    if (!$ressource) {
        die('Ressource non trouvée.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $connexion->prepare('UPDATE ressources SET Nom_Res = ?, Coefficient_Res = ?, Numero_UE = ? WHERE Numero_Res = ?');
    $stmt->execute([
        $_POST['Nom_Res'], 
        $_POST['Coefficient_Res'], 
        $_POST['Numero_UE'], 
        $_POST['Numero_Res']
    ]);
    header('Location: ../html/admin_gestionressources.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_page_modifier.css">
    <title>Modifier Ressource</title>
</head>
<body>
<div class="container">
    <div class="starter-template">
        <h1>Modifier une Ressource</h1>
        <form method="post" action="modifier_ressource.php">
            <input type="hidden" name="Numero_Res" value="<?= htmlspecialchars($ressource['Numero_Res']) ?>">
            <div class="form-group">
                <label for="Nom_Res">Nom</label>
                <input type="text" class="form-control" id="Nom_Res" name="Nom_Res" value="<?= htmlspecialchars($ressource['Nom_Res']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Coefficient_Res">Coefficient</label>
                <input type="number" class="form-control" id="Coefficient_Res" name="Coefficient_Res" value="<?= htmlspecialchars($ressource['Coefficient_Res']) ?>" required min="0" max="99">
            </div>
            <div class="form-group">
                <label for="Numero_UE">Numéro UE</label>
                <input type="number" class="form-control" id="Numero_UE" name="Numero_UE" value="<?= htmlspecialchars($ressource['Numero_UE']) ?>" required min="0" max="99">
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="../html/admin_gestionressources.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
</body>
</html>
