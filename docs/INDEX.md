# 📚 Documentation ArtisanMarket

Bienvenue dans la documentation complète du projet **ArtisanMarket**.

## 📖 Table des Matières

### 🏗️ Architecture & Base de Données
- [**DATABASE_SCHEMA.md**](DATABASE_SCHEMA.md) - Schéma complet de la base de données
  - Diagramme ERD des relations
  - Structure détaillée des 6 tables métier
  - Modèles Eloquent et relations
  - Seeders et factories disponibles

### 🎨 Composants UI
- [**UI_COMPONENTS.md**](UI_COMPONENTS.md) - Guide complet des composants shadcn/ui
  - Documentation de chaque composant
  - Props et options disponibles
  - Exemples de code
  - Guide de personnalisation
  
- [**COMPONENTS_LIST.md**](COMPONENTS_LIST.md) - Liste rapide des 22 composants
  - Tableau récapitulatif
  - Variantes et tailles
  - Utilisation rapide

## 🚀 Démarrage Rapide

### Installation
```bash
# Installer les dépendances
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
php artisan migrate
php artisan db:seed

# Compiler les assets
npm run dev
```

### Accès à l'application
- **URL locale** : http://localhost:8000
- **Page de démo** : http://localhost:8000/components-demo (après connexion)

### Comptes de test
| Rôle | Email | Password | Dashboard |
|------|-------|----------|-----------|
| Admin | admin@artisanmarket.com | password | /admin/dashboard |
| Artisan | artisan@test.com | password | /artisan/dashboard |
| Client | client@test.com | password | /dashboard |

## 📁 Structure du Projet

```
artisan-ci/
├── app/
│   ├── Models/               # Modèles Eloquent
│   │   ├── User.php
│   │   ├── Artisan.php
│   │   ├── Category.php
│   │   ├── Product.php
│   │   ├── ProductImage.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── ...
│
├── database/
│   ├── migrations/           # Migrations de base de données
│   ├── seeders/             # Seeders (CategorySeeder, RoleSeeder, etc.)
│   └── factories/           # Factories pour test data
│
├── resources/
│   ├── views/
│   │   ├── components/
│   │   │   └── ui/          # 22 composants shadcn/ui
│   │   ├── admin/           # Vues admin
│   │   ├── artisan/         # Vues artisan
│   │   ├── components-demo.blade.php
│   │   └── ...
│   └── css/
│       └── app.css          # Variables CSS shadcn/ui
│
├── docs/                    # Documentation (ce dossier)
│   ├── INDEX.md
│   ├── DATABASE_SCHEMA.md
│   ├── UI_COMPONENTS.md
│   └── COMPONENTS_LIST.md
│
└── README.md                # Guide principal
```

## 🛠️ Technologies Utilisées

### Backend
- **Laravel 12** - Framework PHP
- **MySQL 8.0** - Base de données
- **Spatie Permission 6.24** - Gestion des rôles

### Frontend
- **Blade** - Moteur de template Laravel
- **Alpine.js** - Framework JavaScript léger
- **TailwindCSS v3+** - Framework CSS utility-first
- **shadcn/ui** - Composants UI (adaptés pour Blade)

## 🎯 Progression du Projet

- [x] **ÉTAPE 1** - Installation & Configuration ✅
- [x] **ÉTAPE 2** - Authentification multi-rôles ✅
- [x] **ÉTAPE 3** - Schéma de base de données ✅
- [x] **ÉTAPE 4** - Composants shadcn/ui ✅
- [ ] **ÉTAPE 5** - Dashboard Admin
- [ ] **ÉTAPE 6** - Espace Artisan
- [ ] **ÉTAPE 7** - Frontend Client
- [ ] **ÉTAPE 8** - Système de notifications
- [ ] **ÉTAPE 9** - Optimisations
- [ ] **ÉTAPE 10** - Tests & Déploiement

## 📊 Statistiques du Projet

### Base de Données
- **6 tables métier** : artisans, categories, products, product_images, orders, order_items
- **10 catégories** pré-remplies
- **7 modèles Eloquent** avec relations complètes
- **6 factories** pour génération de données de test

### Composants UI
- **22 composants** Blade réutilisables
- **17 variantes** de couleurs et styles
- **6 composants Alpine.js** interactifs
- **100% responsive** et accessible

### Authentification
- **3 rôles** : admin, artisan, client
- **Middleware personnalisé** pour protection des routes
- **Redirections automatiques** selon le rôle

## 🔍 Ressources Utiles

### Commandes Artisan
```bash
# Réinitialiser la base de données
php artisan migrate:fresh --seed

# Créer des données de test
php artisan tinker
>>> Artisan::factory()->approved()->count(5)->create()
>>> Product::factory()->published()->count(20)->create()

# Lister les routes
php artisan route:list

# Informations sur l'application
php artisan about
```

### Développement
```bash
# Mode développement (watch)
npm run dev

# Build production
npm run build

# Lancer les tests
php artisan test
```

## 🐛 Débogage

### Vérifier l'environnement
```bash
php artisan about
php artisan config:cache
php artisan cache:clear
```

### Vérifier les composants
Visitez `/components-demo` pour tester tous les composants UI en live.

## 📞 Support

Pour toute question ou problème :
1. Consultez la documentation dans ce dossier
2. Vérifiez les exemples dans `/components-demo`
3. Consultez le README.md principal

---

**Dernière mise à jour** : 31 janvier 2026  
**Version** : 1.0 (Fin de l'ÉTAPE 4)  
**Développé avec ❤️ pour les artisans**
