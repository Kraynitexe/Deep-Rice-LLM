// Navigation mobile
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const navActions = document.querySelector('.nav-actions');

    if (hamburger) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
            navActions.classList.toggle('active');
        });
    }

    // Smooth scrolling pour les liens de navigation
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const offsetTop = targetSection.offsetTop - 80; // Ajuster pour la navbar fixe
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Changement de style de la navbar au scroll
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            navbar.style.boxShadow = '0 4px 6px -1px rgb(0 0 0 / 0.1)';
        } else {
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            navbar.style.boxShadow = 'none';
        }
    });

    // Animations au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observer les éléments à animer
    const animateElements = document.querySelectorAll('.feature-card, .pricing-card, .solution-content');
    animateElements.forEach(el => {
        el.classList.add('scroll-animate');
        observer.observe(el);
    });

    // Gestion des onglets des solutions
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Retirer la classe active de tous les boutons et panneaux
            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.classList.remove('active'));
            
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            // Afficher le panneau correspondant
            const targetPanel = document.getElementById(targetTab);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        });
    });

    // Animation des métriques du dashboard
    const metricValues = document.querySelectorAll('.metric-value');
    const animateNumbers = (element, targetValue, duration = 2000) => {
        const startValue = 0;
        const increment = targetValue / (duration / 16);
        let currentValue = startValue;
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= targetValue) {
                currentValue = targetValue;
                clearInterval(timer);
            }
            element.textContent = currentValue.toFixed(1);
        }, 16);
    };

    // Observer pour les métriques
    const metricObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const metricValue = entry.target.querySelector('.metric-value');
                if (metricValue && metricValue.textContent.includes('8.5')) {
                    animateNumbers(metricValue, 8.5);
                }
            }
        });
    }, { threshold: 0.5 });

    const dashboardPreview = document.querySelector('.dashboard-preview');
    if (dashboardPreview) {
        metricObserver.observe(dashboardPreview);
    }

    // Effet de parallaxe pour le hero
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        if (hero) {
            const rate = scrolled * -0.5;
            hero.style.transform = `translateY(${rate}px)`;
        }
    });

    // Animation des cartes de fonctionnalités au hover
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Animation des boutons
    const buttons = document.querySelectorAll('.btn-primary, .btn-secondary, .btn-outline');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Compteur animé pour les statistiques
    const stats = document.querySelectorAll('.stat-number');
    const animateCounter = (element, targetValue, duration = 2000) => {
        const startValue = 0;
        const increment = targetValue / (duration / 16);
        let currentValue = startValue;
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= targetValue) {
                currentValue = targetValue;
                clearInterval(timer);
            }
            
            if (element.textContent.includes('K')) {
                element.textContent = Math.floor(currentValue) + 'K+';
            } else if (element.textContent.includes('%')) {
                element.textContent = Math.floor(currentValue) + '%';
            } else {
                element.textContent = Math.floor(currentValue);
            }
        }, 16);
    };

    // Observer pour les statistiques
    const statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumber = entry.target.querySelector('.stat-number');
                if (statNumber) {
                    let targetValue = 0;
                    if (statNumber.textContent.includes('50K')) {
                        targetValue = 50;
                    } else if (statNumber.textContent.includes('95%')) {
                        targetValue = 95;
                    } else if (statNumber.textContent.includes('30%')) {
                        targetValue = 30;
                    }
                    animateCounter(statNumber, targetValue);
                }
            }
        });
    }, { threshold: 0.5 });

    const heroStats = document.querySelector('.hero-stats');
    if (heroStats) {
        statsObserver.observe(heroStats);
    }

    // Simulation de données en temps réel pour le dashboard
    const simulateRealTimeData = () => {
        const metricCards = document.querySelectorAll('.metric-card');
        metricCards.forEach(card => {
            const valueElement = card.querySelector('.metric-value');
            const changeElement = card.querySelector('.metric-change');
            
            if (valueElement && changeElement) {
                // Simulation de variations mineures
                const currentValue = parseFloat(valueElement.textContent);
                const variation = (Math.random() - 0.5) * 0.2; // Variation de ±0.1
                const newValue = Math.max(0, currentValue + variation);
                
                valueElement.textContent = newValue.toFixed(1);
                
                // Mise à jour de l'indicateur de changement
                if (variation > 0) {
                    changeElement.textContent = '+' + (variation * 100).toFixed(1) + '%';
                    changeElement.className = 'metric-change positive';
                } else {
                    changeElement.textContent = (variation * 100).toFixed(1) + '%';
                    changeElement.className = 'metric-change';
                }
            }
        });
    };

    // Mise à jour des données toutes les 5 secondes
    setInterval(simulateRealTimeData, 5000);

    // Effet de typing pour le titre principal
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        const originalText = heroTitle.innerHTML;
        heroTitle.innerHTML = '';
        
        let i = 0;
        const typeWriter = () => {
            if (i < originalText.length) {
                heroTitle.innerHTML += originalText.charAt(i);
                i++;
                setTimeout(typeWriter, 50);
            }
        };
        
        // Démarrer l'effet de typing après un délai
        setTimeout(typeWriter, 1000);
    }

    // Gestion des formulaires (simulation)
    const ctaButtons = document.querySelectorAll('.btn-primary');
    ctaButtons.forEach(button => {
        if (button.textContent.includes('Démarrer') || button.textContent.includes('Essayer')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Animation de clic
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
                
                // Simulation d'ouverture de modal ou redirection
                alert('Fonctionnalité en cours de développement ! 🚀\n\nCette fonctionnalité sera bientôt disponible pour vous permettre de commencer votre essai gratuit.');
            });
        }
    });

    // Effet de particules pour le hero (simulation simple)
    const createParticle = () => {
        const particle = document.createElement('div');
        particle.style.position = 'absolute';
        particle.style.width = '4px';
        particle.style.height = '4px';
        particle.style.background = '#10b981';
        particle.style.borderRadius = '50%';
        particle.style.opacity = '0.6';
        particle.style.pointerEvents = 'none';
        
        const hero = document.querySelector('.hero');
        if (hero) {
            particle.style.left = Math.random() * hero.offsetWidth + 'px';
            particle.style.top = hero.offsetHeight + 'px';
            hero.appendChild(particle);
            
            // Animation de la particule
            let position = hero.offsetHeight;
            const animate = () => {
                position -= 2;
                particle.style.top = position + 'px';
                particle.style.opacity = position / hero.offsetHeight;
                
                if (position > -10) {
                    requestAnimationFrame(animate);
                } else {
                    particle.remove();
                }
            };
            animate();
        }
    };

    // Créer des particules périodiquement
    setInterval(createParticle, 3000);

    // Préchargement des images et optimisation des performances
    const preloadImages = () => {
        const imageUrls = [
            // Ajouter ici les URLs des images à précharger
        ];
        
        imageUrls.forEach(url => {
            const img = new Image();
            img.src = url;
        });
    };

    // Précharger les images au chargement de la page
    preloadImages();

    // Gestion du thème sombre (fonctionnalité future)
    const toggleTheme = () => {
        document.body.classList.toggle('dark-theme');
        localStorage.setItem('theme', document.body.classList.contains('dark-theme') ? 'dark' : 'light');
    };

    // Charger le thème sauvegardé
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-theme');
    }

    // Ajouter un bouton de basculement de thème (optionnel)
    // const themeToggle = document.createElement('button');
    // themeToggle.innerHTML = '🌙';
    // themeToggle.style.position = 'fixed';
    // themeToggle.style.bottom = '20px';
    // themeToggle.style.right = '20px';
    // themeToggle.style.zIndex = '1000';
    // themeToggle.addEventListener('click', toggleTheme);
    // document.body.appendChild(themeToggle);

    console.log('🚀 AgroGrok - Site web chargé avec succès !');
    console.log('🌱 Prêt à révolutionner l\'agriculture avec l\'IA !');
});
