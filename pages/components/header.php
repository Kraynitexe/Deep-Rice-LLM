<?php
// Header component pour le projet riziculture Madagascar
?>
<nav class="bg-white shadow-lg fixed w-full top-0 z-50" style="background-color: white !important; color: #374151 !important;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="../index.html" class="flex items-center">
                    <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
                    <span class="text-xl font-bold text-gray-800">Deep Rice</span>
                </a>
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="../index.html#accueil" class="text-gray-600 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                    <a href="../index.html#donnees" class="text-gray-600 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Données</a>
                    <a href="../index.html#graphiques" class="text-gray-600 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Graphiques</a>
                    <a href="../index.html#faq" class="text-gray-600 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">FAQ</a>
                    <a href="chat.php" class="text-green-600 font-semibold px-3 py-2 rounded-md text-sm font-medium transition-colors">Chat IA</a>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Menu utilisateur connecté -->
                        <div class="relative group">
                            <button class="flex items-center text-gray-600 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-user mr-2"></i>
                                <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                                <a href="expert-request.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-tie mr-2"></i>Demander un expert
                                </a>
                                <?php if ($_SESSION['user_type'] === 'expert'): ?>
                                    <a href="expert-dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Tableau de bord
                                    </a>
                                <?php endif; ?>
                                <a href="../auth/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Menu non connecté -->
                        <a href="../auth/login.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-sign-in-alt mr-1"></i>Connexion
                        </a>
                        <a href="../auth/register.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-user-plus mr-1"></i>Inscription
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <button class="md:hidden" id="mobile-menu-button">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
        </div>
        
        <!-- Menu mobile -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                <a href="../index.html#accueil" class="text-gray-600 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Accueil</a>
                <a href="../index.html#donnees" class="text-gray-600 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Données</a>
                <a href="../index.html#graphiques" class="text-gray-600 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Graphiques</a>
                <a href="../index.html#faq" class="text-gray-600 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">FAQ</a>
                <a href="chat.php" class="text-green-600 font-semibold block px-3 py-2 rounded-md text-base font-medium">Chat IA</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Menu utilisateur connecté mobile -->
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <a href="expert-request.php" class="text-gray-600 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-user-tie mr-2"></i>Demander un expert
                        </a>
                        <?php if ($_SESSION['user_type'] === 'expert'): ?>
                            <a href="expert-dashboard.php" class="text-gray-600 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">
                                <i class="fas fa-tachometer-alt mr-2"></i>Tableau de bord
                            </a>
                        <?php endif; ?>
                        <a href="../auth/logout.php" class="text-red-600 hover:text-red-700 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Menu non connecté mobile -->
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <a href="../auth/login.php" class="bg-green-600 hover:bg-green-700 text-white block px-3 py-2 rounded-md text-base font-medium mb-2">
                            <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                        </a>
                        <a href="../auth/register.php" class="bg-blue-600 hover:bg-blue-700 text-white block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-user-plus mr-2"></i>Inscription
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
