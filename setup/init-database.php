<?php
// Script d'initialisation de la base de données pour le projet riziculture Madagascar
// Ce script crée la base de données et les tables nécessaires

require_once '../config/database.php';

echo "<h1>Initialisation de la base de données - Deep Rice Madagascar</h1>";

try {
    // Connexion sans spécifier de base de données
    $host = 'localhost';
    $username = 'root';
    $password = '';
    
    $conn = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p>✅ Connexion au serveur MySQL réussie</p>";
    
    // Lire et exécuter le script SQL
    $sql = file_get_contents('../database/schema.sql');
    
    // Diviser le script en requêtes individuelles
    $queries = explode(';', $sql);
    
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            $conn->exec($query);
        }
    }
    
    echo "<p>✅ Base de données 'riziculture_madagascar' créée avec succès</p>";
    echo "<p>✅ Tables créées avec succès</p>";
    echo "<p>✅ Données de test insérées</p>";
    
    echo "<h2>Comptes créés :</h2>";
    echo "<ul>";
    echo "<li><strong>Admin:</strong> admin / password</li>";
    echo "<li><strong>Expert 1:</strong> expert1 / password</li>";
    echo "<li><strong>Expert 2:</strong> expert2 / password</li>";
    echo "</ul>";
    
    echo "<h2>Prochaines étapes :</h2>";
    echo "<ol>";
    echo "<li>Supprimez ce fichier (setup/init-database.php) pour des raisons de sécurité</li>";
    echo "<li>Accédez à <a href='../auth/login.php'>la page de connexion</a></li>";
    echo "<li>Testez les fonctionnalités avec les comptes créés</li>";
    echo "</ol>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Erreur : " . $e->getMessage() . "</p>";
    echo "<p>Vérifiez que :</p>";
    echo "<ul>";
    echo "<li>XAMPP est démarré</li>";
    echo "<li>MySQL est en cours d'exécution</li>";
    echo "<li>Les paramètres de connexion dans config/database.php sont corrects</li>";
    echo "</ul>";
}
?>

<style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    h1 { color: #059669; }
    h2 { color: #374151; margin-top: 30px; }
    p { margin: 10px 0; }
    ul, ol { margin: 10px 0; padding-left: 30px; }
    a { color: #059669; text-decoration: none; }
    a:hover { text-decoration: underline; }
</style>
