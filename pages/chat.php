<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Assistant IA spécialisé en riziculture malgache. Conseils personnalisés pour améliorer vos rendements et optimiser votre production de riz.">
    <title>Deep Rice Madagascar</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="maitso.jpg">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0f9ff 100%);
            color: #374151;
            margin: 0;
            padding: 0;
        }
        
        .chat-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #10b981, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .floating-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.5;
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
                opacity: 1;
            }
        }
        
        /* Assurer que le texte est visible */
        h1, h2, h3, h4, h5, h6, p, span, div {
            color: inherit;
        }
        
        /* Styles pour les messages de chat */
        .chat-message {
            color: #374151;
        }
        
        .chat-message p {
            color: #374151;
        }
        
        /* Assurer la visibilité des boutons */
        button {
            color: inherit;
        }
        
        /* Styles pour les cartes */
        .bg-white {
            background-color: white !important;
            color: #374151 !important;
        }
        
        .text-gray-900 {
            color: #111827 !important;
        }
        
        .text-gray-700 {
            color: #374151 !important;
        }
        
        .text-gray-600 {
            color: #4b5563 !important;
        }
        
        .text-gray-500 {
            color: #6b7280 !important;
        }
        
        /* Forcer la visibilité de tous les éléments */
        * {
            color: inherit !important;
        }
        
        /* Styles spécifiques pour les éléments de chat */
        .chat-messages {
            background-color: #f9fafb !important;
        }
        
        .chat-messages .bg-white {
            background-color: white !important;
            color: #374151 !important;
        }
        
        .chat-messages .bg-green-600 {
            background-color: #059669 !important;
            color: white !important;
        }
        
        .chat-messages .text-gray-800 {
            color: #1f2937 !important;
        }
        
        .chat-messages .text-gray-500 {
            color: #6b7280 !important;
        }
        
        .chat-messages .text-green-100 {
            color: #dcfce7 !important;
        }
        
        /* Styles pour les boutons */
        .suggestion-btn {
            background-color: #f0fdf4 !important;
            color: #166534 !important;
        }
        
        .suggestion-btn:hover {
            background-color: #dcfce7 !important;
        }
        
        /* Styles pour les cartes de statistiques */
        .bg-white {
            background-color: white !important;
            color: #374151 !important;
        }
        
        .text-gray-900 {
            color: #111827 !important;
        }
        
        .text-gray-600 {
            color: #4b5563 !important;
        }
        
        /* Assurer que les icônes sont visibles */
        .fas, .fab {
            color: inherit !important;
        }
        
        .text-green-600 {
            color: #059669 !important;
        }
        
        .text-blue-600 {
            color: #2563eb !important;
        }
        
        .text-purple-600 {
            color: #7c3aed !important;
        }
    </style>
</head>
<body class="min-h-screen w-full">
    <?php include 'components/header.php'; ?>
    
    <main class="flex flex-col items-center justify-center pt-20 px-4 min-h-screen relative">
        <!-- Particules flottantes -->
        <div class="floating-particles" id="particles-container"></div>
        
        <div class="flex flex-col items-center max-w-6xl w-full relative z-10">
            <!-- Hero Section -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-6">
                    <i class="fas fa-seedling text-green-600 text-4xl mr-3"></i>
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900">
                        Deep <span class="gradient-text">Rice</span>
                    </h1>
                </div>
                
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-4">
                    Assistant IA Riziculture
                </h2>
                
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Ny manam-pahaizana momba ny fambolena vary malagasy. Makà torohevitra manokana hanatsarana ny vokarinao, manatsara ny famokarana ary mampitombo ny tombony.



                </p>
            </div>

            <!-- Chat Interface -->
            <?php include 'components/chat-form.php'; ?>
        </div>
    </main>

    <script src="assets/js/main.js"></script>
    
    <script>
        // Créer des particules flottantes
        function createFloatingParticles() {
            const container = document.getElementById('particles-container');
            if (!container) return;
            
            for (let i = 0; i < 15; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.width = Math.random() * 4 + 2 + 'px';
                particle.style.height = particle.style.width;
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
                
                container.appendChild(particle);
            }
        }
        
        // Initialiser les particules au chargement
        document.addEventListener('DOMContentLoaded', createFloatingParticles);
    </script><br>
</body>
</html>