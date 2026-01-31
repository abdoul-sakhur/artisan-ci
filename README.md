# 🎨 ArtisanMarket - Plateforme E-commerce Multi-Profil

**Plateforme e-commerce** permettant aux artisans de vendre leurs œuvres directement aux clients.

## 🚀 Stack Technique

- **Backend** : Laravel 12
- **Frontend** : Blade + Alpine.js
- **UI Components** : shadcn/ui (adapté pour Laravel)
- **Authentification** : Laravel Breeze
- **Gestion des Rôles** : Spatie Laravel Permission
- **Base de Données** : MySQL
- **Styling** : TailwindCSS + tailwindcss-animate

## 👥 Acteurs

- 👨‍🎨 **Artisan** : Crée sa boutique, publie des œuvres, gère ses commandes
- 🛒 **Client** : Parcourt le catalogue, commande, paie
- 🛠 **Admin** : Valide les artisans, modère le contenu, consulte les statistiques

## 📋 Prérequis

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL >= 8.0
- Git

## 🔧 Installation Locale

### 1. Cloner le projet

```bash
git clone <votre-repo-url>
cd artisan-ci
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JavaScript

```bash
npm install
```

### 4. Configuration de l'environnement

```bash
# Copier le fichier .env.example
copy .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 5. Configurer la base de données

Éditez le fichier `.env` avec vos informations MySQL :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=artisan_market
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

Créez la base de données :

```bash
mysql -u root -p -e "CREATE DATABASE artisan_market CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 6. Lancer les migrations

```bash
php artisan migrate
```

### 7. Compiler les assets

```bash
# Développement
npm run dev

# Production
npm run build
```

### 8. Lancer le serveur

```bash
php artisan serve
```

L'application sera accessible sur : [http://localhost:8000](http://localhost:8000)

## 📦 Packages Installés

### PHP (Composer)
- `laravel/breeze` - Authentification simple
- `spatie/laravel-permission` - Gestion des rôles et permissions

### JavaScript (NPM)
- `alpinejs` - Framework JavaScript léger
- `tailwindcss` - Framework CSS
- `tailwindcss-animate` - Animations pour shadcn/ui
- `@tailwindcss/forms` - Styles pour les formulaires

## 🗄️ Structure de la Base de Données

### Tables principales (ÉTAPE 3 complétée)

#### Tables Business
- **`artisans`** - Profils des artisans avec boutiques
  - `user_id`, `shop_name`, `shop_slug`, `description`, `logo_url`, `cover_image_url`
  - `is_approved`, `approved_at`, `approved_by`
  - Relations: `belongsTo(User)`, `hasMany(Products)`, `hasMany(Orders)`

- **`categories`** - Catégories d'œuvres artisanales (10 catégories pré-remplies)
  - `name`, `slug`, `description`, `image_url`, `is_active`
  - Relations: `hasMany(Products)`

- **`products`** - Œuvres artisanales
  - `artisan_id`, `category_id`, `name`, `slug`, `description`, `price`, `quantity`
  - `sku`, `is_published`, `is_featured`, `views_count`
  - Relations: `belongsTo(Artisan)`, `belongsTo(Category)`, `hasMany(ProductImages)`, `hasMany(OrderItems)`

- **`product_images`** - Images des produits
  - `product_id`, `image_url`, `is_primary`, `sort_order`
  - Relations: `belongsTo(Product)`

- **`orders`** - Commandes clients
  - `order_number`, `user_id`, `artisan_id`, `total_amount`, `status`
  - `shipping_address` (JSON: name, address, city, postal_code, country, phone)
  - Status: pending, confirmed, processing, shipped, delivered, cancelled
  - Relations: `belongsTo(User)`, `belongsTo(Artisan)`, `hasMany(OrderItems)`

- **`order_items`** - Détails des commandes
  - `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`
  - Relations: `belongsTo(Order)`, `belongsTo(Product)`

#### Tables système (Laravel & Spatie)
- `users` - Utilisateurs (avec colonnes Breeze)
- `password_reset_tokens` - Réinitialisation de mot de passe
- `sessions` - Sessions utilisateurs
- `cache` - Cache de l'application
- `jobs` - Files d'attente
- `roles` - Rôles (Spatie Permission)
- `permissions` - Permissions (Spatie Permission)
- `model_has_roles` - Assignation rôles aux utilisateurs
- `model_has_permissions` - Assignation permissions aux utilisateurs
- `role_has_permissions` - Permissions par rôle

### Modèles Eloquent avec Relations

Tous les modèles incluent des **scopes**, **accessors/mutators**, et **méthodes métier** :
- `Artisan` : approve(), reject(), scopes (approved, pending)
- `Product` : incrementViews(), canPurchase(), scopes (published, featured, inStock)
- `Category` : auto-slugging, active scope
- `Order` : auto order_number, scopes par status
- `OrderItem` : auto-calculation du subtotal
- `User` : isArtisan(), isApprovedArtisan(), relations avec Artisan et Orders

### Catégories Pré-remplies

1. Poterie & Céramique
2. Bijoux Artisanaux
3. Maroquinerie
4. Textile & Broderie
5. Bois Sculpté
6. Verrerie
7. Peinture & Art Mural
8. Vannerie
9. Savons & Cosmétiques
10. Décoration Intérieure

### Factories Disponibles

- `ArtisanFactory` - Génère des profils d'artisans (avec states: approved, pending)
- `ProductFactory` - Génère des produits réalistes (states: published, featured, outOfStock)
- `OrderFactory` - Génère des commandes avec adresses de livraison
- `CategoryFactory` - Génère des catégories personnalisées
- `ProductImageFactory` - Génère des images de produits
- `OrderItemFactory` - Génère des lignes de commande

## 🎨 Composants UI shadcn/ui

Le projet dispose d'une bibliothèque complète de **18 composants UI** adaptés pour Laravel Blade + Alpine.js.

### 📦 Composants Disponibles

#### Formulaires
- **Button** - 6 variantes (default, destructive, outline, secondary, ghost, link) + 4 tailles
- **Input** - Champs de saisie avec gestion d'erreurs
- **Label** - Étiquettes avec indicateur requis
- **Textarea** - Zones de texte multiligne
- **Select** - Listes déroulantes
- **Checkbox** - Cases à cocher
- **Radio** - Boutons radio

#### Navigation & Structure
- **Card** - Cartes avec header/footer optionnels
- **Tabs** - Système d'onglets interactifs (Alpine.js)
- **Modal** - Boîtes de dialogue (Alpine.js)
- **Dropdown** - Menus déroulants (Alpine.js)
- **Separator** - Séparateurs horizontaux/verticaux

#### Affichage
- **Badge** - Étiquettes colorées (6 variantes)
- **Alert** - Messages d'alerte (5 variantes) avec option dismissible
- **Table** - Tables responsive avec hover/striped
- **Stat Card** - Cartes de statistiques avec tendances
- **Spinner** - Indicateur de chargement

#### Utilitaires
- **Add Button** - Bouton d'ajout avec icône
- **Dropdown Item** - Éléments de menu déroulant

### 📖 Documentation

Voir [docs/UI_COMPONENTS.md](docs/UI_COMPONENTS.md) pour :
- Documentation détaillée de chaque composant
- Props et options disponibles
- Exemples de code
- Guide de personnalisation

### 🎯 Page de Démo

Accédez à `/components-demo` (après connexion) pour voir tous les composants en action.

```bash
# Après connexion, visitez :
http://localhost:8000/components-demo
```

### Variables CSS

Les variables de couleurs sont définies dans `resources/css/app.css` et peuvent être personnalisées :

- `--primary` - Couleur principale
- `--secondary` - Couleur secondaire
- `--destructive` - Couleur pour les actions destructives
- `--muted` - Couleur atténuée
- `--accent` - Couleur d'accentuation
- `--border` - Couleur des bordures

### Mode Dark

Le projet supporte le mode sombre via la classe `.dark` (à implémenter dans les prochaines étapes).

## � Système Multi-Rôles

Le projet implémente un système de gestion des rôles avec **Spatie Laravel Permission**.

### Rôles Disponibles

- **admin** : Accès complet, validation des artisans, modération
- **artisan** : Gestion de sa boutique et de ses œuvres
- **client** : Navigation, commandes, profil

### Comptes de Test

| Rôle | Email | Password | Dashboard |
|------|-------|----------|-----------|
| Admin | admin@artisanmarket.com | password | /admin/dashboard |
| Artisan | artisan@test.com | password | /artisan/dashboard |
| Client | client@test.com | password | /dashboard |

### Middleware

Le middleware `CheckRole` protège les routes par rôle :

```php
// Route protégée pour admin uniquement
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Routes admin
});
```

### Redirections Automatiques

Après connexion, les utilisateurs sont automatiquement redirigés vers leur dashboard selon leur rôle :
- Admin → `/admin/dashboard`
- Artisan → `/artisan/dashboard`
- Client → `/dashboard`

Les nouveaux inscrits reçoivent automatiquement le rôle **client**.

## 📝 Prochaines Étapes

- [x] ~~ÉTAPE 1 : Installation & Configuration initiale~~
- [x] ~~ÉTAPE 2 : Système d'authentification multi-rôles~~
- [x] ~~ÉTAPE 3 : Schéma de base de données complet~~
- [x] ~~ÉTAPE 4 : Composants shadcn/ui pour Laravel~~
- [x] ~~ÉTAPE 5 : Dashboard Admin~~
- [x] ~~ÉTAPE 6 : Espace Artisan~~
- [ ] ÉTAPE 7 : Frontend Client
- [ ] ÉTAPE 8 : Système de notifications
- [ ] ÉTAPE 9 : Optimisations & fonctionnalités avancées
- [ ] ÉTAPE 10 : Tests & déploiement

## 🧪 Tests

```bash
# Lancer tous les tests
php artisan test

# Tests avec couverture
php artisan test --coverage
```

## 🔐 Sécurité

Si vous découvrez une faille de sécurité, veuillez contacter l'équipe de développement.

## 📄 Licence

Ce projet est sous licence MIT.

## ✅ Checklist ÉTAPE 1 - Terminée

- [x] Projet Laravel 12 créé
- [x] Breeze Blade installé et configuré
- [x] TailwindCSS configuré pour shadcn/ui
- [x] Alpine.js fonctionnel (inclus avec Breeze)
- [x] Spatie Permission installé et migrations publiées
- [x] Base de données MySQL configurée
- [x] Migrations exécutées avec succès
- [x] Assets compilés
- [x] Variables CSS shadcn/ui configurées
- [x] Plugin tailwindcss-animate installé

## ✅ Checklist ÉTAPE 2 - Terminée

- [x] Modèle User configuré avec le trait HasRoles
- [x] 3 rôles créés (admin, artisan, client)
- [x] Middleware CheckRole créé et enregistré
- [x] Admin par défaut créé (admin@artisanmarket.com)
- [x] Utilisateurs de démo créés (artisan@test.com, client@test.com)
- [x] Routes protégées par rôle configurées
- [x] Redirections post-login basées sur le rôle
- [x] Dashboards de base créés pour chaque rôle
- [x] Auto-assignation du rôle "client" à l'inscription
- [x] DatabaseSeeder configuré

## ✅ Checklist ÉTAPE 3 - Terminée

- [x] Migration `artisans` avec shop_name, slug, descriptions, logos, approval system
- [x] Migration `categories` avec name, slug, description, image, active status
- [x] Migration `products` avec pricing, inventory, SKU, publication status
- [x] Migration `product_images` avec primary flag et sort order
- [x] Migration `orders` avec order_number, status enum, shipping_address JSON
- [x] Migration `order_items` avec auto-calculated subtotal
- [x] Modèle `Artisan` avec relations et méthodes approve()/reject()
- [x] Modèle `Category` avec auto-slugging et active scope
- [x] Modèle `Product` avec scopes (published, featured, inStock) et méthodes métier
- [x] Modèle `ProductImage` avec primary scope
- [x] Modèle `Order` avec auto order_number et status scopes
- [x] Modèle `OrderItem` avec auto-subtotal calculation
- [x] Relations User ↔ Artisan ↔ Products ↔ Orders configurées
- [x] CategorySeeder avec 10 catégories artisanales
- [x] Factories pour test data (Artisan, Product, Order, OrderItem, ProductImage, Category)
- [x] Migrations exécutées et catégories seedées
- [x] Vérification database réussie (10 catégories créées)

## ✅ Checklist ÉTAPE 4 - Terminée

- [x] Structure `resources/views/components/ui/` créée
- [x] Composant Button avec 6 variantes + 4 tailles
- [x] Composant Input avec gestion d'erreurs
- [x] Composant Label avec indicateur required
- [x] Composant Textarea
- [x] Composant Select (dropdown)
- [x] Composant Checkbox
- [x] Composant Radio
- [x] Composant Card avec header/footer
- [x] Composant Badge (6 variantes)
- [x] Composant Alert (5 variantes + dismissible)
- [x] Composant Modal (Alpine.js)
- [x] Composant Table responsive
- [x] Composants Tabs (tabs, tabs-list, tabs-trigger, tabs-content)
- [x] Composant Dropdown (Alpine.js)
- [x] Composant Separator
- [x] Composant Stat Card avec tendances
- [x] Composant Spinner
- [x] Composant Add Button
- [x] Page de démo `/components-demo` créée
- [x] Documentation complète `docs/UI_COMPONENTS.md`
- [x] README.md mis à jour

## ✅ Checklist ÉTAPE 5 - Terminée

- [x] Contrôleur Admin\DashboardController avec statistiques complètes
- [x] Vue admin/dashboard.blade.php avec 4 stat cards et tableaux
- [x] Contrôleur Admin\ArtisanController avec approve/reject/destroy
- [x] Vues admin/artisans (index avec filtres + show avec détails)
- [x] Contrôleur Admin\CategoryController avec CRUD complet + toggleStatus
- [x] Vues admin/categories (index + create + edit)
- [x] 14 routes admin configurées dans web.php
- [x] Composant admin-navigation.blade.php créé
- [x] Layout app.blade.php mis à jour pour détecter les routes admin
- [x] Protection des routes avec middleware role:admin
- [x] Validation des formulaires (catégories)
- [x] Messages flash (success/error)
- [x] Pagination (artisans 15/page, catégories 20/page)
- [x] Eager loading optimisé
- [x] Documentation complète `docs/ETAPE_5_COMPLETE.md`

## ✅ Checklist ÉTAPE 6 - Terminée

- [x] Contrôleur Artisan/DashboardController avec statistiques (6 métriques)
- [x] Vue artisan/dashboard avec 4 stat cards et sections
- [x] Vue artisan/pending pour artisans non approuvés
- [x] Contrôleur Artisan/ProductController avec CRUD complet
- [x] Vues artisan/products (index grid + create + edit)
- [x] Contrôleur Artisan/OrderController avec gestion statuts
- [x] Vues artisan/orders (index tableau + show détails)
- [x] Contrôleur Artisan/ProfileController pour boutique
- [x] Vue artisan/profile/edit avec logo et bannière
- [x] 19 routes artisan configurées dans web.php
- [x] Composant artisan-navigation.blade.php créé
- [x] Layout app.blade.php mis à jour pour navigation artisan
- [x] Middleware role:artisan appliqué sur toutes les routes
- [x] Validation formulaires (produits, profil)
- [x] Messages flash (success/error)
- [x] Filtres dynamiques (produits par statut, commandes par statut)
- [x] Ownership protection sur produits et commandes
- [x] Pagination (12 produits, 15 commandes)
- [x] Eager loading optimisé (with relations)
- [x] Documentation complète `docs/ETAPE_6_COMPLETE.md`

**Développé avec ❤️ pour les artisans**



