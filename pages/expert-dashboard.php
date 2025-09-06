<?php
// Tableau de bord expert pour le projet riziculture Madagascar
session_start();
require_once '../config/database.php';

// Vérifier si l'utilisateur est connecté et est un expert
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'expert') {
    header('Location: ../auth/login.php');
    exit();
}

$success_message = '';
$error_message = '';

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $request_id = $_POST['request_id'] ?? '';
    
    try {
        $conn = getDBConnection();
        
        switch ($action) {
            case 'assign':
                $stmt = $conn->prepare("UPDATE expert_requests SET status = 'assigned', assigned_expert_id = ? WHERE id = ?");
                $stmt->execute([$_SESSION['user_id'], $request_id]);
                $success_message = 'Demande assignée avec succès.';
                break;
                
            case 'start':
                $stmt = $conn->prepare("UPDATE expert_requests SET status = 'in_progress' WHERE id = ? AND assigned_expert_id = ?");
                $stmt->execute([$request_id, $_SESSION['user_id']]);
                $success_message = 'Demande mise en cours.';
                break;
                
            case 'complete':
                $response = trim($_POST['response'] ?? '');
                if (empty($response)) {
                    $error_message = 'Veuillez fournir une réponse.';
                } else {
                    $stmt = $conn->prepare("UPDATE expert_requests SET status = 'completed', response = ? WHERE id = ? AND assigned_expert_id = ?");
                    $stmt->execute([$response, $request_id, $_SESSION['user_id']]);
                    $success_message = 'Demande terminée avec succès.';
                }
                break;
        }
    } catch (Exception $e) {
        $error_message = 'Erreur lors du traitement de la demande.';
    }
}

// Récupérer les demandes
$all_requests = [];
$my_requests = [];

try {
    $conn = getDBConnection();
    
    // Toutes les demandes
    $stmt = $conn->prepare("
        SELECT er.*, u.full_name as user_name, u.location as user_location
        FROM expert_requests er 
        JOIN users u ON er.user_id = u.id 
        ORDER BY er.created_at DESC
    ");
    $stmt->execute();
    $all_requests = $stmt->fetchAll();
    
    // Mes demandes assignées
    $stmt = $conn->prepare("
        SELECT er.*, u.full_name as user_name, u.location as user_location
        FROM expert_requests er 
        JOIN users u ON er.user_id = u.id 
        WHERE er.assigned_expert_id = ?
        ORDER BY er.created_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $my_requests = $stmt->fetchAll();
} catch (Exception $e) {
    $error_message = 'Erreur lors du chargement des demandes.';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Expert - Deep Rice Madagascar</title>
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
        <div class="max-w-7xl mx-auto">
            <!-- En-tête -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-user-tie text-green-600 mr-3"></i>
                    Tableau de bord Expert
                </h1>
                <p class="text-lg text-gray-600">
                    Bienvenue, <?php echo htmlspecialchars($_SESSION['full_name']); ?> ! Gérez les demandes d'aide des agriculteurs.
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

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">En attente</p>
                            <p class="text-2xl font-bold text-gray-900">
                                <?php echo count(array_filter($all_requests, fn($r) => $r['status'] === 'pending')); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-user-check text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Assignées</p>
                            <p class="text-2xl font-bold text-gray-900">
                                <?php echo count(array_filter($all_requests, fn($r) => $r['status'] === 'assigned')); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-tasks text-orange-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">En cours</p>
                            <p class="text-2xl font-bold text-gray-900">
                                <?php echo count(array_filter($all_requests, fn($r) => $r['status'] === 'in_progress')); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Terminées</p>
                            <p class="text-2xl font-bold text-gray-900">
                                <?php echo count(array_filter($all_requests, fn($r) => $r['status'] === 'completed')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Toutes les demandes -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        <i class="fas fa-list text-blue-600 mr-2"></i>
                        Toutes les demandes
                    </h2>

                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        <?php foreach ($all_requests as $request): ?>
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
                                    <strong>Demandeur:</strong> <?php echo htmlspecialchars($request['user_name']); ?>
                                    <?php if ($request['user_location']): ?>
                                        - <?php echo htmlspecialchars($request['user_location']); ?>
                                    <?php endif; ?>
                                </p>
                                
                                <p class="text-sm text-gray-600 mb-3">
                                    <?php echo htmlspecialchars(substr($request['description'], 0, 150)) . (strlen($request['description']) > 150 ? '...' : ''); ?>
                                </p>
                                
                                <div class="flex justify-between items-center text-xs text-gray-500 mb-3">
                                    <span>
                                        <i class="fas fa-clock mr-1"></i>
                                        <?php echo date('d/m/Y H:i', strtotime($request['created_at'])); ?>
                                    </span>
                                    <span class="px-2 py-1 rounded
                                        <?php 
                                        switch($request['urgency']) {
                                            case 'low': echo 'bg-green-100 text-green-800'; break;
                                            case 'medium': echo 'bg-yellow-100 text-yellow-800'; break;
                                            case 'high': echo 'bg-red-100 text-red-800'; break;
                                        }
                                        ?>">
                                        <?php 
                                        switch($request['urgency']) {
                                            case 'low': echo 'Faible'; break;
                                            case 'medium': echo 'Moyenne'; break;
                                            case 'high': echo 'Élevée'; break;
                                        }
                                        ?>
                                    </span>
                                </div>

                                <?php if ($request['status'] === 'pending'): ?>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="action" value="assign">
                                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                            <i class="fas fa-hand-paper mr-1"></i>
                                            S'assigner
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Mes demandes -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        <i class="fas fa-user-check text-green-600 mr-2"></i>
                        Mes demandes assignées
                    </h2>

                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        <?php if (empty($my_requests)): ?>
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p>Aucune demande assignée</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($my_requests as $request): ?>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-medium text-gray-800"><?php echo htmlspecialchars($request['subject']); ?></h3>
                                        <span class="text-xs px-2 py-1 rounded-full
                                            <?php 
                                            switch($request['status']) {
                                                case 'assigned': echo 'bg-blue-100 text-blue-800'; break;
                                                case 'in_progress': echo 'bg-orange-100 text-orange-800'; break;
                                                case 'completed': echo 'bg-green-100 text-green-800'; break;
                                                default: echo 'bg-gray-100 text-gray-800';
                                            }
                                            ?>">
                                            <?php 
                                            switch($request['status']) {
                                                case 'assigned': echo 'Assignée'; break;
                                                case 'in_progress': echo 'En cours'; break;
                                                case 'completed': echo 'Terminée'; break;
                                                default: echo $request['status'];
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-2">
                                        <strong>Demandeur:</strong> <?php echo htmlspecialchars($request['user_name']); ?>
                                    </p>
                                    
                                    <p class="text-sm text-gray-600 mb-3">
                                        <?php echo htmlspecialchars(substr($request['description'], 0, 100)) . (strlen($request['description']) > 100 ? '...' : ''); ?>
                                    </p>

                                    <?php if ($request['status'] === 'assigned'): ?>
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="action" value="start">
                                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-3 py-1 rounded text-sm mr-2">
                                                <i class="fas fa-play mr-1"></i>
                                                Commencer
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ($request['status'] === 'in_progress'): ?>
                                        <form method="POST" class="mt-3">
                                            <input type="hidden" name="action" value="complete">
                                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                            <div class="mb-2">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Réponse:</label>
                                                <textarea name="response" 
                                                          rows="3" 
                                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                                          placeholder="Votre réponse à l'agriculteur..."
                                                          required></textarea>
                                            </div>
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                <i class="fas fa-check mr-1"></i>
                                                Terminer
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ($request['response']): ?>
                                        <div class="mt-3 p-3 bg-green-50 rounded-lg">
                                            <p class="text-sm text-green-800">
                                                <strong>Votre réponse:</strong><br>
                                                <?php echo htmlspecialchars($request['response']); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
