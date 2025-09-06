# 🌾 Site Web Riziculture Madagascar - IA & LLM

Un site web moderne et dynamique dédié à l'amélioration de la riziculture à Madagascar grâce à l'intelligence artificielle et aux chatbots LLM.

## ✨ Fonctionnalités Principales

### 🎯 **Page d'Accueil (Hero Section)**
- **Titre accrocheur** : "Améliorer la riziculture à Madagascar grâce à l'IA"
- **Phrase bilingue** : Français et malgache
- **Bouton CTA** : "Découvrir les données" avec animation

### 📊 **Section Données Chiffrées**
- **6 cartes animées** avec données de production
- **Animations au survol** et compteurs animés
- **Données dynamiques** chargées depuis JSON
- **Responsive design** pour tous les écrans

### 📈 **Graphiques Interactifs (Chart.js)**
- **Bar Chart** : Comparaison Madagascar vs Chine vs Monde
- **Line Chart** : Évolution mondiale 2023-2025
- **Carte SVG** : Zones rizicoles de Madagascar avec interactions

### ❓ **FAQ Dynamique**
- **Accordéons JavaScript** pour les questions courantes
- **Animations fluides** d'ouverture/fermeture
- **3 questions essentielles** sur le chatbot IA

## 🚀 Technologies Utilisées

- **HTML5** - Structure sémantique moderne
- **CSS3** - Animations et transitions fluides
- **Tailwind CSS** - Framework CSS utilitaire
- **JavaScript ES6+** - Interactions dynamiques
- **Chart.js** - Graphiques interactifs
- **Font Awesome** - Icônes vectorielles
- **Google Fonts** - Typographie Inter

## 📁 Structure du Projet

```
riziculture-madagascar/
├── riziculture-madagascar.html    # Page principale
├── riziculture-styles.css         # Styles personnalisés
├── riziculture-script.js          # Fonctionnalités JavaScript
├── data.js                        # Données JSON
└── README-riziculture.md          # Documentation
```

## 📊 Données Intégrées

### Production (2023/24)
- **Madagascar** : 5,12 millions de tonnes
- **Chine** : 208,5 millions de tonnes  
- **Monde** : 523,8 millions de tonnes
- **Projection FAO 2025** : 551,5 millions de tonnes

### Rendements
- **Madagascar** : 3,05 t/ha
- **Chine** : 6,7 t/ha
- **Monde** : 4,6 t/ha

### Zones Rizicoles Madagascar
1. **Hauts Plateaux** (41%) - 2,1 Mt
2. **Côte Est** (35%) - 1,8 Mt
3. **Côte Ouest** (18%) - 0,9 Mt
4. **Sud** (6%) - 0,32 Mt

## 🎨 Design et UX

### Palette de Couleurs
- **Vert principal** : #10b981 (nature, croissance)
- **Bleu secondaire** : #3b82f6 (technologie)
- **Rouge accent** : #ef4444 (Chine)
- **Violet** : #8b5cf6 (projections)
- **Orange** : #f59e0b (projections FAO)

### Animations
- **Fade-in** au scroll
- **Compteurs animés** pour les chiffres
- **Hover effects** sur les cartes
- **Particules flottantes** dans le hero
- **Typing effect** pour le titre
- **Smooth scroll** entre sections

## 📱 Responsive Design

- **Mobile First** - Optimisé pour smartphones
- **Tablet** - Layout adapté pour tablettes
- **Desktop** - Expérience complète avec animations
- **Breakpoints** : 768px, 1024px, 1280px

## 🔧 Fonctionnalités Techniques

### Animations Avancées
```javascript
// Compteurs animés
animateNumber(element, 0, targetValue, 2000);

// Particules flottantes
createParticles();

// Typing effect
animateTitle();
```

### Graphiques Interactifs
```javascript
// Bar Chart avec Chart.js
new Chart(barCtx, {
    type: 'bar',
    data: rizicultureData.charts.barChart,
    options: { /* configuration */ }
});
```

### FAQ Accordéon
```javascript
// Gestion des accordéons
question.addEventListener('click', () => {
    // Toggle logic
});
```

## 📈 Optimisations

### Performance
- **Lazy loading** des animations
- **Intersection Observer** pour les effets de scroll
- **Debounced scroll** events
- **Optimized images** et SVG

### SEO
- **Meta tags** complets
- **Open Graph** pour les réseaux sociaux
- **Structured data** pour les moteurs de recherche
- **Semantic HTML** avec balises appropriées

### Accessibilité
- **Navigation clavier** complète
- **Focus states** visibles
- **Alt texts** pour les images
- **ARIA labels** pour les interactions

## 🚀 Installation et Utilisation

1. **Télécharger** tous les fichiers
2. **Ouvrir** `riziculture-madagascar.html` dans un navigateur
3. **Profiter** de l'expérience interactive !

Aucune installation de dépendances requise - tout fonctionne directement dans le navigateur.

## 🔄 Mise à Jour des Données

Pour modifier les données, éditez le fichier `data.js` :

```javascript
const rizicultureData = {
    production: {
        madagascar: {
            value: 5.12,  // Modifier ici
            year: "2023/24"
        }
        // ...
    }
};
```

## 📊 Sources de Données

- **USDA FAS** (IPAD, 2023/24)
- **FAO** (Projections 2025)
- **Ministère de l'Agriculture Madagascar**

## 🎯 Objectifs Pédagogiques

1. **Visualisation** des données rizicoles
2. **Comparaison** Madagascar vs monde
3. **Sensibilisation** à l'importance de l'IA agricole
4. **Démocratisation** des conseils agronomiques

## 🔮 Fonctionnalités Futures

- [ ] **Chatbot intégré** avec API LLM
- [ ] **Données temps réel** via API
- [ ] **Mode sombre** pour l'accessibilité
- [ ] **Export PDF** des graphiques
- [ ] **Notifications push** pour les mises à jour

## 📞 Support

Pour toute question ou suggestion :
- **Email** : contact@riziculture-madagascar.com
- **GitHub** : [Repository du projet]
- **Documentation** : [Lien vers la doc]

---

**🌾 Riziculture IA Madagascar** - L'avenir de l'agriculture malgache commence ici ! 🇲🇬✨
