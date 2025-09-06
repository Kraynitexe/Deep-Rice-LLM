// Script principal pour le site riziculture Madagascar
// Gestion des animations, graphiques et interactions

document.addEventListener('DOMContentLoaded', function() {
    console.log('🌾 Site riziculture Madagascar chargé');
    
    // Initialisation des composants
    initializeDataCards();
    initializeCharts();
    initializeFAQ();
    initializeMap();
    initializeAnimations();
    initializeScrollEffects();
    initializeNavigation();
    
    // Gestion du CTA button
    const ctaButton = document.getElementById('cta-button');
    if (ctaButton) {
        ctaButton.addEventListener('click', function() {
            document.getElementById('donnees').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        });
    }
});

// Initialisation des cartes de données avec animations
function initializeDataCards() {
    const dataCards = document.querySelectorAll('.data-card');
    
    // Animation des cartes au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    animateCardNumbers(entry.target);
                }, index * 200);
            }
        });
    }, { threshold: 0.1 });
    
    dataCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });
}

// Animation des chiffres dans les cartes
function animateCardNumbers(card) {
    const numberElement = card.querySelector('.text-4xl');
    if (!numberElement) return;
    
    const targetValue = getCardValue(card);
    if (targetValue === null) return;
    
    animateNumber(numberElement, 0, targetValue, 2000);
}

// Récupération de la valeur cible selon l'ID de la carte
function getCardValue(card) {
    const cardId = card.querySelector('[id]')?.id;
    if (!cardId) return null;
    
    switch (cardId) {
        case 'production-madagascar':
            return rizicultureData.production.madagascar.value;
        case 'rendement-madagascar':
            return rizicultureData.rendement.madagascar.value;
        case 'production-mondiale':
            return rizicultureData.production.mondiale.value;
        case 'production-chine':
            return rizicultureData.production.chine.value;
        case 'projection-fao':
            return rizicultureData.production.projection_fao.value;
        case 'part-madagascar':
            return parseFloat(rizicultureData.calculs.partMadagascar());
        default:
            return null;
    }
}

// Animation des nombres
function animateNumber(element, start, end, duration) {
    const startTime = performance.now();
    const isDecimal = end % 1 !== 0;
    
    function updateNumber(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        // Easing function (ease-out)
        const easeOut = 1 - Math.pow(1 - progress, 3);
        const current = start + (end - start) * easeOut;
        
        if (isDecimal) {
            element.textContent = current.toFixed(2);
        } else {
            element.textContent = Math.floor(current);
        }
        
        if (progress < 1) {
            requestAnimationFrame(updateNumber);
        } else {
            element.textContent = isDecimal ? end.toFixed(2) : end.toString();
        }
    }
    
    requestAnimationFrame(updateNumber);
}

// Initialisation des graphiques Chart.js
function initializeCharts() {
    // Bar Chart Comparatif
    const barCtx = document.getElementById('barChart');
    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: rizicultureData.charts.barChart,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' millions de tonnes';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + ' Mt';
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }
    
    // Line Chart Évolution
    const lineCtx = document.getElementById('lineChart');
    if (lineCtx) {
        new Chart(lineCtx, {
            type: 'line',
            data: rizicultureData.charts.lineChart,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' millions de tonnes';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 500,
                        ticks: {
                            callback: function(value) {
                                return value + ' Mt';
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }
}

// Initialisation de la FAQ avec accordéons
function initializeFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const icon = item.querySelector('.faq-icon');
        
        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Fermer tous les autres items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.faq-answer').classList.add('hidden');
                    otherItem.querySelector('.faq-icon').style.transform = 'rotate(0deg)';
                }
            });
            
            // Toggle l'item actuel
            if (isActive) {
                item.classList.remove('active');
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            } else {
                item.classList.add('active');
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
}

// Initialisation de la carte de Madagascar
function initializeMap() {
    const mapContainer = document.getElementById('madagascar-map');
    if (!mapContainer) return;
    
    // SVG de Madagascar simplifié
    const madagascarSVG = `
        <svg class="madagascar-svg" viewBox="0 0 400 600" xmlns="http://www.w3.org/2000/svg">
            <!-- Contour principal de Madagascar -->
            <path d="M200 50 L350 100 L380 200 L360 300 L340 400 L300 500 L250 550 L200 580 L150 550 L100 500 L60 400 L40 300 L60 200 L100 100 L150 50 Z" 
                  fill="#e5e7eb" 
                  stroke="#374151" 
                  stroke-width="2"/>
            
            <!-- Zones rizicoles -->
            <g class="zones-rizicoles">
                <!-- Hauts Plateaux -->
                <circle cx="200" cy="200" r="40" 
                        class="zone-rizicole" 
                        data-zone="hauts-plateaux"
                        fill="#10b981" 
                        opacity="0.7"/>
                
                <!-- Côte Est -->
                <ellipse cx="280" cy="250" rx="30" ry="60" 
                         class="zone-rizicole" 
                         data-zone="cote-est"
                         fill="#10b981" 
                         opacity="0.7"/>
                
                <!-- Côte Ouest -->
                <ellipse cx="120" cy="300" rx="25" ry="50" 
                         class="zone-rizicole" 
                         data-zone="cote-ouest"
                         fill="#10b981" 
                         opacity="0.7"/>
                
                <!-- Sud -->
                <circle cx="180" cy="450" r="25" 
                        class="zone-rizicole" 
                        data-zone="sud"
                        fill="#10b981" 
                        opacity="0.7"/>
            </g>
            
            <!-- Légende -->
            <g class="legende" transform="translate(20, 20)">
                <rect x="0" y="0" width="120" height="100" fill="white" stroke="#e5e7eb" rx="5"/>
                <text x="10" y="20" font-size="12" font-weight="bold">Zones Rizicoles</text>
                <circle cx="15" cy="35" r="8" fill="#10b981" opacity="0.7"/>
                <text x="30" y="40" font-size="10">Hauts Plateaux (41%)</text>
                <circle cx="15" cy="50" r="8" fill="#10b981" opacity="0.7"/>
                <text x="30" y="55" font-size="10">Côte Est (35%)</text>
                <circle cx="15" cy="65" r="8" fill="#10b981" opacity="0.7"/>
                <text x="30" y="70" font-size="10">Côte Ouest (18%)</text>
                <circle cx="15" cy="80" r="8" fill="#10b981" opacity="0.7"/>
                <text x="30" y="85" font-size="10">Sud (6%)</text>
            </g>
        </svg>
    `;
    
    mapContainer.innerHTML = madagascarSVG;
    
    // Ajout des interactions
    const zones = mapContainer.querySelectorAll('.zone-rizicole');
    const tooltip = createTooltip();
    
    zones.forEach(zone => {
        zone.addEventListener('mouseenter', (e) => {
            const zoneId = e.target.getAttribute('data-zone');
            const zoneData = rizicultureData.zonesRizicoles.find(z => z.id === zoneId);
            
            if (zoneData) {
                showTooltip(tooltip, e, zoneData);
            }
        });
        
        zone.addEventListener('mouseleave', () => {
            hideTooltip(tooltip);
        });
        
        zone.addEventListener('click', (e) => {
            const zoneId = e.target.getAttribute('data-zone');
            highlightZone(zoneId);
        });
    });
}

// Création du tooltip pour la carte
function createTooltip() {
    const tooltip = document.createElement('div');
    tooltip.className = 'map-tooltip';
    document.body.appendChild(tooltip);
    return tooltip;
}

// Affichage du tooltip
function showTooltip(tooltip, event, zoneData) {
    tooltip.innerHTML = `
        <strong>${zoneData.nom}</strong><br>
        Région: ${zoneData.region}<br>
        Production: ${zoneData.production} Mt (${zoneData.pourcentage})<br>
        <em>${zoneData.description}</em>
    `;
    
    tooltip.style.left = event.pageX + 10 + 'px';
    tooltip.style.top = event.pageY - 10 + 'px';
    tooltip.classList.add('show');
}

// Masquage du tooltip
function hideTooltip(tooltip) {
    tooltip.classList.remove('show');
}

// Mise en surbrillance d'une zone
function highlightZone(zoneId) {
    const zones = document.querySelectorAll('.zone-rizicole');
    zones.forEach(zone => {
        zone.classList.remove('active');
        if (zone.getAttribute('data-zone') === zoneId) {
            zone.classList.add('active');
        }
    });
}

// Initialisation des animations
function initializeAnimations() {
    // Animation des particules dans le hero
    createParticles();
    
    // Animation du titre principal
    animateTitle();
}

// Création des particules flottantes
function createParticles() {
    const hero = document.querySelector('#accueil');
    if (!hero) return;
    
    for (let i = 0; i < 20; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.width = Math.random() * 4 + 2 + 'px';
        particle.style.height = particle.style.width;
        particle.style.animationDelay = Math.random() * 6 + 's';
        particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
        
        hero.appendChild(particle);
    }
}

// Animation du titre principal
function animateTitle() {
    const title = document.querySelector('.hero-title');
    if (!title) return;
    
    const text = title.textContent;
    title.textContent = '';
    
    let i = 0;
    const typeWriter = () => {
        if (i < text.length) {
            title.textContent += text.charAt(i);
            i++;
            setTimeout(typeWriter, 50);
        }
    };
    
    setTimeout(typeWriter, 1000);
}

// Initialisation de la navigation
function initializeNavigation() {
    const navbar = document.querySelector('.navbar');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Smooth scroll pour les liens de navigation
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const offsetTop = targetSection.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Gestion du menu mobile
    const hamburger = document.querySelector('.md\\:hidden button');
    const navMenu = document.querySelector('.hidden.md\\:block');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            navMenu.classList.toggle('hidden');
            navMenu.classList.toggle('block');
        });
    }
}

// Effets de scroll
function initializeScrollEffects() {
    // Navbar transparente au scroll
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    
    // Animation des éléments au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);
    
    // Observer les sections
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        observer.observe(section);
    });
}

// Fonction utilitaire pour le smooth scroll
function smoothScrollTo(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Gestion des erreurs
window.addEventListener('error', function(e) {
    console.error('Erreur JavaScript:', e.error);
});

// Export des fonctions pour utilisation externe
window.RizicultureApp = {
    smoothScrollTo,
    highlightZone,
    formatNumber: (number, decimals = 1) => {
        return new Intl.NumberFormat('fr-FR', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        }).format(number);
    }
};
