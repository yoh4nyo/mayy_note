<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $designation = $_POST['designation'];
    $coef = $_POST['coef'];
    $note_eliminat = $_POST['note_eliminat'];

    $pdo = connexionDB();
    $stmt = $pdo->prepare('INSERT INTO Epreuve (designation, Coef, Note_eliminat) VALUES (?, ?, ?)');//? pour représenter un paramètre anonyme
    $stmt->execute([$designation, $coef, $note_eliminat]);

    echo "<script type='text/javascript'>
            alert('Ajout réussi');
            window.location.href = 'epreuves.php';
          </script>";
}
?>

<?php include 'header.php'; ?>

<div class="starter-template">
    <h1>Ajouter une Epreuve</h1>
    <form method="post">
        <div class="form-group">
            <label for="designation">Désignation</label>
            <input type="text" class="form-control" id="designation" name="designation" required>
        </div>
        <div class="form-group">
            <label for="coef">Coef</label>
            <input type="number" class="form-control" id="coef" name="coef" required>
        </div>
        <div class="form-group">
            <label for="note_eliminat">Note Eliminatoire</label>
            <input type="number" step="0.01" class="form-control" id="note_eliminat" name="note_eliminat" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="epreuves.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>


