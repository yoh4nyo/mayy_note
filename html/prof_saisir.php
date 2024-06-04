<?php 
    session_start();
        if (!isset($_SESSION['Identifiant_Ens']) || empty($_SESSION['Identifiant_Ens'])) {
            header("Location: login.php");
            exit();
} 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_prof_saisir.css">
    <title>Gestion des notes</title>
</head>
<body>
<header>
<?php include '../include/logo.php'?>
</header>
<?php include '../include/menu_prof.php'?>


    <form>
        <h1>Gestion des Notes</h1>

        <label for="module">Ressource :</label>
        <select>
            <option disabled selected>...</option>
            <option>Anglais</option>
            <option>Anglais renforcé</option>
            <option>Ergonomie</option>
          </select>
          

        <label for="coefficient">Coefficient :</label>
        <input type="number" min="0" max="99" required placeholder="0">

        <label for="libelle">Libéllé de l'évaluation :</label>
        <select>
            <option disabled selected>...</option>
            <option>SAE</option>
            <option>QCM</option>
            <option>Contrôle écrit</option>
            <option>Oral</option>
            <option>Partiel</option>
            <option>Soutenance</option>
          </select>

        <label for="groupe">Groupe :</label>
        <select>
        <option disabled selected>...</option>
            <option>SAE</option>
            <option>QCM</option>
            <option>Contrôle écrit</option>
            <option>Oral</option>
            <option>Partiel</option>
            <option>Soutenance</option>
          </select> <br>

        <button type="submit" class="btn">Suivant</button>
    </form>
<?php include '../include/footer.php'?>
</body>
</html>