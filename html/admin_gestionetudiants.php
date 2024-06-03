<?php 
        session_start();
        if (!isset($_SESSION['Identifiant_admin']) || empty($_SESSION['Identifiant_admin'])) {
            // Redirection vers la page de connexion
            header("Location: login.php");
            exit();
        } 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_admin_gestion.css">
    <title>Dashboard Admin</title>
    <style>
        .form-container {
            display: none;
        }
    </style>
</head>
<body>
<header>
<?php include '../include/logo.php'?>
</header>
<?php include '../include/menu_admin.php'?>
    <h1>Gestion des étudiants</h1>

    <button onclick="toggleForm()">Ajouter un étudiant</button>

    <div class="form-container">
        <h2>Ajouter un étudiant</h2>
        <form action="admin_gestionetudiants.php" method="POST">
            <label for="Numero_Etu">Numéro Etudiant :</label>
            <input type="text" name="Numero_Etu" required><br><br>

            <label for="Prenom_Etu">Prénom :</label>
            <input type="text" name="Prenom_Etu" required><br><br>

            <label for="Nom_Etu">Nom :</label>
            <input type="text" name="Nom_Etu" required><br><br>

            <label for="Identifiant_Etu">Identifiant :</label>
            <input type="text" name="Identifiant_Etu" required><br><br>

            <label for="Mdp_Etu">Mot de passe :</label>
            <input type="text" name="Mdp_Etu" required><br><br>

            <label for="Cursus">Cursus :</label>
            <input type="text" name="Cursus" required><br><br>

            <label for="Annee">Année :</label>
            <input type="text" name="Annee" required><br><br>

            <label for="Numero_Grp">Groupe :</label>
            <input type="text" name="Numero_Grp" required><br><br>

            <input type="submit" value="Ajouter">
        </form>
    </div>

    <h2>Liste des étudiants</h2>
    <?php
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = ""; 
$baseDeDonnees = "mayynote";

$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

    // Vérification de la connexion
    if ($connexion->connect_error) {
        die("La connexion a échoué : " . $connexion->connect_error);
    }

    // Récupération des données de la table étudiants
    $resultat = $connexion->query("SELECT * FROM etudiants");

    // Affichage des données dans un tableau
    if ($resultat->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Numero_Etu</th>
                    <th>Prenom_Etu</th>
                    <th>Nom_Etu</th>
                    <th>Identifiant_Etu</th>
                    <th>Mdp_Etu</th>
                    <th>Cursus</th>
                    <th>Annee</th>
                    <th>Numero_Grp</th>
                </tr>";

        while($row = $resultat->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["Numero_Etu"]."</td>
                    <td>".$row["Prénom_Etu"]."</td>
                    <td>".$row["Nom_Etu"]."</td>
                    <td>".$row["Identifiant_Etu"]."</td>
                    <td>".$row["Mdp_Etu"]."</td>*
                    <td>".$row["Cursus"]."</td>
                    <td>".$row["Annee"]."</td>
                    <td>".$row["Numero_Grp"]."</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<script>alert('Aucunn étudiant trouvé');</script>";
    }

    // Fermeture de la connexion à la base de données
    $connexion->close();
    ?>

    <script>
        function toggleForm() {
            var formContainer = document.querySelector('.form-container');
            formContainer.style.display = (formContainer.style.display === 'none') ? 'block' : 'none';
        }
    </script>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $numero = $_POST['Numero_Etu'];
    $prenom = $_POST['Prenom_Etu'];
    $nom = $_POST['Nom_Etu'];
    $identifiant = $_POST['Identifiant_Etu'];
    $mdp = $_POST['Mdp_Etu'];
    $cursus = $_POST['Cursus'];
    $annee = $_POST['Annee'];
    $groupe = $_POST['Numero_Grp'];

    $serveur = "localhost";
    $utilisateur = "root";
    $motDePasse = ""; 
    $baseDeDonnees = "mayynote";
    
    $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

    if ($connexion->connect_error) {
        die("La connexion a échoué : " . $connexion->connect_error);
    }

    // Insertion des données dans la table étudiants
    $sql = "INSERT INTO etudiants (Numero_Etu, Prénom_Etu, Nom_Etu, Identifiant_Etu, Mdp_Etu, Cursus, Annee, Numero_Grp) 
    VALUES ('$numero', '$prenom', '$nom', '$identifiant', '$mdp', '$cursus', '$annee', '$groupe')";

    if ($connexion->query($sql) === TRUE) {
        echo "<script>alert('étudiant ajouté avec succès');</script>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $connexion->error;
    }

    // Fermeture de la connexion à la base de données
    $connexion->close();
}
?>
<?php include '../include/footer.php'?>
</body>
</html>