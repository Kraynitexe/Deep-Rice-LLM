<?php
// Chat form component pour le projet riziculture Madagascar
?>
<div class="w-full max-w-4xl">
    <!-- Chat Container -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden" style="background-color: white !important; color: #374151 !important;">
        <!-- Chat Header -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-robot text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg">Assistant IA Riziculture</h3>
                    <p class="text-green-100 text-sm">Spécialisé dans l'agriculture malgache</p>
                </div>
                <div class="ml-auto">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 bg-green-300 rounded-full animate-pulse"></div>
                        <div class="w-3 h-3 bg-green-300 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                        <div class="w-3 h-3 bg-green-300 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Messages Area -->
        <div id="chat-messages" class="h-96 overflow-y-auto p-6 space-y-4 bg-gray-50">
            <!-- Message de bienvenue -->
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot text-white text-sm"></i>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm max-w-xs">
                    <p class="text-gray-800">Bonjour ! Je suis votre assistant IA spécialisé en riziculture à Madagascar. Comment puis-je vous aider aujourd'hui ?</p>
                    <span class="text-xs text-gray-500 mt-1 block">Maintenant</span>
                </div>
            </div>

            <!-- Suggestions rapides -->
            <div class="flex flex-wrap gap-2 mt-4">
                <button class="suggestion-btn bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1 rounded-full text-sm transition-colors" data-suggestion="Comment améliorer mon rendement de riz ?">
                    <i class="fas fa-chart-line mr-1"></i>
                    Améliorer le rendement
                </button>
                <button class="suggestion-btn bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-full text-sm transition-colors" data-suggestion="Quels sont les meilleurs moments pour semer ?">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Calendrier des semis
                </button>
                <button class="suggestion-btn bg-purple-100 hover:bg-purple-200 text-purple-700 px-3 py-1 rounded-full text-sm transition-colors" data-suggestion="Comment gérer l'irrigation de mes rizières ?">
                    <i class="fas fa-tint mr-1"></i>
                    Gestion irrigation
                </button>
                <button class="suggestion-btn bg-orange-100 hover:bg-orange-200 text-orange-700 px-3 py-1 rounded-full text-sm transition-colors" data-suggestion="Quels engrais utiliser pour le riz ?">
                    <i class="fas fa-seedling mr-1"></i>
                    Fertilisation
                </button>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="expert-request.php" class="suggestion-btn bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded-full text-sm transition-colors">
                        <i class="fas fa-user-tie mr-1"></i>
                        Demander un expert
                    </a>
                <?php else: ?>
                    <a href="../auth/login.php" class="suggestion-btn bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded-full text-sm transition-colors">
                        <i class="fas fa-user-tie mr-1"></i>
                        Demander un expert
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Chat Input Area -->
        <div class="bg-white border-t border-gray-200 p-4">
            <form id="chat-form" class="flex space-x-3">
                <div class="flex-1 relative">
                    <input 
                        type="text" 
                        id="chat-input" 
                        placeholder="Posez votre question sur la riziculture..." 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"
                        autocomplete="off"
                    >
                    <button type="button" id="voice-input" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-green-600 transition-colors">
                        <i class="fas fa-microphone"></i>
                    </button>
                </div>
                <button 
                    type="submit" 
                    id="send-button"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2"
                >
                    <i class="fas fa-paper-plane"></i>
                    <span class="hidden sm:inline">Envoyer</span>
                </button>
            </form>
            
            <!-- Typing indicator -->
            <div id="typing-indicator" class="hidden mt-2">
                <div class="flex items-center space-x-2 text-gray-500">
                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-robot text-white text-xs"></i>
                    </div>
                    <span class="text-sm">L'assistant tape...</span>
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-chart-bar text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Rendement moyen</p>
                    <p class="text-lg font-semibold text-gray-900">3.05 t/ha</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-globe text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Production Madagascar</p>
                    <p class="text-lg font-semibold text-gray-900">5.12 Mt</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-robot text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Conseils IA</p>
                    <p class="text-lg font-semibold text-gray-900">24/7</p>
                </div>
            </div>
        </div>
    </div>
</div>
