<?php
include 'config.php';
include 'header.php';
include 'session.php';

verifierConnexion();
$pdo = connexionDB();
$stmt = $pdo->query('SELECT * FROM Epreuve');
$epreuves = $stmt->fetchAll();
?>

<div class="starter-template">
    <h1>Liste des Epreuves</h1>
    <a href="ajouter_epreuve.php" class="btn btn-primary mb-3">Ajouter une Epreuve</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Désignation</th>
                <th>Coef</th>
                <th>Note Eliminatoire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($epreuves as $epreuve): ?>
            <tr>
                <td><?= htmlspecialchars($epreuve['idEpr']) ?></td>
                <td><?= htmlspecialchars($epreuve['designation']) ?></td>
                <td><?= htmlspecialchars($epreuve['Coef']) ?></td>
                <td><?= htmlspecialchars($epreuve['Note_eliminat']) ?></td>
                <td>
                    <a href="modifier_epreuve.php?id=<?= $epreuve['idEpr'] ?>" class="btn btn-sm btn-custom-modifier">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="supprimer_epreuve.php?id=<?= $epreuve['idEpr'] ?>" class="btn btn-sm btn-custom-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette épreuve ?');">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


