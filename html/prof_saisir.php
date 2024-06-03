<?php 
    session_start();
        if (!isset($_SESSION['Identifiant_Ens']) || empty($_SESSION['Identifiant_Ens'])) {
            // Redirection vers la page de connexion
            header("Location: login.php");
            exit();
} 
?>
<!DOCTYPE html>
<html lang="en">
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

        <label for="module">Module :</label>
        <select id="module-select">
            <option value="" disabled selected>...</option>
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
            <option value="hamster">Hamster</option>
            <option value="parrot">Parrot</option>
            <option value="spider">Spider</option>
            <option value="goldfish">Goldfish</option>
          </select>
          

        <label for="coefficient">Coefficient :</label>
        <input type="number" id="coefficient" min="0" max="99" required placeholder="0">

        <label for="libelle">Libéllé de l'évaluation :</label>
        <input type="text" id="libelle" required>

        <label for="groupe">Groupe :</label>
        <select id="groupe-select">
            <option value="" disabled selected>...</option>
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
            <option value="hamster">Hamster</option>
            <option value="parrot">Parrot</option>
            <option value="spider">Spider</option>
            <option value="goldfish">Goldfish</option>
          </select> <br>

        <button type="submit" class="btn">Suivant</button>
    </form>
<?php include '../include/footer.php'?>
</body>
</html>