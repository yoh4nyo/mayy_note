<?php
include 'config.php';

$pdo = connexionDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $designation = $_POST['designation'];
    $coef = $_POST['coef'];
    $note_eliminat = $_POST['note_eliminat'];

    $stmt = $pdo->prepare('UPDATE Epreuve SET designation = ?, Coef = ?, Note_eliminat = ? WHERE idEpr = ?');
    $stmt->execute([$designation, $coef, $note_eliminat, $id]);

    echo "<script type='text/javascript'>
            alert('Modification réussie');
            window.location.href = 'epreuves.php';
          </script>";
} else {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM Epreuve WHERE idEpr = ?');
    $stmt->execute([$id]);
    $epreuve = $stmt->fetch();
}

include 'header.php';
?>

<div class="starter-template">
    <h1>Modifier une Epreuve</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($epreuve['idEpr']) ?>">
        <div class="form-group">
            <label for="designation">Désignation</label>
            <input type="text" class="form-control" id="designation" name="designation" value="<?= htmlspecialchars($epreuve['designation']) ?>" required>
        </div>
        <div class="form-group">
            <label for="coef">Coef</label>
            <input type="number" class="form-control" id="coef" name="coef" value="<?= htmlspecialchars($epreuve['Coef']) ?>" required>
        </div>
        <div class="form-group">
            <label for="note_eliminat">Note Eliminatoire</label>
            <input type="number" step="0.01" class="form-control" id="note_eliminat" name="note_eliminat" value="<?= htmlspecialchars($epreuve['Note_eliminat']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="epreuves.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>


