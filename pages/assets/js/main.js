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
            <p class="text-sm text-white">${escapeHtml(message)}</p>
            <span class="text-xs text-white mt-1 block">Maintenant</span>
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
            <p class="text-white text-sm">${escapeHtml(message)}</p>
            <span class="text-xs text-white mt-1 block">Maintenant</span>
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
            "Mba hampitomboana ny vokatra vary dia manoro hevitra aho ny hanatsarana ny rafitra famafazana rano (irrigation), ny hampiasana karazana vary mifanaraka amin’ny toetrandro eto Madagasikara, ary ny hanatanterahana famokarana zezika voalanjalanja. Ny vokatra antonony eto Madagasikara dia 3,05 t/ha, saingy mety hahatratra 6–8 t/ha raha mampiasa fomba fambolena tsara.",
            "Ny fampitomboana ny vokatra dia miankina amin’ny antony maro: ny safidin’ny masomboly, ny fitantanana ny rano, ny fampiasana zezika NPK voalanjalanja, ary ny ady amin’ny aretina. Jereo hatrany ny toetry ny andro eo an-toerana mba hahafahanao manatsara ny asa ataonao."
        ],
        'semis': [
            "Ny fotoan-dehibe indrindra amin’ny famafazana vary eto Madagasikara dia miovaova arakaraka ny faritra. Any amin’ny Faritra Avaratra-Andrefana (Hauts Plateaux), ny fotoana tsara indrindra dia manomboka amin’ny volana Novambra ka hatramin’ny Janoary. Any amin’ny morontsiraka atsinanana kosa dia manomboka amin’ny volana Desambra ka hatramin’ny Febroary. Aza mifidy fotoana ahitana rotsakorana be loatra.",
            "Miankina amin’ny faritra misy anao ny fandaharam-potoanan’ny famafazana. Jereo ny vinavinan’ny toetry ny andro, ary amboary mialoha 2–3 herinandro ny tanimbary mba hahazoana fitrebona tsara ny voa."
        ],
        'irrigation': [
            "Ho an’ny famafazana rano amin’ny vary, tazomy eo anelanelan’ny 5–10 sm ny haavon’ny rano mandritra ny fitomboan’ny zavamaniry. Ahenao ny rano 2 herinandro alohan’ny fijinjana. Mahomby kokoa ny famafazana rano amin’ny alalan’ny fanaparitahana (aspersion) noho ny fitazonana rano mandavantaona (inondation continue).",
            "Tantano araka ny dingana ny famafazana rano: 2–3 sm aorian’ny famindram-boaloboka, 5–10 sm mandritra ny fitomboana, ary avela hihintsana tsikelikely ny rano alohan’ny fijinjana. Araho maso koa ny fahaverezan-drano amin’ny alalan’ny etona sy ny fitrohana (evapotranspiration) eo an-toerana."
        ],
        'engrais': [
            "Ho an’ny vary, ampiasao zezika NPK 15-15-15 rehefa mamafy na mananika. Avy eo ampio zezika misy azota (urée) amin’ny fizarana 2–3. Ny fatra soso-kevitra dia 100–150 kg/ha ho an’ny NPK ary 50–80 kg/ha ho an’ny urée.",
            "Ny zezika ho an’ny vary dia mila fandanjalanjana tsara. Omeo 60% ny azota amin’ny famafazana, 30% amin’ny fitrebona (tallage), ary 10% amin’ny fotoanan’ny fivoahan’ny voninkazo (épiaison). Araho maso koa sao misy tsy fahampian’ny fosfora sy potasioma."
        ],
        'maladie': [
            "Ny aretina lehibe amin’ny vary eto Madagasikara dia ny pyriculariose, ny helminthosporiose, ary ny bactériose. Ampiasao karazana vary mahatohitra aretina ary mampiasà fanafody manohitra holatra (fongicides) mialoha. Araho maso ihany koa ny hamandoana (hygrométrie).",
            "Mba hiadiana amin’ny aretina, manao fihodinana fambolena (rotation des cultures), aza be loatra ny azota, ary asio fanafody manohitra holatra (fongicides systémiques) mialoha. Miresaha amin’ny mpamboly na agronoma eo an-toerana."
        ],
        'prix': [
            "Miovaova arakaraka ny kalitao sy ny vanim-potoana ny vidin’ny vary. Ny vary tsara kalitao dia amidy 2 000–3 000 Ar/kg, ary ny vary mahazatra 1 500–2 000 Ar/kg. Araho maso ny tsena eo an-toerana sy ny faritra.",
            "Mba hampitomboana ny vola miditra, ampiasao karazana vary samihafa, hatsaraina ny kalitaon’ny vary aorian’ny fijinjana, ary diniho ny fivarotana mivantana. Ny vary misy hanitra (riz parfumé) dia mitondra tombony lehibe kokoa."
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
        "Azoko ny fanontanianao momba ny fambolena vary. Azonao ve ny manazava bebe kokoa? Afaka manampy anao aho momba ny famafazana, ny famatsian-drano, ny zezika, ny aretina, na ny fanatsarana ny vokatra.",
        "Fanontaniana tsara! Mba hahazoako manome valiny tsara indrindra dia lazao ny faritra misy anao sy ny dingan’ny fambolena misy anao. Manam-pahaizana manokana momba ny fambolena eto Madagasikara aho.",
        "Eto aho hanampy anao amin’ny tetikasa fambolena vary ataonao. Aza misalasala manontany momba ny teknikan’ny fambolena, ny fitantanana ny akora ilaina, na ny fanatsarana ny vokatra."
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
