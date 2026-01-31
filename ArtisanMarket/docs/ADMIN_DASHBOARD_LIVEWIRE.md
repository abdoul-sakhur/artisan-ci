# Dashboard Admin avec Livewire - Documentation

## ✅ Checklist de Réalisation

- [x] Layout admin créé
- [x] Composant validation artisans fonctionnel
- [x] Composant modération œuvres fonctionnel
- [x] Dashboard statistiques affiché
- [x] Routes protégées configurées

---

## 🎯 Fonctionnalités Implémentées

### 1. **Layout Admin** (`resources/views/components/admin-layout.blade.php`)

Un layout complet avec :
- ✅ **Sidebar** responsive avec navigation
  - Dashboard
  - Validation Artisans (avec badge de notifications)
  - Modération Produits
  - Gestion Utilisateurs
  - Gestion Catégories
  - Badge de notification en temps réel pour artisans en attente
  
- ✅ **Header** avec :
  - Bouton menu mobile
  - Titre de page dynamique
  - Cloche de notifications avec dropdown
  - Notifications pour artisans en attente de validation
  
- ✅ **Footer** avec copyright et version

- ✅ **Profil utilisateur** dans la sidebar :
  - Avatar avec initiales
  - Nom et rôle
  - Bouton déconnexion

- ✅ **Notifications Toast** :
  - Système de notifications Livewire intégré
  - Apparition automatique avec timeout
  - Design moderne avec Alpine.js

---

### 2. **Page : Validation des Artisans** (Livewire)

**Composant** : `App\Livewire\Admin\ArtisanApproval`  
**Vue** : `resources/views/livewire/admin/artisan-approval.blade.php`  
**Route** : `/admin/artisans/approval`

#### Fonctionnalités :
- ✅ **Liste des artisans** avec pagination (10 par page)
- ✅ **Recherche en temps réel** (debounce 300ms) :
  - Nom de l'artisan
  - Email
  - Nom de la boutique
  
- ✅ **Filtres par statut** :
  - En attente (pending)
  - Approuvés (approved)
  - Tous (all)
  
- ✅ **Affichage des informations** :
  - Photo/Logo (ou initiale si absente)
  - Nom et email de l'artisan
  - Nom et description de la boutique
  - Date d'inscription (format + relative)
  - Statut visuel avec badges colorés
  - Date d'approbation si applicable
  
- ✅ **Actions disponibles** :
  - **Approuver** : `approve($artisanId)`
    - Passe `is_approved` à `true`
    - Enregistre `approved_at` avec timestamp
    - Notification de succès
    - Confirmation avant action
    
  - **Rejeter** : `reject($artisanId)`
    - Supprime l'artisan
    - Notification d'information
    - Confirmation avant action
    
- ✅ **État vide** si aucun résultat
- ✅ **Indicateur de chargement** pendant les requêtes

#### Code Important :
```php
// Approuver un artisan
public function approve($artisanId)
{
    $artisan = Artisan::findOrFail($artisanId);
    $artisan->update([
        'is_approved' => true,
        'approved_at' => now(),
    ]);
    $this->dispatch('notify', 'Artisan approuvé avec succès !');
}

// Recherche avec relations
$query = Artisan::with('user');
if ($this->search) {
    $query->where(function ($q) {
        $q->where('shop_name', 'like', '%' . $this->search . '%')
          ->orWhereHas('user', function ($userQuery) {
              $userQuery->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
          });
    });
}
```

---

### 3. **Page : Modération des Produits** (Livewire)

**Composant** : `App\Livewire\Admin\ProductModeration`  
**Vue** : `resources/views/livewire/admin/product-moderation.blade.php`  
**Route** : `/admin/products/moderation`

#### Fonctionnalités :
- ✅ **Grille de produits** avec pagination (12 par page)
- ✅ **Recherche en temps réel** (debounce 300ms) :
  - Nom du produit
  - Description
  - Nom de la boutique artisan
  
- ✅ **Filtres multiples** :
  - **Par catégorie** : Dropdown avec toutes les catégories actives
  - **Par statut** :
    - Tous
    - Publiés
    - Non publiés
    - En vedette
    
- ✅ **Affichage des produits** :
  - Image principale (ou placeholder SVG)
  - Badges visuels (Vedette, Masqué)
  - Compteur de vues
  - Nom et prix
  - Nom de l'artisan
  - Catégorie et stock
  
- ✅ **Actions disponibles** :
  - **Publier** : `publish($productId)` - Rend le produit visible
  - **Masquer** : `unpublish($productId)` - Cache le produit
  - **Vedette** : `toggleFeatured($productId)` - Bascule l'état featured
  - **Supprimer** : `delete($productId)` - Soft delete avec confirmation
  
- ✅ **Design responsive** en grille (1 col mobile, 2 tablet, 3 desktop)
- ✅ **État vide** si aucun résultat
- ✅ **Indicateur de chargement** pendant les requêtes

#### Code Important :
```php
// Mettre en vedette
public function toggleFeatured($productId)
{
    $product = Product::findOrFail($productId);
    $product->update(['is_featured' => !$product->is_featured]);
    
    $message = $product->is_featured 
        ? 'Produit mis en vedette !' 
        : 'Produit retiré de la vedette.';
    $this->dispatch('notify', $message);
}

// Query avec tous les filtres
$query = Product::with(['artisan.user', 'category', 'primaryImage']);

if ($this->statusFilter === 'featured') {
    $query->where('is_featured', true);
}
if ($this->categoryFilter) {
    $query->where('category_id', $this->categoryFilter);
}
```

---

### 4. **Page : Dashboard Statistiques** (Livewire)

**Composant** : `App\Livewire\Admin\Dashboard`  
**Vue** : `resources/views/livewire/admin/dashboard.blade.php`  
**Route** : `/admin/dashboard`

#### Fonctionnalités :
- ✅ **Sélecteur de période** :
  - 7 jours
  - 30 jours
  - Tout
  - Rechargement automatique des stats au changement
  
- ✅ **4 Cards de statistiques** :
  1. **Artisans** (Bleu)
     - Total artisans
     - Nombre en attente d'approbation
     - Icône groupe
     
  2. **Clients** (Vert)
     - Total clients
     - Icône utilisateurs
     
  3. **Produits** (Violet)
     - Total produits
     - Nombre de produits publiés
     - Icône boîte
     
  4. **Revenus** (Jaune)
     - Montant total des commandes
     - Nombre de commandes
     - Icône argent
  
- ✅ **Commandes Récentes** (5 dernières) :
  - Numéro de commande
  - Badge de statut coloré (pending, processing, delivered, etc.)
  - Client → Artisan
  - Date relative
  - Montant total
  
- ✅ **Produits Populaires** (Top 5 par vues) :
  - Image miniature
  - Nom du produit
  - Catégorie et nom de l'artisan
  - Nombre de vues
  - Prix
  
- ✅ **Design avec gradients** pour les cards
- ✅ **Grille responsive** (1 col mobile, 2 tablet, 4 desktop pour stats)
- ✅ **Rechargement automatique** via `changePeriod()`

#### Code Important :
```php
public function loadStatistics()
{
    // Stats artisans
    $this->totalArtisans = Artisan::count();
    $this->pendingArtisans = Artisan::where('is_approved', false)->count();
    
    // Stats clients
    $this->totalClients = User::role('client')->count();
    
    // Stats commandes avec période
    $query = Order::query();
    if ($this->period === '7days') {
        $query->where('created_at', '>=', now()->subDays(7));
    }
    
    $this->totalOrders = $query->count();
    $this->totalRevenue = $query->sum('total_amount');
    
    // Top produits par vues
    $this->topProducts = Product::with(['artisan', 'category'])
        ->where('is_published', true)
        ->orderBy('views_count', 'desc')
        ->take(5)
        ->get();
}
```

---

## 🛣️ Routes Configurées

Toutes les routes sont protégées par le middleware `role:admin` :

```php
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    
    // Livewire Components
    Route::get('/dashboard', ...)->name('dashboard');
    Route::get('/artisans/approval', ...)->name('artisans.approval');
    Route::get('/products/moderation', ...)->name('products.moderation');
    
    // Autres pages admin
    Route::get('/users', ...)->name('users.index');
    Route::get('/roles', ...)->name('roles.index');
    Route::get('/categories', ...)->name('categories.index');
    Route::get('/orders', ...)->name('orders.index');
    Route::get('/settings', ...)->name('settings');
});
```

**Liste complète** :
- `admin.dashboard` → Dashboard Livewire
- `admin.artisans.approval` → Validation Artisans Livewire
- `admin.products.moderation` → Modération Produits Livewire
- `admin.users.index` → Gestion utilisateurs
- `admin.roles.index` → Gestion rôles
- `admin.artisans.index` → Liste artisans
- `admin.categories.index` → Gestion catégories
- `admin.orders.index` → Gestion commandes
- `admin.settings` → Paramètres

---

## 🎨 Technologies Utilisées

### Backend
- **Laravel 11** : Framework PHP
- **Livewire 4.1** : Composants réactifs
- **Spatie Permission** : Gestion des rôles

### Frontend
- **TailwindCSS 4.0** : Styling moderne et responsive
- **Alpine.js 3.x** : Interactions légères (dropdowns, modals)
- **Heroicons** : Icônes SVG via TailwindCSS

### Base de Données
- **MySQL 8.0** : Stockage des données
- **6 Tables** : Categories, Artisans, Products, ProductImages, Orders, OrderItems

---

## 📦 Structure des Fichiers

```
app/
├── Livewire/
│   └── Admin/
│       ├── ArtisanApproval.php      # Composant validation artisans
│       ├── Dashboard.php            # Composant dashboard stats
│       └── ProductModeration.php    # Composant modération produits

resources/views/
├── components/
│   └── admin-layout.blade.php       # Layout principal admin
├── livewire/
│   └── admin/
│       ├── artisan-approval.blade.php
│       ├── dashboard.blade.php
│       └── product-moderation.blade.php
└── admin/
    ├── dashboard.blade.php          # Page wrapper dashboard
    ├── artisans/
    │   └── approval.blade.php       # Page wrapper validation
    └── products/
        └── moderation.blade.php     # Page wrapper modération

routes/
└── web.php                          # Routes admin configurées

database/seeders/
└── TestDataSeeder.php               # Données de test
```

---

## 🧪 Données de Test

Exécuter le seeder pour générer des données de test :

```bash
php artisan db:seed --class=TestDataSeeder
```

**Crée automatiquement** :
- 5 clients (client1@test.com → client5@test.com)
- 8 artisans (artisan1@test.com → artisan8@test.com)
  - 5 approuvés avec produits
  - 3 en attente de validation
- 24+ produits répartis dans différentes catégories
- 9+ commandes avec différents statuts

**Mot de passe pour tous** : `password`

---

## 🚀 Accès au Dashboard

1. **Se connecter en tant qu'admin** :
   - Email : `admin@artisanmarket.com`
   - Password : `password`

2. **Accéder aux pages Livewire** :
   - Dashboard : http://localhost:8000/admin/dashboard
   - Validation Artisans : http://localhost:8000/admin/artisans/approval
   - Modération Produits : http://localhost:8000/admin/products/moderation

---

## 🔧 Fonctionnalités Avancées

### Notifications Livewire

Système de notifications toast intégré dans le layout :

```javascript
// Dans un composant Livewire
$this->dispatch('notify', 'Message de succès !');

// Affichage automatique pendant 3 secondes
// Design vert avec Alpine.js
```

### Recherche en Temps Réel

Utilise `wire:model.live.debounce.300ms` pour :
- Éviter les requêtes excessives
- Mise à jour automatique sans rechargement
- Reset automatique de la pagination

### Pagination Livewire

```php
use WithPagination;

// Dans render()
$artisans = $query->latest()->paginate(10);

// Dans la vue
{{ $artisans->links() }}
```

### Confirmations d'Actions

```blade
<button wire:click="approve({{ $id }})"
        wire:confirm="Êtes-vous sûr de vouloir approuver cet artisan ?">
    Approuver
</button>
```

---

## 📊 Statistiques Dashboard

### Métriques Calculées

- **Artisans** : `Artisan::count()` + pending count
- **Clients** : `User::role('client')->count()`
- **Produits** : `Product::count()` + published count
- **Revenus** : `Order::sum('total_amount')` avec filtre période

### Filtres de Période

```php
if ($this->period === '7days') {
    $query->where('created_at', '>=', now()->subDays(7));
} elseif ($this->period === '30days') {
    $query->where('created_at', '>=', now()->subDays(30));
}
// 'all' = pas de filtre
```

---

## 🎯 Améliorations Futures Possibles

1. **Validation Artisans** :
   - [ ] Ajouter un champ "raison du rejet" avec textarea
   - [ ] Envoyer un email de notification à l'artisan (approuvé/rejeté)
   - [ ] Historique des actions (audit log)

2. **Modération Produits** :
   - [ ] Signalements de produits par clients
   - [ ] Commentaires de modération internes
   - [ ] Édition rapide inline des produits

3. **Dashboard** :
   - [ ] Graphiques avec Chart.js ou ApexCharts
   - [ ] Export des statistiques en PDF/Excel
   - [ ] Widgets personnalisables par admin

4. **Système de Notifications** :
   - [ ] Notifications persistantes en base de données
   - [ ] Marquer comme lu/non lu
   - [ ] Notifications en temps réel avec Pusher/Laravel Echo

---

## ✅ Conformité aux Exigences

| Exigence | Statut | Notes |
|----------|--------|-------|
| Layout admin avec sidebar | ✅ | Responsive + Alpine.js |
| Header avec notifications | ✅ | Cloche + dropdown + badge |
| Footer | ✅ | Copyright + version |
| Validation artisans | ✅ | Recherche + filtres + actions |
| Pagination artisans | ✅ | 10 par page |
| Recherche temps réel | ✅ | Debounce 300ms |
| Modération produits | ✅ | Grille + filtres + actions |
| Filtres catégorie/statut | ✅ | Dropdowns + rechargement auto |
| Dashboard statistiques | ✅ | 4 cards + période + listes |
| Routes protégées | ✅ | Middleware role:admin |
| TailwindCSS | ✅ | Classes utilitaires |
| Interactions Livewire | ✅ | wire:model.live, wire:click |
| Notifications feedback | ✅ | Toast Alpine.js |
| Code propre et commenté | ✅ | Docblocks + commentaires |

---

**Documentation mise à jour le** : 31 janvier 2026  
**Version de Livewire** : 4.1.0  
**Statut** : ✅ Dashboard Admin complet et fonctionnel
