<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="../css/style_menu_admin.css" />
    <title>Document</title>
  </head>
  <body>

    <div class="off-screen-menu">
      <ul>
        <li><i class="fa-solid fa-user fa-border fa-lg"></i><a href="../html/admin_gestionetudiants.php">Étudiant</a></li> <br>
        <li><i class="fa-solid fa-user fa-border fa-lg"></i><a href="../html/admin_gestionenseignant.php">Enseignants</a></li> <br>
        <li><i class="fa-solid fa-list fa-border fa-lg"></i><a href="../html/admin_gestionue.php">UE</a></li> <br>
        <li><i class="fa-solid fa-list fa-border fa-lg"></i><a href="../html/admin_gestionressources.php">Ressources</a></li> <br>
        <li class="disconnect"><i class="fa-solid fa-power-off fa-border fa-lg"></i><a href="../include/logout.php">Déconnexion</a></li>
      </ul>
    </div>

    <nav>
      <div class="ham-menu">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </nav>

    <script src="../script/menu.js"></script>
  </body>
</html>