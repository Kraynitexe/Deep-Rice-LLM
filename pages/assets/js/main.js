// JavaScript principal pour la page de chat riziculture Madagascar

document.addEventListener('DOMContentLoaded', function() {
    console.log('🌾 Chat riziculture Madagascar chargé');
    
    // Initialisation des composants
    initializeChat();
    initializeMobileMenu();
    initializeSuggestions();
    initializeVoiceInput();
    
    // Gestion du formulaire de chat
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const sendButton = document.getElementById('send-button');
    const typingIndicator = document.getElementById('typing-indicator');
    
    if (chatForm) {
        chatForm.addEventListener('submit', handleChatSubmit);
    }
    
    if (chatInput) {
        chatInput.addEventListener('keypress', handleKeyPress);
        chatInput.addEventListener('input', handleInputChange);
    }
});

// Initialisation du chat
function initializeChat() {
    const chatMessages = document.getElementById('chat-messages');
    if (!chatMessages) return;
    
    // Auto-scroll vers le bas
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Gestion du menu mobile
function initializeMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
}

// Gestion des suggestions rapides
function initializeSuggestions() {
    const suggestionButtons = document.querySelectorAll('.suggestion-btn');
    
    suggestionButtons.forEach(button => {
        button.addEventListener('click', () => {
            const suggestion = button.getAttribute('data-suggestion');
            if (suggestion) {
                sendMessage(suggestion);
            }
        });
    });
}

// Gestion de l'input vocal
function initializeVoiceInput() {
    const voiceButton = document.getElementById('voice-input');
    
    if (voiceButton && 'webkitSpeechRecognition' in window) {
        voiceButton.addEventListener('click', startVoiceRecognition);
    } else if (voiceButton) {
        voiceButton.style.display = 'none';
    }
}

// Démarrer la reconnaissance vocale
function startVoiceRecognition() {
    const recognition = new webkitSpeechRecognition();
    recognition.lang = 'fr-FR';
    recognition.continuous = false;
    recognition.interimResults = false;
    
    const chatInput = document.getElementById('chat-input');
    const voiceButton = document.getElementById('voice-input');
    
    voiceButton.innerHTML = '<i class="fas fa-stop text-red-500"></i>';
    voiceButton.classList.add('animate-pulse');
    
    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        chatInput.value = transcript;
        voiceButton.innerHTML = '<i class="fas fa-microphone"></i>';
        voiceButton.classList.remove('animate-pulse');
    };
    
    recognition.onerror = function(event) {
        console.error('Erreur de reconnaissance vocale:', event.error);
        voiceButton.innerHTML = '<i class="fas fa-microphone"></i>';
        voiceButton.classList.remove('animate-pulse');
    };
    
    recognition.onend = function() {
        voiceButton.innerHTML = '<i class="fas fa-microphone"></i>';
        voiceButton.classList.remove('animate-pulse');
    };
    
    recognition.start();
}

// Gestion de la soumission du formulaire
function handleChatSubmit(e) {
    e.preventDefault();
    
    const chatInput = document.getElementById('chat-input');
    const message = chatInput.value.trim();
    
    if (message) {
        sendMessage(message);
        chatInput.value = '';
    }
}

// Gestion des touches
function handleKeyPress(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        handleChatSubmit(e);
    }
}

// Gestion des changements d'input
function handleInputChange() {
    const chatInput = document.getElementById('chat-input');
    const sendButton = document.getElementById('send-button');
    
    if (sendButton) {
        sendButton.disabled = !chatInput.value.trim();
    }
}

// Envoyer un message
function sendMessage(message) {
    const chatMessages = document.getElementById('chat-messages');
    const typingIndicator = document.getElementById('typing-indicator');
    
    // Ajouter le message de l'utilisateur
    addUserMessage(message);
    
    // Afficher l'indicateur de frappe
    showTypingIndicator();
    
    // Simuler une réponse de l'IA
    setTimeout(() => {
        hideTypingIndicator();
        addBotMessage(generateBotResponse(message));
    }, 1500 + Math.random() * 1000);
}

// Ajouter un message utilisateur
function addUserMessage(message) {
    const chatMessages = document.getElementById('chat-messages');
    
    const messageDiv = document.createElement('div');
    messageDiv.className = 'flex items-start space-x-3 justify-end';
    
    messageDiv.innerHTML = `
        <div class="bg-green-600 text-white rounded-lg p-4 max-w-xs">
            <p class="text-sm">${escapeHtml(message)}</p>
            <span class="text-xs text-green-100 mt-1 block">Maintenant</span>
        </div>
        <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-user text-white text-sm"></i>
        </div>
    `;
    
    chatMessages.appendChild(messageDiv);
    scrollToBottom();
}

// Ajouter un message du bot
function addBotMessage(message) {
    const chatMessages = document.getElementById('chat-messages');
    
    const messageDiv = document.createElement('div');
    messageDiv.className = 'flex items-start space-x-3';
    
    messageDiv.innerHTML = `
        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-robot text-white text-sm"></i>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm max-w-xs">
            <p class="text-gray-800 text-sm">${escapeHtml(message)}</p>
            <span class="text-xs text-gray-500 mt-1 block">Maintenant</span>
        </div>
    `;
    
    chatMessages.appendChild(messageDiv);
    scrollToBottom();
}

// Afficher l'indicateur de frappe
function showTypingIndicator() {
    const typingIndicator = document.getElementById('typing-indicator');
    if (typingIndicator) {
        typingIndicator.classList.remove('hidden');
        scrollToBottom();
    }
}

// Masquer l'indicateur de frappe
function hideTypingIndicator() {
    const typingIndicator = document.getElementById('typing-indicator');
    if (typingIndicator) {
        typingIndicator.classList.add('hidden');
    }
}

// Générer une réponse du bot
function generateBotResponse(userMessage) {
    const responses = {
        'rendement': [
            "Pour améliorer votre rendement de riz, je recommande d'optimiser l'irrigation, d'utiliser des variétés adaptées au climat malgache, et d'appliquer une fertilisation équilibrée. Le rendement moyen à Madagascar est de 3.05 t/ha, mais peut atteindre 6-8 t/ha avec de bonnes pratiques.",
            "L'amélioration du rendement passe par plusieurs facteurs : choix des semences, gestion de l'eau, fertilisation NPK équilibrée, et lutte contre les maladies. Consultez les données météo locales pour optimiser vos interventions."
        ],
        'semis': [
            "Les meilleures périodes de semis à Madagascar varient selon les régions. Dans les Hauts Plateaux, semez de novembre à janvier. Sur la côte est, de décembre à février. Évitez les périodes de forte pluviométrie.",
            "Le calendrier des semis dépend de votre zone géographique. Consultez les prévisions météo et préparez vos parcelles 2-3 semaines avant le semis pour une meilleure germination."
        ],
        'irrigation': [
            "Pour l'irrigation du riz, maintenez une hauteur d'eau de 5-10 cm pendant la croissance végétative. Réduisez l'eau 2 semaines avant la récolte. L'irrigation par aspersion est plus efficace que l'inondation continue.",
            "Gérez l'irrigation selon les stades : 2-3 cm après repiquage, 5-10 cm pendant la croissance, et assèchement progressif avant récolte. Surveillez l'évapotranspiration locale."
        ],
        'engrais': [
            "Pour le riz, utilisez un engrais NPK 15-15-15 à la plantation, puis un engrais azoté (urée) en 2-3 apports. Dose recommandée : 100-150 kg/ha d'NPK + 50-80 kg/ha d'urée.",
            "La fertilisation du riz nécessite un apport équilibré. Appliquez 60% de l'azote à la plantation, 30% au tallage, et 10% à l'épiaison. Surveillez les carences en phosphore et potassium."
        ],
        'maladie': [
            "Les principales maladies du riz à Madagascar sont la pyriculariose, l'helminthosporiose et la bactériose. Utilisez des variétés résistantes et des fongicides préventifs. Surveillez l'hygrométrie.",
            "Pour lutter contre les maladies, pratiquez la rotation des cultures, évitez l'excès d'azote, et traitez préventivement avec des fongicides systémiques. Consultez un agronome local."
        ],
        'prix': [
            "Les prix du riz varient selon la qualité et la saison. Le riz de qualité supérieure se vend 2000-3000 Ar/kg, le riz standard 1500-2000 Ar/kg. Surveillez les marchés locaux et régionaux.",
            "Pour optimiser vos revenus, diversifiez vos variétés, améliorez la qualité post-récolte, et explorez les circuits de commercialisation directs. Le riz parfumé a une meilleure valeur ajoutée."
        ]
    };
    
    const message = userMessage.toLowerCase();
    
    // Recherche de mots-clés
    for (const [keyword, responseList] of Object.entries(responses)) {
        if (message.includes(keyword)) {
            return responseList[Math.floor(Math.random() * responseList.length)];
        }
    }
    
    // Réponse par défaut
    const defaultResponses = [
        "Je comprends votre question sur la riziculture. Pouvez-vous être plus spécifique ? Je peux vous aider avec les semis, l'irrigation, la fertilisation, les maladies, ou l'amélioration des rendements.",
        "Excellente question ! Pour vous donner la meilleure réponse, précisez votre zone géographique et le stade de votre culture. Je suis spécialisé dans l'agriculture malgache.",
        "Je suis là pour vous accompagner dans votre projet rizicole. N'hésitez pas à me poser des questions sur les techniques culturales, la gestion des intrants, ou l'optimisation de vos rendements."
    ];
    
    return defaultResponses[Math.floor(Math.random() * defaultResponses.length)];
}

// Échapper le HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Faire défiler vers le bas
function scrollToBottom() {
    const chatMessages = document.getElementById('chat-messages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

// Gestion des erreurs
window.addEventListener('error', function(e) {
    console.error('Erreur JavaScript:', e.error);
});

// Export des fonctions pour utilisation externe
window.ChatApp = {
    sendMessage,
    addUserMessage,
    addBotMessage,
    generateBotResponse
};
