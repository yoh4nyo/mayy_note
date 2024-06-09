<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion de Concours</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .btn-custom-modifier {
            background-color: #007bff;
            color: white;
        }
        .btn-custom-modifier:hover {
            background-color: #0056b3;
            color: white;
        }
        .btn-custom-supprimer {
            background-color: #dc3545;
            color: white;
        }
        .btn-custom-supprimer:hover {
            background-color: #c82333;
            color: white;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="epreuves.php">Liste des Epreuves</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="candidats.php">Liste des Candidats</a>
                </li>
            </ul> 
            <?php if (isset($_SESSION['admin'])): //tester la session pour ajouter le bouton de deconnexion ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container">
