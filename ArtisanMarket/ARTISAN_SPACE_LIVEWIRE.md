# Espace Artisan - Documentation

## Vue d'ensemble

L'espace artisan est une interface complète permettant aux artisans de gérer leur boutique, leurs produits et leurs commandes sur ArtisanMarket. Il utilise **Livewire 4.1** pour une expérience interactive sans rechargement de page.

---

## Architecture

### Composants Livewire créés

#### 1. **ShopSetup** (`App\Livewire\Artisan\ShopSetup`)
- **Objectif** : Onboarding pour les artisans qui n'ont pas encore configuré leur boutique
- **Fonctionnalités** :
  - Formulaire de création de boutique
  - Upload de logo (max 2MB)
  - Upload de bannière (max 3MB)
  - Validation en temps réel
  - Création du profil artisan (status: en attente d'approbation)

**Vue** : `resources/views/livewire/artisan/shop-setup.blade.php`

**Route** : `/artisan/setup` (accessible sans profil artisan)

---

#### 2. **Dashboard** (`App\Livewire\Artisan\Dashboard`)
- **Objectif** : Tableau de bord avec statistiques et aperçu
- **Fonctionnalités** :
  - 4 cartes de statistiques (Produits, Commandes, Revenus, Vues)
  - Liste des 5 dernières commandes
  - Top 5 des produits les plus vus
  - Redirection automatique vers setup si pas de boutique

**Vue** : `resources/views/livewire/artisan/dashboard.blade.php`

**Route** : `/artisan/dashboard`

**Statistiques calculées** :
- `totalProducts` : Nombre total de produits
- `publishedProducts` : Produits publiés
- `totalOrders` : Toutes les commandes
- `pendingOrders` : Commandes en attente
- `totalRevenue` : Revenus cumulés (DH)
- `totalViews` : Vues totales sur tous les produits

---

#### 3. **ProductList** (`App\Livewire\Artisan\ProductList`)
- **Objectif** : Liste et gestion des produits
- **Fonctionnalités** :
  - Recherche en temps réel (nom, description)
  - Filtrage par statut (tous, publiés, non publiés)
  - Publier/Dépublier un produit
  - Modifier un produit
  - Supprimer un produit (soft delete)
  - Pagination (12 produits/page)
  - Affichage en grille responsive

**Vue** : `resources/views/livewire/artisan/product-list.blade.php`

**Route** : `/artisan/products`

---

#### 4. **ProductForm** (`App\Livewire\Artisan\ProductForm`)
- **Objectif** : Création et édition de produits
- **Fonctionnalités** :
  - Mode création ET mode édition
  - Upload d'images multiples (max 5 images, 2MB chacune)
  - Gestion des images existantes (marquage pour suppression)
  - Aperçu en temps réel des nouvelles images
  - Sélection de catégorie
  - Prix et quantité disponible
  - Publication immédiate ou brouillon
  - Validation en temps réel

**Vue** : `resources/views/livewire/artisan/product-form.blade.php`

**Routes** : 
- `/artisan/products/create` (création)
- `/artisan/products/{id}/edit` (édition)

**Champs validés** :
- `name` : min 3 caractères
- `description` : min 20 caractères
- `price` : > 0
- `quantity_available` : >= 0
- `category_id` : existe dans la table categories
- `newImages.*` : image, max 2MB

**Upload d'images** :
- Stockage : `storage/app/public/products/`
- Nom unique : `uniqid() + extension`
- Table `product_images` : image_url, sort_order, is_primary

---

#### 5. **OrderList** (`App\Livewire\Artisan\OrderList`)
- **Objectif** : Gestion des commandes reçues
- **Fonctionnalités** :
  - Liste des commandes contenant des produits de l'artisan
  - Recherche par numéro ou nom client
  - Filtrage par statut (pending, processing, shipped, delivered)
  - Modal de détails de commande
  - Changement de statut
  - Badge de notification pour pending orders
  - Pagination (15 commandes/page)

**Vue** : `resources/views/livewire/artisan/order-list.blade.php`

**Route** : `/artisan/orders`

**Statuts disponibles** :
- `pending` : En attente (jaune)
- `processing` : En traitement (bleu)
- `shipped` : Expédiée (violet)
- `delivered` : Livrée (vert)

---

#### 6. **ShopSettings** (`App\Livewire\Artisan\ShopSettings`)
- **Objectif** : Modification des paramètres de la boutique
- **Fonctionnalités** :
  - Édition du nom de la boutique
  - Édition de la description
  - Remplacement du logo (upload avec aperçu)
  - Remplacement de la bannière (upload avec aperçu)
  - Suppression automatique des anciens fichiers
  - Validation en temps réel

**Vue** : `resources/views/livewire/artisan/shop-settings.blade.php`

**Route** : `/artisan/shop/settings`

---

## Layout Artisan

**Fichier** : `resources/views/components/artisan-layout.blade.php`

**Caractéristiques** :
- Sidebar violet/indigo avec gradient
- Affichage du logo et nom de la boutique
- Badge d'approbation (En attente / Approuvé)
- Navigation :
  - Dashboard
  - Produits
  - Commandes
  - Paramètres
- Badge de commandes en attente
- Responsive (mobile menu)
- Zone de contenu principale avec padding

---

## Routes configurées

### Groupe Artisan (middleware: auth, verified, role:artisan)

```php
// Setup boutique (accessible sans profil artisan)
GET /artisan/setup → shop-setup.blade.php

// Dashboard
GET /artisan/dashboard → dashboard.blade.php

// Produits
GET /artisan/products → products/index.blade.php (ProductList)
GET /artisan/products/create → products/create.blade.php (ProductForm)
GET /artisan/products/{id}/edit → products/edit.blade.php (ProductForm avec productId)

// Commandes
GET /artisan/orders → orders/index.blade.php (OrderList)

// Paramètres
GET /artisan/shop/settings → shop-settings.blade.php (ShopSettings)
```

---

## Base de données

### Tables utilisées

#### `artisans`
- `id`
- `user_id` (FK users)
- `shop_name`
- `shop_description`
- `shop_logo` (path)
- `shop_banner` (path)
- `is_approved` (boolean)
- `timestamps`

#### `products`
- `id`
- `artisan_id` (FK artisans)
- `category_id` (FK categories)
- `name`
- `description`
- `price`
- `quantity_available`
- `is_published`
- `views_count`
- `timestamps`
- `deleted_at` (soft delete)

#### `product_images`
- `id`
- `product_id` (FK products)
- `image_url`
- `sort_order`
- `is_primary` (boolean)
- `timestamps`

#### `orders`
- `id`
- `user_id` (FK users - client)
- `order_number`
- `total_amount`
- `status` (pending, processing, shipped, delivered)
- `timestamps`

#### `order_items`
- `id`
- `order_id` (FK orders)
- `product_id` (FK products)
- `quantity`
- `price` (prix au moment de la commande)
- `timestamps`

---

## Stockage des fichiers

### Configuration
- **Disk** : `public` (symlink vers `storage/app/public`)
- **Lien symbolique** : `php artisan storage:link` (déjà créé)

### Dossiers
```
storage/app/public/
├── shops/
│   ├── logos/        → Logos des boutiques
│   └── banners/      → Bannières des boutiques
└── products/         → Images des produits
```

### Accès public
- URL : `Storage::url($path)`
- Exemple : `Storage::url('products/abc123.jpg')` → `/storage/products/abc123.jpg`

---

## Fonctionnalités clés

### 1. Upload d'images avec Livewire

**Trait utilisé** : `WithFileUploads`

**Exemple** :
```php
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;
    
    public $newImages = [];
    
    // Aperçu temporaire
    @foreach($newImages as $image)
        <img src="{{ $image->temporaryUrl() }}">
    @endforeach
    
    // Stockage
    $path = $image->store('products', 'public');
}
```

### 2. Validation en temps réel

**Méthode** : `updated($propertyName)`

```php
public function updated($propertyName)
{
    $this->validateOnly($propertyName);
}
```

### 3. Pagination avec Livewire

**Trait** : `WithPagination`

```php
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;
    
    $products = $query->paginate(12);
    
    // Reset sur recherche
    public function updatingSearch()
    {
        $this->resetPage();
    }
}
```

### 4. Notifications

**Événement Livewire** : `dispatch('notify')`

```php
$this->dispatch('notify', [
    'message' => 'Produit créé !',
    'type' => 'success'
]);
```

**À implémenter dans le layout** : listener Alpine.js ou Toastr

---

## Sécurité

### Vérifications implémentées

1. **Propriété du produit** : Vérifier `product->artisan_id === Auth::user()->artisan->id`
2. **Propriété de la commande** : Vérifier que la commande contient au moins un produit de l'artisan
3. **Validation des fichiers** : Type image, taille max
4. **Middleware de rôle** : `role:artisan` sur toutes les routes

### Exemple
```php
public function deleteProduct($productId)
{
    $product = Product::findOrFail($productId);
    
    if ($product->artisan_id !== Auth::user()->artisan->id) {
        $this->dispatch('notify', ['message' => 'Accès refusé.', 'type' => 'error']);
        return;
    }
    
    $product->delete();
}
```

---

## Tests suggérés

### Tests manuels à effectuer

1. **Onboarding**
   - [ ] Accéder à `/artisan/setup` sans profil artisan
   - [ ] Uploader logo et bannière
   - [ ] Valider le formulaire
   - [ ] Vérifier création dans la table `artisans`

2. **Dashboard**
   - [ ] Voir les statistiques correctes
   - [ ] Vérifier les commandes récentes
   - [ ] Vérifier les produits les plus vus

3. **Produits**
   - [ ] Créer un produit avec 5 images
   - [ ] Modifier un produit (ajouter/supprimer images)
   - [ ] Publier/dépublier un produit
   - [ ] Supprimer un produit
   - [ ] Rechercher et filtrer

4. **Commandes**
   - [ ] Voir les commandes
   - [ ] Filtrer par statut
   - [ ] Ouvrir le modal de détails
   - [ ] Changer le statut

5. **Paramètres**
   - [ ] Modifier le nom de la boutique
   - [ ] Remplacer le logo
   - [ ] Remplacer la bannière
   - [ ] Vérifier suppression des anciens fichiers

---

## Améliorations futures possibles

1. **Notifications temps réel** : Toastr ou Notifications Livewire
2. **Graphiques** : Chart.js pour les statistiques
3. **Export** : Export CSV des commandes/produits
4. **Bulk actions** : Sélection multiple pour publier/supprimer
5. **Drag & drop** : Pour réordonner les images
6. **Stock alerts** : Notification quand stock bas
7. **Reviews** : Affichage des avis clients
8. **Analytics** : Google Analytics intégration

---

## Dépendances

- **Laravel 11**
- **Livewire 4.1.0**
- **TailwindCSS 4.0**
- **Alpine.js 3.x** (pour les modaux)
- **Spatie Laravel Permission** (gestion des rôles)

---

## Commandes utiles

```bash
# Créer un composant Livewire
php artisan make:livewire Artisan/ComponentName

# Lien symbolique storage
php artisan storage:link

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Livewire assets
php artisan livewire:publish --assets
```

---

## Support

Pour toute question ou bug, référez-vous à :
- Documentation Livewire : https://livewire.laravel.com
- Documentation Laravel : https://laravel.com/docs/11.x
- Repository : ArtisanMarket

---

**Dernière mise à jour** : 2025-01-16
**Version** : 1.0
**Développeur** : ArtisanMarket Team
