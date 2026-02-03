# Gestion des Courses Familiales

Une application web MVC romantique et intuitive pour gérer les achats de votre famille.

## 🌟 Fonctionnalités

### Gestion des Achats
- ✅ Ajouter un nouvel achat (produit, quantité, prix, date, membre)
- ✅ Modifier un achat existant
- ✅ Supprimer un achat
- ✅ Consulter l'historique complet des achats

### Statistiques et Analyses
- 📊 Dépenses par membre de la famille
- 🏷️ Produits les plus achetés (avec top produit)
- 📈 Dépenses par catégorie
- 📉 Graphiques simples et intuitifs

### Interface Utilisateur
- 🎨 Design romantique et chaleureux
- 📱 Responsive (mobile et desktop)
- 🎯 Formulaires intuitifs
- 📋 Tableaux lisibles avec actions rapides

## 🛠️ Technologies Utilisées

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend**: PHP 8+ (architecture MVC)
- **Base de données**: MySQL/MariaDB
- **Design**: Interface romantique avec dégradés pastel

## 📁 Structure du Projet

```
gestion-courses-famille/
├── app/
│   ├── controllers/
│   │   ├── AchatsController.php
│   │   └── StatistiquesController.php
│   ├── models/
│   │   ├── Model.php (base)
│   │   ├── Achat.php
│   │   ├── Produit.php
│   │   ├── Categorie.php
│   │   └── Membre.php
│   └── views/
│       ├── layout.php
│       ├── achats/
│       │   ├── index.php
│       │   ├── ajouter.php
│       │   └── modifier.php
│       └── statistiques/
│           └── index.php
├── config/
│   └── database.php
├── database/
│   └── schema.sql
├── public/
│   ├── css/
│   └── js/
├── tests/
│   └── test_top_produit.php
├── index.php
└── README.md
```

## 🚀 Installation et Configuration

### Prérequis
- Serveur web (Apache/Nginx)
- PHP 8.0 ou supérieur
- MySQL/MariaDB 5.7 ou supérieur
- WAMP/XAMPP ou équivalent

### Étapes d'Installation

1. **Cloner ou télécharger le projet**
   ```bash
   # Placez le dossier dans votre répertoire web (ex: wamp64/www/)
   ```

2. **Créer la base de données**
   - Ouvrez phpMyAdmin ou votre outil MySQL
   - Créez une base de données nommée `gestion_courses_famille`
   - Importez le fichier `database/schema.sql`

3. **Configurer la connexion à la base de données**
   - Ouvrez `config/database.php`
   - Modifiez les constantes si nécessaire :
     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'gestion_courses_famille');
     define('DB_USER', 'root'); // Votre utilisateur MySQL
     define('DB_PASS', ''); // Votre mot de passe MySQL
     ```

4. **Lancer l'application**
   - Démarrez votre serveur WAMP/XAMPP
   - Ouvrez votre navigateur à l'adresse : `http://localhost/gestion-courses-famille/`

## 🧪 Tests

### Test Unitaire du Top Produit
L'application inclut un script de test automatisé pour valider la logique du produit le plus acheté.

Pour exécuter le test :
```bash
php tests/test_top_produit.php
```

Exemple de test :
- Liste d'achats : "pomme; poire; pomme"
- Résultat attendu : "pomme" (2 unités)

## 🎨 Branches de Développement

Le projet utilise Git Flow avec les branches suivantes :
- `fonctionnalite/ajout-produit` : Fonctionnalité d'ajout de produits
- `fonctionnalite/top-statistiques` : Statistiques et analyses
- `main` : Branche principale

## 📊 Données de Test

La base de données inclut des données de test :
- **Membres** : Papa, Maman, Enfant1, Enfant2
- **Catégories** : Fruits, Légumes, Viandes, Produits laitiers, Épicerie
- **Produits** : Pomme, Banane, Tomate, etc.
- **Achats** : Quelques achats de test

## 🎯 Utilisation

### Ajouter un Achat
1. Cliquez sur "Ajouter un Achat"
2. Sélectionnez le produit et le membre
3. Saisissez quantité, prix et date
4. Cliquez sur "Ajouter l'Achat"

### Consulter les Statistiques
1. Cliquez sur "Statistiques" dans la navigation
2. Visualisez les graphiques et tableaux

### Modifier/Supprimer un Achat
- Dans la liste des achats, utilisez les boutons d'action

## 💝 Philosophie du Projet

Cette application n'est pas seulement fonctionnelle, elle fait vibrer les utilisateurs ! Elle transforme la gestion des courses en un moment agréable et romantique, comme un carnet de famille digital qui rend chaque achat mémorable.

## 📝 Notes Techniques

- Architecture MVC propre et maintenable
- Code commenté et structuré
- Validation côté serveur
- Interface responsive avec Bootstrap
- Graphiques avec Chart.js
- Tests unitaires automatisés

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :
- Signaler des bugs
- Proposer des améliorations
- Soumettre des pull requests

## 📄 Licence

Ce projet est sous licence MIT. Vous êtes libre de l'utiliser, le modifier et le distribuer.

---

*Développé avec ❤️ pour rendre la gestion familiale des courses magique et fluide.*
