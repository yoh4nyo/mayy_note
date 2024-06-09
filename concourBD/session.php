<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function verifierConnexion() {
    if (!isset($_SESSION['admin'])) {
        header('Location: login.php');
        exit;
    }
}
?>
