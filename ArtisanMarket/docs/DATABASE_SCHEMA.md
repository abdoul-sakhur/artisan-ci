# Schéma de Base de Données - ArtisanMarket

## Vue d'ensemble

Le système ArtisanMarket utilise **6 tables principales** pour gérer la plateforme e-commerce artisanale avec authentification multi-rôles.

---

## 📋 Tables et Relations

### 1. **categories** (Catégories de produits)

Table pour classifier les produits artisanaux.

**Colonnes :**
- `id` (bigint, PK) - Identifiant unique
- `name` (varchar 255) - Nom de la catégorie
- `slug` (varchar 255, unique) - URL-friendly identifier
- `description` (text, nullable) - Description de la catégorie
- `is_active` (boolean, default: true) - Statut actif/inactif
- `created_at`, `updated_at` (timestamps)

**Index :**
- `slug` (unique)
- `name` (pour recherche)

**Relations :**
- `hasMany` → **products** (une catégorie a plusieurs produits)

**Modèle : `App\Models\Category`**
- Fillable: `name`, `slug`, `description`, `is_active`
- Scopes: `active()` - filtre les catégories actives
- Relations: `products()`, `publishedProducts()`

**Données par défaut :** 10 catégories créées via `CategorySeeder`
- Céramique, Textile, Bijoux, Décoration, Maroquinerie
- Bois, Verre, Métal, Papeterie, Cosmétiques

---

### 2. **artisans** (Profils artisans)

Table pour les profils d'artisans liés aux utilisateurs.

**Colonnes :**
- `id` (bigint, PK) - Identifiant unique
- `user_id` (bigint, FK → users.id) - Référence utilisateur
- `shop_name` (varchar 255) - Nom de la boutique
- `shop_description` (text, nullable) - Description de la boutique
- `shop_logo` (varchar 255, nullable) - Logo de la boutique
- `shop_banner` (varchar 255, nullable) - Bannière de la boutique
- `is_approved` (boolean, default: false) - Statut d'approbation
- `approved_at` (timestamp, nullable) - Date d'approbation
- `created_at`, `updated_at` (timestamps)

**Index :**
- `user_id` (unique, FK vers users)
- `shop_name` (pour recherche)

**Contraintes :**
- `CASCADE` sur suppression de l'utilisateur

**Relations :**
- `belongsTo` → **users** (un artisan appartient à un utilisateur)
- `hasMany` → **products** (un artisan a plusieurs produits)
- `hasMany` → **orders** (un artisan reçoit plusieurs commandes)

**Modèle : `App\Models\Artisan`**
- Fillable: `user_id`, `shop_name`, `shop_description`, `shop_logo`, `shop_banner`, `is_approved`, `approved_at`
- Casts: `is_approved` (boolean), `approved_at` (datetime)
- Scopes: `approved()` - filtre les artisans approuvés
- Relations: `user()`, `products()`, `orders()`

---

### 3. **products** (Produits artisanaux)

Table pour les produits créés par les artisans.

**Colonnes :**
- `id` (bigint, PK) - Identifiant unique
- `artisan_id` (bigint, FK → artisans.id) - Propriétaire artisan
- `category_id` (bigint, FK → categories.id) - Catégorie du produit
- `name` (varchar 255) - Nom du produit
- `slug` (varchar 255) - URL-friendly identifier
- `description` (text, nullable) - Description détaillée
- `price` (decimal 10,2) - Prix unitaire
- `quantity` (integer, default: 0) - Stock disponible
- `is_published` (boolean, default: false) - Statut publication
- `is_featured` (boolean, default: false) - Produit mis en avant
- `views_count` (integer, default: 0) - Nombre de vues
- `created_at`, `updated_at`, `deleted_at` (timestamps)

**Index :**
- Composite: `(artisan_id, slug)` (unique)
- `category_id` (FK vers categories)
- `name`, `price`, `is_published`, `is_featured` (pour recherche/tri)

**Contraintes :**
- `CASCADE` sur suppression artisan
- `SET NULL` sur suppression catégorie
- **SoftDeletes** activé

**Relations :**
- `belongsTo` → **artisans** (un produit appartient à un artisan)
- `belongsTo` → **categories** (un produit a une catégorie)
- `hasMany` → **product_images** (un produit a plusieurs images)
- `hasOne` → **product_images** (image principale via `is_primary`)
- `hasMany` → **order_items** (un produit dans plusieurs commandes)

**Modèle : `App\Models\Product`**
- Fillable: `artisan_id`, `category_id`, `name`, `slug`, `description`, `price`, `quantity`, `is_published`, `is_featured`, `views_count`
- Casts: `price` (decimal:2), `quantity` (integer), `is_published` (boolean), `is_featured` (boolean), `views_count` (integer)
- Traits: `SoftDeletes`
- Scopes: `published()`, `featured()`
- Relations: `artisan()`, `category()`, `images()`, `primaryImage()`, `orderItems()`
- Méthodes: `incrementViews()` - incrémente le compteur de vues

---

### 4. **product_images** (Images de produits)

Table pour les images associées aux produits.

**Colonnes :**
- `id` (bigint, PK) - Identifiant unique
- `product_id` (bigint, FK → products.id) - Référence produit
- `image_path` (varchar 255) - Chemin de l'image
- `is_primary` (boolean, default: false) - Image principale
- `sort_order` (integer, default: 0) - Ordre d'affichage
- `created_at`, `updated_at` (timestamps)

**Index :**
- `product_id` (FK vers products)
- Composite: `(product_id, sort_order)` (pour tri)

**Contraintes :**
- `CASCADE` sur suppression du produit

**Relations :**
- `belongsTo` → **products** (une image appartient à un produit)

**Modèle : `App\Models\ProductImage`**
- Fillable: `product_id`, `image_path`, `is_primary`, `sort_order`
- Casts: `is_primary` (boolean), `sort_order` (integer)
- Relations: `product()`
- Attributs: `getUrlAttribute()` - retourne l'URL complète de l'image

---

### 5. **orders** (Commandes)

Table pour les commandes passées par les clients.

**Colonnes :**
- `id` (bigint, PK) - Identifiant unique
- `user_id` (bigint, FK → users.id) - Client
- `artisan_id` (bigint, FK → artisans.id) - Artisan vendeur
- `order_number` (varchar 255, unique) - Numéro de commande unique
- `total_amount` (decimal 10,2) - Montant total
- `status` (enum) - Statut de la commande
  - `pending` (en attente)
  - `processing` (en traitement)
  - `shipped` (expédiée)
  - `delivered` (livrée)
  - `cancelled` (annulée)
  - `refunded` (remboursée)
- `shipping_address` (text, nullable) - Adresse de livraison
- `notes` (text, nullable) - Notes de commande
- `created_at`, `updated_at`, `deleted_at` (timestamps)

**Index :**
- `order_number` (unique)
- `user_id` (FK vers users)
- `artisan_id` (FK vers artisans)
- `status` (pour filtrage)

**Contraintes :**
- `CASCADE` sur suppression user/artisan
- **SoftDeletes** activé

**Relations :**
- `belongsTo` → **users** (une commande appartient à un client)
- `belongsTo` → **artisans** (une commande est destinée à un artisan)
- `hasMany` → **order_items** (une commande contient plusieurs articles)

**Modèle : `App\Models\Order`**
- Fillable: `user_id`, `artisan_id`, `order_number`, `total_amount`, `status`, `shipping_address`, `notes`
- Casts: `total_amount` (decimal:2)
- Traits: `SoftDeletes`
- Constantes: `STATUS_PENDING`, `STATUS_PROCESSING`, `STATUS_SHIPPED`, etc.
- Scopes: `pending()`, `processing()`, `byStatus($status)`
- Relations: `user()`, `artisan()`, `items()`
- Méthodes: `generateOrderNumber()` - génère un numéro unique

---

### 6. **order_items** (Articles de commande)

Table pour les articles individuels dans chaque commande.

**Colonnes :**
- `id` (bigint, PK) - Identifiant unique
- `order_id` (bigint, FK → orders.id) - Référence commande
- `product_id` (bigint, FK → products.id) - Référence produit
- `quantity` (integer) - Quantité commandée
- `unit_price` (decimal 10,2) - Prix unitaire au moment de la commande
- `subtotal` (decimal 10,2) - Sous-total (quantity × unit_price)
- `created_at`, `updated_at` (timestamps)

**Index :**
- `order_id` (FK vers orders)
- `product_id` (FK vers products)

**Contraintes :**
- `CASCADE` sur suppression de la commande
- `RESTRICT` sur suppression du produit (empêche suppression si commandé)

**Relations :**
- `belongsTo` → **orders** (un article appartient à une commande)
- `belongsTo` → **products** (un article référence un produit)

**Modèle : `App\Models\OrderItem`**
- Fillable: `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`
- Casts: `quantity` (integer), `unit_price` (decimal:2), `subtotal` (decimal:2)
- Relations: `order()`, `product()`
- Méthodes: `calculateSubtotal()` - calcule le sous-total

---

## 🔗 Diagramme Relationnel

```
users (table Laravel Breeze existante)
├─ hasOne → artisans (via user_id)
└─ hasMany → orders (via user_id)

artisans
├─ belongsTo → users
├─ hasMany → products (via artisan_id)
└─ hasMany → orders (via artisan_id)

categories
└─ hasMany → products (via category_id)

products
├─ belongsTo → artisans
├─ belongsTo → categories
├─ hasMany → product_images (via product_id)
└─ hasMany → order_items (via product_id)

product_images
└─ belongsTo → products

orders
├─ belongsTo → users (client)
├─ belongsTo → artisans (vendeur)
└─ hasMany → order_items (via order_id)

order_items
├─ belongsTo → orders
└─ belongsTo → products
```

---

## 📊 Récapitulatif des Migrations

| Migration | Table | Dépendances | Statut |
|-----------|-------|-------------|--------|
| `2026_01_31_001218_create_categories_table` | categories | Aucune | ✅ Exécutée |
| `2026_01_31_001218_create_artisans_table` | artisans | users | ✅ Exécutée |
| `2026_01_31_001219_create_products_table` | products | artisans, categories | ✅ Exécutée |
| `2026_01_31_001220_create_product_images_table` | product_images | products | ✅ Exécutée |
| `2026_01_31_001220_create_orders_table` | orders | users, artisans | ✅ Exécutée |
| `2026_01_31_001221_create_order_items_table` | order_items | orders, products | ✅ Exécutée |

---

## 🎯 Seeders Disponibles

1. **RoleSeeder** - Crée les 3 rôles (admin, artisan, client) avec permissions
2. **AdminSeeder** - Crée le compte admin par défaut
3. **CategorySeeder** - ✅ Crée 10 catégories artisanales

---

## 🧪 Test des Relations

Pour tester les relations dans Tinker :

```bash
# Vérifier les catégories
php artisan tinker --execute="echo App\Models\Category::count();"
# Résultat : 10

# Créer un artisan de test
php artisan tinker
$user = App\Models\User::first();
$artisan = App\Models\Artisan::create([
    'user_id' => $user->id,
    'shop_name' => 'Atelier Test',
    'shop_description' => 'Description test',
    'is_approved' => true,
    'approved_at' => now()
]);

# Créer un produit test
$product = App\Models\Product::create([
    'artisan_id' => $artisan->id,
    'category_id' => 1,
    'name' => 'Produit Test',
    'slug' => 'produit-test',
    'price' => 49.99,
    'quantity' => 10,
    'is_published' => true
]);

# Tester les relations
$product->artisan; // Retourne l'artisan
$product->category; // Retourne la catégorie
$artisan->products; // Retourne tous les produits de l'artisan
```

---

## 📝 Notes Importantes

1. **SoftDeletes** activé sur :
   - `products` (permet restauration de produits supprimés)
   - `orders` (historique des commandes)

2. **Indexes de performance** :
   - Tous les champs de recherche indexés (name, slug, status)
   - Clés étrangères indexées
   - Index composites pour requêtes fréquentes

3. **Contraintes CASCADE** :
   - Suppression d'un artisan → supprime ses produits
   - Suppression d'un produit → supprime ses images
   - Suppression d'une commande → supprime ses articles

4. **Enum status** sur `orders` :
   - Garantit l'intégrité des données
   - Évite les valeurs invalides
   - Facilite les filtres et statistiques

5. **Relations User** mises à jour :
   - `user()->artisan()` - accès au profil artisan
   - `user()->orders()` - historique de commandes client

---

**Documentation mise à jour le :** 31 janvier 2026  
**Version de Laravel :** 11  
**Statut :** ✅ Schéma complet et fonctionnel
