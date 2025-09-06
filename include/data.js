// Données de production rizicole pour Madagascar et le monde
// Mises à jour le 06 septembre 2025

const rizicultureData = {
    // Données de production (en millions de tonnes)
    production: {
        madagascar: {
            value: 5.12,
            year: "2023/24",
            unit: "millions de tonnes",
            label: "Production Madagascar"
        },
        chine: {
            value: 208.5,
            year: "2022/23",
            unit: "millions de tonnes",
            label: "Production Chine"
        },
        mondiale: {
            value: 523.8,
            year: "2023/24",
            unit: "millions de tonnes",
            label: "Production Mondiale"
        },
        projection_fao: {
            value: 551.5,
            year: "2025",
            unit: "millions de tonnes",
            label: "Projection FAO 2025"
        }
    },
    
    // Données de rendement (en tonnes par hectare)
    rendement: {
        madagascar: {
            value: 3.05,
            unit: "t/ha",
            label: "Rendement Madagascar"
        },
        chine: {
            value: 6.7,
            unit: "t/ha",
            label: "Rendement Chine"
        },
        monde: {
            value: 4.6,
            unit: "t/ha",
            label: "Rendement Mondial"
        }
    },
    
    // Données pour les graphiques
    charts: {
        // Données pour le bar chart comparatif
        barChart: {
            labels: ["Madagascar", "Monde", "Chine"],
            datasets: [{
                label: "Production (millions de tonnes)",
                data: [5.12, 208.5, 523.8],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',  // Vert pour Madagascar
                    'rgba(239, 68, 68, 0.8)',   // Rouge pour Chine
                    'rgba(59, 130, 246, 0.8)'   // Bleu pour Monde
                ],
                borderColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(59, 130, 246, 1)'
                ],
                borderWidth: 2
            }]
        },
        
        // Données pour le line chart d'évolution
        lineChart: {
            labels: ["2023", "2024", "2025 (Proj.)"],
            datasets: [{
                label: "Production Mondiale (Mt)",
                data: [523.8, 523.8, 551.5],
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        }
    },
    
    // Zones rizicoles de Madagascar
    zonesRizicoles: [
        {
            id: "hauts-plateaux",
            nom: "Hauts Plateaux",
            region: "Antananarivo, Fianarantsoa",
            production: "2.1",
            pourcentage: "41%",
            description: "Zone principale de production rizicole"
        },
        {
            id: "cote-est",
            nom: "Côte Est",
            region: "Toamasina, Mananjary",
            production: "1.8",
            pourcentage: "35%",
            description: "Riziculture pluviale et irriguée"
        },
        {
            id: "cote-ouest",
            nom: "Côte Ouest",
            region: "Mahajanga, Morondava",
            production: "0.9",
            pourcentage: "18%",
            description: "Riziculture de basse altitude"
        },
        {
            id: "sud",
            nom: "Sud",
            region: "Toliara, Fort-Dauphin",
            production: "0.32",
            pourcentage: "6%",
            description: "Riziculture adaptée à la sécheresse"
        }
    ],
    
    // Métadonnées
    metadata: {
        lastUpdate: "06 septembre 2025",
        sources: [
            "USDA FAS (IPAD, 2023/24)",
            "FAO (Projections 2025)",
            "Ministère de l'Agriculture Madagascar"
        ],
        version: "1.0.0"
    },
    
    // Calculs dérivés
    calculs: {
        // Part de Madagascar dans la production mondiale
        partMadagascar: function() {
            return ((this.production.madagascar.value / this.production.mondiale.value) * 100).toFixed(2);
        },
        
        // Écart de rendement Madagascar vs Monde
        ecartRendement: function() {
            return ((this.rendement.monde.value - this.rendement.madagascar.value) / this.rendement.monde.value * 100).toFixed(1);
        },
        
        // Potentiel d'amélioration
        potentielAmelioration: function() {
            const rendementMax = 8.0; // Rendement théorique maximum
            const rendementActuel = this.rendement.madagascar.value;
            return (((rendementMax - rendementActuel) / rendementActuel) * 100).toFixed(1);
        }
    }
};

// Fonction pour formater les nombres
function formatNumber(number, decimals = 1) {
    return new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    }).format(number);
}

// Fonction pour calculer les pourcentages
function calculatePercentage(part, total) {
    return ((part / total) * 100).toFixed(1);
}

// Export pour utilisation dans d'autres fichiers
if (typeof module !== 'undefined' && module.exports) {
    module.exports = rizicultureData;
}