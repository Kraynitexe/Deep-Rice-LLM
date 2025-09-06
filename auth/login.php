<?php
// Système de connexion pour le projet riziculture Madagascar
session_start();
require_once '../config/database.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error_message = 'Veuillez remplir tous les champs.';
    } else {
        try {
            $conn = getDBConnection();
            
            // Rechercher l'utilisateur
            $stmt = $conn->prepare("SELECT id, username, email, password_hash, full_name, user_type FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                // Connexion réussie
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['user_type'] = $user['user_type'];
                
                // Créer un token de session
                $session_token = bin2hex(random_bytes(32));
                $expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));
                
                $stmt = $conn->prepare("INSERT INTO user_sessions (user_id, session_token, expires_at) VALUES (?, ?, ?)");
                $stmt->execute([$user['id'], $session_token, $expires_at]);
                
                $_SESSION['session_token'] = $session_token;
                
                // Redirection selon le type d'utilisateur
                if ($user['user_type'] === 'expert') {
                    header('Location: ../pages/expert-dashboard.php');
                } else {
                    header('Location: ../pages/chat.php');
                }
                exit();
            } else {
                $error_message = 'Nom d\'utilisateur ou mot de passe incorrect.';
            }
        } catch (Exception $e) {
            $error_message = 'Erreur de connexion. Veuillez réessayer.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Deep Rice Madagascar</title>
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
<body class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <!-- Logo et titre -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-seedling text-green-600 text-4xl mr-3"></i>
                <h1 class="text-3xl font-bold text-gray-900">
                    Deep <span class="gradient-text">Rice</span>
                </h1>
            </div>
            <h2 class="text-xl text-gray-600">Connexion à votre compte</h2>
        </div>

        <!-- Formulaire de connexion -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <?php if ($error_message): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2"></i>Nom d'utilisateur ou Email
                    </label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           value="<?php echo htmlspecialchars($username ?? ''); ?>"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2"></i>Mot de passe
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           required>
                </div>

                <button type="submit" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Se connecter
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Pas encore de compte ? 
                    <a href="register.php" class="text-green-600 hover:text-green-700 font-medium">
                        Créer un compte
                    </a>
                </p>
            </div>

            <div class="mt-4 text-center">
                <a href="../index.html" class="text-gray-500 hover:text-gray-700 text-sm">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>

        <!-- Comptes de démonstration -->
        <div class="mt-6 bg-blue-50 rounded-lg p-4">
            <h3 class="text-sm font-medium text-blue-900 mb-2">
                <i class="fas fa-info-circle mr-1"></i>
                Comptes de démonstration
            </h3>
            <div class="text-xs text-blue-700 space-y-1">
                <div><strong>Agriculteur:</strong> farmer / password</div>
                <div><strong>Expert:</strong> expert1 / password</div>
                <div><strong>Admin:</strong> admin / password</div>
            </div>
        </div>
    </div>
</body>
</html>
