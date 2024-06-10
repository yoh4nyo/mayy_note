<?php
session_start();
if (!isset($_SESSION['Identifiant_Ens']) || empty($_SESSION['Identifiant_Ens'])) {
    // Redirection vers la page de connexion
    header("Location: login.php");
    exit();
} 

include '../include/connexionBD.php'; 

// Vérifier si des données ont été reçues
if (isset($_POST['updatedNotes']) && !empty($_POST['updatedNotes'])) {
    // Récupérer les données JSON et
    // les convertir en tableau associatif
    $updatedNotes = json_decode($_POST['updatedNotes'], true);

    // Parcourir les données mises à jour
    foreach ($updatedNotes as $id_note => $value) {
        // Préparer la requête d'update
        $sql = "UPDATE notation SET Note = :note WHERE id_note = :id_note";

        // Préparer et exécuter la requête
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':note', $value);
        $stmt->bindParam(':id_note', $id_note);
        $stmt->execute();
    }

    // Redirection vers la page prof_consultation après la mise à jour
    header("Location: ../html/prof_consultation.php");
    exit();
} else {
    // Si aucune donnée reçue, renvoyer un message d'erreur
    $response = [
        'success' => false,
        'message' => 'Aucune donnée reçue pour la mise à jour des notes.'
    ];
    echo json_encode($response);
}
?>
