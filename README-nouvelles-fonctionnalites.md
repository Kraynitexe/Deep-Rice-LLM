# Nouvelles Fonctionnalités - Deep Rice Madagascar

## 🚀 Fonctionnalités Ajoutées

### 1. Système de Connexion/Authentification
- **Inscription** : Les utilisateurs peuvent créer un compte (agriculteur ou expert)
- **Connexion** : Système d'authentification sécurisé avec sessions
- **Déconnexion** : Gestion des sessions utilisateur
- **Types d'utilisateurs** : Agriculteur, Expert, Administrateur

### 2. Système d'Appel d'Expert
- **Demande d'aide** : Les agriculteurs peuvent demander l'aide d'experts
- **Gestion des demandes** : Interface pour les experts pour gérer les demandes
- **Suivi des demandes** : Statuts en temps réel (En attente, Assignée, En cours, Terminée)
- **Réponses personnalisées** : Les experts peuvent répondre directement aux agriculteurs

## 📁 Structure des Fichiers

```
├── auth/
│   ├── login.php          # Page de connexion
│   ├── register.php       # Page d'inscription
│   └── logout.php         # Déconnexion
├── config/
│   └── database.php       # Configuration base de données
├── database/
│   └── schema.sql         # Schéma de la base de données
├── pages/
│   ├── expert-request.php # Demande d'expert
│   ├── expert-dashboard.php # Tableau de bord expert
│   └── components/
│       └── header.php     # Navigation mise à jour
├── setup/
│   └── init-database.php  # Script d'initialisation
└── README-nouvelles-fonctionnalites.md
```

## 🛠️ Installation

### 1. Initialiser la Base de Données
1. Assurez-vous que XAMPP est démarré
2. Accédez à `http://localhost/LLM/setup/init-database.php`
3. Suivez les instructions pour créer la base de données
4. **Important** : Supprimez le fichier `setup/init-database.php` après utilisation

### 2. Configuration
- Vérifiez les paramètres de connexion dans `config/database.php`
- Ajustez les paramètres selon votre configuration XAMPP

## 👥 Comptes de Test

| Type | Nom d'utilisateur | Mot de passe | Description |
|------|-------------------|--------------|-------------|
| Admin | admin | password | Administrateur système |
| Expert | expert1 | password | Dr. Jean Rakoto |
| Expert | expert2 | password | Dr. Marie Rasoanaivo |

## 🔧 Utilisation

### Pour les Agriculteurs
1. **S'inscrire** : Créez un compte sur `/auth/register.php`
2. **Se connecter** : Utilisez `/auth/login.php`
3. **Chat IA** : Posez des questions via l'interface de chat
4. **Demander un expert** : Cliquez sur "Demander un expert" pour obtenir de l'aide personnalisée

### Pour les Experts
1. **Se connecter** : Utilisez les comptes expert1 ou expert2
2. **Tableau de bord** : Gérez les demandes d'aide
3. **Assigner des demandes** : Prenez en charge les demandes
4. **Répondre** : Fournissez des conseils personnalisés

## 🎯 Fonctionnalités Clés

### Interface de Chat Améliorée
- Bouton "Demander un expert" intégré
- Navigation contextuelle selon le statut de connexion
- Suggestions rapides pour les questions courantes

### Système de Demandes d'Expert
- **Création de demandes** : Sujet, description, niveau d'urgence
- **Suivi en temps réel** : Statuts et réponses
- **Interface expert** : Gestion complète des demandes
- **Notifications** : Suivi des changements de statut

### Navigation Intelligente
- **Menu contextuel** : Différent selon le type d'utilisateur
- **Mobile-friendly** : Interface responsive
- **Sécurité** : Vérification des permissions

## 🔒 Sécurité

- **Hachage des mots de passe** : Utilisation de `password_hash()`
- **Sessions sécurisées** : Gestion des tokens de session
- **Validation des données** : Protection contre les injections SQL
- **Échappement HTML** : Protection XSS

## 🚀 Prochaines Améliorations

- [ ] Notifications en temps réel
- [ ] Chat en direct entre agriculteurs et experts
- [ ] Système de notation des experts
- [ ] Rapports et statistiques avancées
- [ ] Intégration SMS pour les notifications
- [ ] Application mobile

## 📞 Support

Pour toute question ou problème :
- Email : tantsaha@deep-rice-madagascar.com
- Documentation : Consultez les commentaires dans le code
- Base de données : Vérifiez les logs MySQL dans XAMPP

---

**Note** : Ce système est conçu spécifiquement pour la riziculture à Madagascar et intègre des données locales et des conseils adaptés au contexte malgache.
