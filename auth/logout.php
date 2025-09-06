<?php
// Déconnexion pour le projet riziculture Madagascar
session_start();
require_once '../config/database.php';

// Supprimer la session de la base de données
if (isset($_SESSION['session_token'])) {
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare("DELETE FROM user_sessions WHERE session_token = ?");
        $stmt->execute([$_SESSION['session_token']]);
    } catch (Exception $e) {
        // Ignorer les erreurs de base de données
    }
}

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil
header('Location: ../index.html');
exit();
?>
