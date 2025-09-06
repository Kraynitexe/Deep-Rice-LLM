<?php
// Page de demande d'expert pour le projet riziculture Madagascar
session_start();
require_once '../config/database.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = trim($_POST['subject'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $urgency = $_POST['urgency'] ?? 'medium';
    
    if (empty($subject) || empty($description)) {
        $error_message = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            $conn = getDBConnection();
            
            $stmt = $conn->prepare("INSERT INTO expert_requests (user_id, subject, description, urgency) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $subject, $description, $urgency]);
            
            $success_message = 'Votre demande a été envoyée avec succès ! Un expert vous contactera dans les plus brefs délais.';
            
            // Réinitialiser le formulaire
            $subject = $description = '';
            $urgency = 'medium';
        } catch (Exception $e) {
            $error_message = 'Erreur lors de l\'envoi de la demande. Veuillez réessayer.';
        }
    }
}

// Récupérer les demandes de l'utilisateur
$user_requests = [];
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("
        SELECT er.*, u.full_name as expert_name 
        FROM expert_requests er 
        LEFT JOIN users u ON er.assigned_expert_id = u.id 
        WHERE er.user_id = ? 
        ORDER BY er.created_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $user_requests = $stmt->fetchAll();
} catch (Exception $e) {
    // Ignorer les erreurs
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demander un Expert - Deep Rice Madagascar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../maitso.jpg">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #10b981, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <?php include 'components/header.php'; ?>
    
    <main class="pt-20 px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- En-tête -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-user-tie text-green-600 mr-3"></i>
                    Demander l'aide d'un Expert
                </h1>
                <p class="text-lg text-gray-600">
                    Obtenez des conseils personnalisés de nos experts en riziculture malgache
                </p>
            </div>

            <!-- Messages -->
            <?php if ($success_message): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Formulaire de demande -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        <i class="fas fa-plus-circle text-green-600 mr-2"></i>
                        Nouvelle demande
                    </h2>

                    <form method="POST" class="space-y-6">
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Sujet de votre demande *
                            </label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   value="<?php echo htmlspecialchars($subject ?? ''); ?>"
                                   placeholder="Ex: Problème de maladie sur mes plants de riz"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   required>
                        </div>

                        <div>
                            <label for="urgency" class="block text-sm font-medium text-gray-700 mb-2">
                                Niveau d'urgence
                            </label>
                            <select id="urgency" 
                                    name="urgency" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="low" <?php echo ($urgency ?? '') === 'low' ? 'selected' : ''; ?>>Faible - Question générale</option>
                                <option value="medium" <?php echo ($urgency ?? '') === 'medium' ? 'selected' : ''; ?>>Moyenne - Problème à résoudre</option>
                                <option value="high" <?php echo ($urgency ?? '') === 'high' ? 'selected' : ''; ?>>Élevée - Urgence agricole</option>
                            </select>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description détaillée *
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="6"
                                      placeholder="Décrivez votre problème en détail. Incluez des informations sur votre localisation, le type de riz cultivé, les symptômes observés, etc."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                      required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Envoyer la demande
                        </button>
                    </form>
                </div>

                <!-- Mes demandes -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        <i class="fas fa-history text-blue-600 mr-2"></i>
                        Mes demandes
                    </h2>

                    <?php if (empty($user_requests)): ?>
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-4"></i>
                            <p>Aucune demande envoyée</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4 max-h-96 overflow-y-auto">
                            <?php foreach ($user_requests as $request): ?>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-medium text-gray-800"><?php echo htmlspecialchars($request['subject']); ?></h3>
                                        <span class="text-xs px-2 py-1 rounded-full
                                            <?php 
                                            switch($request['status']) {
                                                case 'pending': echo 'bg-yellow-100 text-yellow-800'; break;
                                                case 'assigned': echo 'bg-blue-100 text-blue-800'; break;
                                                case 'in_progress': echo 'bg-orange-100 text-orange-800'; break;
                                                case 'completed': echo 'bg-green-100 text-green-800'; break;
                                                case 'cancelled': echo 'bg-red-100 text-red-800'; break;
                                                default: echo 'bg-gray-100 text-gray-800';
                                            }
                                            ?>">
                                            <?php 
                                            switch($request['status']) {
                                                case 'pending': echo 'En attente'; break;
                                                case 'assigned': echo 'Assignée'; break;
                                                case 'in_progress': echo 'En cours'; break;
                                                case 'completed': echo 'Terminée'; break;
                                                case 'cancelled': echo 'Annulée'; break;
                                                default: echo $request['status'];
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-2">
                                        <?php echo htmlspecialchars(substr($request['description'], 0, 100)) . (strlen($request['description']) > 100 ? '...' : ''); ?>
                                    </p>
                                    
                                    <div class="flex justify-between items-center text-xs text-gray-500">
                                        <span>
                                            <i class="fas fa-clock mr-1"></i>
                                            <?php echo date('d/m/Y H:i', strtotime($request['created_at'])); ?>
                                        </span>
                                        <?php if ($request['expert_name']): ?>
                                            <span>
                                                <i class="fas fa-user-tie mr-1"></i>
                                                <?php echo htmlspecialchars($request['expert_name']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($request['response']): ?>
                                        <div class="mt-3 p-3 bg-green-50 rounded-lg">
                                            <p class="text-sm text-green-800">
                                                <strong>Réponse de l'expert:</strong><br>
                                                <?php echo htmlspecialchars($request['response']); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Informations sur les experts -->
            <div class="mt-8 bg-blue-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>
                    À propos de nos experts
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                    <div>
                        <p><strong>Dr. Jean Rakoto</strong> - Spécialiste en agronomie tropicale</p>
                        <p>Expertise: Variétés de riz, fertilisation, gestion des sols</p>
                    </div>
                    <div>
                        <p><strong>Dr. Marie Rasoanaivo</strong> - Phytopathologiste</p>
                        <p>Expertise: Maladies des plantes, lutte biologique, protection des cultures</p>
                    </div>
                </div>
                <p class="mt-4 text-sm text-blue-700">
                    <i class="fas fa-clock mr-1"></i>
                    Temps de réponse moyen: 24-48 heures
                </p>
            </div>
        </div>
    </main>
</body>
</html>
