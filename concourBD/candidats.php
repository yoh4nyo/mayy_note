<?php
include 'config.php';
include 'header.php';
include 'session.php';

verifierConnexion();  //fonction définie dans le fichier session.php pour vérifier si l'utilisateur est connecté ou non et démarrer la session
$pdo = connexionDB();
$stmt = $pdo->query('SELECT * FROM Candidat'); //requete
$candidats = $stmt->fetchAll(); //récupérer le resultat dans un tableau associatif
?>

<div class="starter-template">
    <h1>Liste des Candidats</h1>
    <a href="ajouter_candidat.php" class="btn btn-primary mb-3">Ajouter un Candidat</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Adresse</th>
                <th>Courriel</th>
                <th>Spécialité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($candidats as $candidat): ?>
            <tr>
                <td><?= htmlspecialchars($candidat['idCand']) ?></td>
                <td><?= htmlspecialchars($candidat['nom']) ?></td>
                <td><?= htmlspecialchars($candidat['Prenoms']) ?></td>
                <td><?= htmlspecialchars($candidat['Adresse']) ?></td>
                <td><?= htmlspecialchars($candidat['courriel']) ?></td>
                <td><?= htmlspecialchars($candidat['specialite']) ?></td>
                <td>

    <a href="modifier_candidat.php?id=<?= $candidat['idCand'] ?>" class="btn btn-sm btn-custom-modifier">
        <i class="fas fa-edit"></i> Modifier
    </a>
    <a href="supprimer_candidat.php?id=<?= $candidat['idCand'] ?>" class="btn btn-sm btn-custom-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce candidat ?');">
        <i class="fas fa-trash-alt"></i> Supprimer
    </a>
</td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
