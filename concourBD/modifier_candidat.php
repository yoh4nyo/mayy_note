<?php
include 'config.php';
include 'header.php';
$pdo = connexionDB();

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM Candidat WHERE idCand = ?');
    $stmt->execute([$_GET['id']]);
    $candidat = $stmt->fetch();
    if (!$candidat) {
        die('Candidat non trouvé.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('UPDATE Candidat SET nom = ?, Prenoms = ?, Adresse = ?, courriel = ?, specialite = ? WHERE idCand = ?');
    $stmt->execute([$_POST['nom'], $_POST['Prenoms'], $_POST['Adresse'], $_POST['courriel'], $_POST['specialite'], $_POST['idCand']]);
    header('Location: candidats.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier un Candidat</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="starter-template">
        <h1>Modifier un Candidat</h1>
        <form method="post" action="modifier_candidat.php">
            <input type="hidden" name="idCand" value="<?= htmlspecialchars($candidat['idCand']) ?>">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($candidat['nom']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Prenoms">Prénoms</label>
                <input type="text" class="form-control" id="Prenoms" name="Prenoms" value="<?= htmlspecialchars($candidat['Prenoms']) ?>" required>
            </div>
            <div class="form-group">
                <label for="Adresse">Adresse</label>
                <input type="text" class="form-control" id="Adresse" name="Adresse" value="<?= htmlspecialchars($candidat['Adresse']) ?>" required>
            </div>
            <div class="form-group">
                <label for="courriel">Courriel</label>
                <input type="email" class="form-control" id="courriel" name="courriel" value="<?= htmlspecialchars($candidat['courriel']) ?>" required>
            </div>
            <div class="form-group">
                <label for="specialite">Spécialité</label>
                <input type="text" class="form-control" id="specialite" name="specialite" value="<?= htmlspecialchars($candidat['specialite']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="candidats.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
