<?php //rajouter l'utilisateur admin avec le mot de passe crypté à l'aide de la fonction password_hash
include 'config.php';

$pdo = connexionDB();
$username = 'admin';
$password = 'admin';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare('INSERT INTO Administrateur (username, password) VALUES (:username, :password)');
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $hashedPassword);

if ($stmt->execute()) {
    echo "Administrateur inséré avec succès.";
} else {
    echo "Erreur lors de l'insertion de l'administrateur.";
}
?>
