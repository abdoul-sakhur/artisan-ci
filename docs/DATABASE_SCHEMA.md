# 🗄️ Schéma de Base de Données - ArtisanMarket

## 📊 Diagramme des Relations

```
┌─────────────┐         ┌──────────────┐         ┌──────────────┐
│    users    │────────>│   artisans   │────────>│   products   │
│             │  1:1    │              │  1:N    │              │
│ - id        │         │ - id         │         │ - id         │
│ - name      │         │ - user_id FK │         │ - artisan_id │
│ - email     │         │ - shop_name  │         │ - category_id│
│ - password  │         │ - shop_slug  │         │ - name       │
└─────────────┘         │ - is_approved│         │ - price      │
       │                └──────────────┘         │ - quantity   │
       │                       │                 └──────────────┘
       │                       │                        │
       │                       │                        │ 1:N
       │                       │                        ▼
       │                       │                 ┌──────────────┐
       │                       │                 │product_images│
       │                       │                 │              │
       │                       │                 │ - id         │
       │                       │                 │ - product_id │
       │                       │                 │ - image_url  │
       │                       │                 │ - is_primary │
       │                       │                 └──────────────┘
       │                       │
       │ 1:N                   │ 1:N
       ▼                       ▼
┌─────────────┐         ┌──────────────┐
│   orders    │<────────┤ order_items  │
│             │  1:N    │              │
│ - id        │         │ - id         │
│ - user_id   │         │ - order_id   │
│ - artisan_id│         │ - product_id │
│ - order_#   │         │ - quantity   │
│ - status    │         │ - unit_price │
│ - total     │         │ - subtotal   │
└─────────────┘         └──────────────┘

       ┌──────────────┐
       │  categories  │
       │              │
       │ - id         │
       │ - name       │────────> products.category_id
       │ - slug       │
       │ - is_active  │
       └──────────────┘
```

## 📋 Tables Détaillées

### 1️⃣ Table `artisans`

**Description** : Profils des artisans avec leurs boutiques en ligne

| Colonne | Type | Nullable | Défaut | Description |
|---------|------|----------|--------|-------------|
| id | bigint unsigned | ❌ | AUTO | Identifiant unique |
| user_id | bigint unsigned | ❌ | - | Référence vers users (unique) |
| shop_name | varchar(255) | ❌ | - | Nom de la boutique |
| shop_slug | varchar(255) | ❌ | - | URL slug (unique) |
| description | text | ✅ | null | Description courte |
| bio | text | ✅ | null | Biographie détaillée |
| logo_url | varchar(255) | ✅ | null | Logo de la boutique |
| cover_image_url | varchar(255) | ✅ | null | Image de couverture |
| is_approved | boolean | ❌ | false | Statut d'approbation |
| approved_at | timestamp | ✅ | null | Date d'approbation |
| approved_by | bigint unsigned | ✅ | null | Admin qui a approuvé |
| created_at | timestamp | ❌ | now() | Date de création |
| updated_at | timestamp | ❌ | now() | Date de mise à jour |
| deleted_at | timestamp | ✅ | null | Soft delete |

**Index**
- PRIMARY KEY (`id`)
- UNIQUE (`user_id`, `shop_slug`)
- INDEX (`is_approved`)

**Clés étrangères**
- `user_id` → `users.id` (onDelete: CASCADE)
- `approved_by` → `users.id` (onDelete: SET NULL)

---

### 2️⃣ Table `categories`

**Description** : Catégories d'œuvres artisanales

| Colonne | Type | Nullable | Défaut | Description |
|---------|------|----------|--------|-------------|
| id | bigint unsigned | ❌ | AUTO | Identifiant unique |
| name | varchar(255) | ❌ | - | Nom de la catégorie |
| slug | varchar(255) | ❌ | - | URL slug (unique) |
| description | text | ✅ | null | Description |
| image_url | varchar(255) | ✅ | null | Image représentative |
| is_active | boolean | ❌ | true | Statut actif |
| created_at | timestamp | ❌ | now() | Date de création |
| updated_at | timestamp | ❌ | now() | Date de mise à jour |

**Index**
- PRIMARY KEY (`id`)
- UNIQUE (`slug`)
- INDEX (`is_active`)

**Catégories pré-remplies** (10)
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

---

### 3️⃣ Table `products`

**Description** : Œuvres artisanales à vendre

| Colonne | Type | Nullable | Défaut | Description |
|---------|------|----------|--------|-------------|
| id | bigint unsigned | ❌ | AUTO | Identifiant unique |
| artisan_id | bigint unsigned | ❌ | - | Artisan propriétaire |
| category_id | bigint unsigned | ❌ | - | Catégorie |
| name | varchar(255) | ❌ | - | Nom du produit |
| slug | varchar(255) | ❌ | - | URL slug (unique) |
| description | text | ✅ | null | Description |
| price | decimal(10,2) | ❌ | - | Prix unitaire |
| quantity | integer | ❌ | 0 | Stock disponible |
| sku | varchar(100) | ❌ | AUTO | Référence produit |
| is_published | boolean | ❌ | false | Publié ? |
| is_featured | boolean | ❌ | false | Mis en avant ? |
| views_count | integer | ❌ | 0 | Nombre de vues |
| created_at | timestamp | ❌ | now() | Date de création |
| updated_at | timestamp | ❌ | now() | Date de mise à jour |

**Index**
- PRIMARY KEY (`id`)
- UNIQUE (`slug`, `sku`)
- INDEX (`artisan_id`, `category_id`, `is_published`, `is_featured`)

**Clés étrangères**
- `artisan_id` → `artisans.id` (onDelete: CASCADE)
- `category_id` → `categories.id` (onDelete: RESTRICT)

**Scopes disponibles**
- `published()` - Produits publiés
- `featured()` - Produits mis en avant
- `inStock()` - Produits en stock (quantity > 0)

---

### 4️⃣ Table `product_images`

**Description** : Images des produits (galerie)

| Colonne | Type | Nullable | Défaut | Description |
|---------|------|----------|--------|-------------|
| id | bigint unsigned | ❌ | AUTO | Identifiant unique |
| product_id | bigint unsigned | ❌ | - | Produit associé |
| image_url | varchar(255) | ❌ | - | URL de l'image |
| is_primary | boolean | ❌ | false | Image principale ? |
| sort_order | integer | ❌ | 0 | Ordre d'affichage |
| created_at | timestamp | ❌ | now() | Date de création |
| updated_at | timestamp | ❌ | now() | Date de mise à jour |

**Index**
- PRIMARY KEY (`id`)
- INDEX (`product_id`, `is_primary`, `sort_order`)

**Clés étrangères**
- `product_id` → `products.id` (onDelete: CASCADE)

---

### 5️⃣ Table `orders`

**Description** : Commandes des clients

| Colonne | Type | Nullable | Défaut | Description |
|---------|------|----------|--------|-------------|
| id | bigint unsigned | ❌ | AUTO | Identifiant unique |
| order_number | varchar(100) | ❌ | AUTO | Numéro de commande |
| user_id | bigint unsigned | ❌ | - | Client |
| artisan_id | bigint unsigned | ❌ | - | Artisan vendeur |
| total_amount | decimal(10,2) | ❌ | 0.00 | Montant total |
| status | enum | ❌ | pending | Statut de la commande |
| shipping_address | json | ❌ | - | Adresse de livraison |
| created_at | timestamp | ❌ | now() | Date de création |
| updated_at | timestamp | ❌ | now() | Date de mise à jour |

**Status possibles**
- `pending` - En attente
- `confirmed` - Confirmée
- `processing` - En préparation
- `shipped` - Expédiée
- `delivered` - Livrée
- `cancelled` - Annulée

**Structure JSON `shipping_address`**
```json
{
  "name": "Jean Dupont",
  "address": "123 Rue de la Paix",
  "city": "Paris",
  "postal_code": "75001",
  "country": "France",
  "phone": "0612345678"
}
```

**Index**
- PRIMARY KEY (`id`)
- UNIQUE (`order_number`)
- INDEX (`user_id`, `artisan_id`, `status`)

**Clés étrangères**
- `user_id` → `users.id` (onDelete: RESTRICT)
- `artisan_id` → `artisans.id` (onDelete: RESTRICT)

---

### 6️⃣ Table `order_items`

**Description** : Lignes de commande (détails)

| Colonne | Type | Nullable | Défaut | Description |
|---------|------|----------|--------|-------------|
| id | bigint unsigned | ❌ | AUTO | Identifiant unique |
| order_id | bigint unsigned | ❌ | - | Commande associée |
| product_id | bigint unsigned | ❌ | - | Produit commandé |
| quantity | integer | ❌ | 1 | Quantité |
| unit_price | decimal(10,2) | ❌ | - | Prix unitaire |
| subtotal | decimal(10,2) | ❌ | AUTO | Sous-total |
| created_at | timestamp | ❌ | now() | Date de création |
| updated_at | timestamp | ❌ | now() | Date de mise à jour |

**Index**
- PRIMARY KEY (`id`)
- INDEX (`order_id`, `product_id`)

**Clés étrangères**
- `order_id` → `orders.id` (onDelete: CASCADE)
- `product_id` → `products.id` (onDelete: RESTRICT)

**Calcul automatique**
Le `subtotal` est calculé automatiquement : `quantity × unit_price`

---

## 🔧 Modèles Eloquent

### Relations implémentées

```php
// User
$user->artisan()        // 1:1 → Artisan
$user->orders()         // 1:N → Orders
$user->isArtisan()      // bool
$user->isApprovedArtisan() // bool

// Artisan
$artisan->user()        // N:1 → User
$artisan->products()    // 1:N → Products
$artisan->orders()      // 1:N → Orders
$artisan->approvedBy()  // N:1 → User (admin)
$artisan->approve($admin) // Method
$artisan->reject()      // Method

// Category
$category->products()   // 1:N → Products
$category->active()     // Scope

// Product
$product->artisan()     // N:1 → Artisan
$product->category()    // N:1 → Category
$product->images()      // 1:N → ProductImages
$product->primaryImage() // 1:1 → ProductImage
$product->orderItems()  // 1:N → OrderItems
$product->incrementViews() // Method
$product->canPurchase($qty) // Method

// Order
$order->user()          // N:1 → User
$order->artisan()       // N:1 → Artisan
$order->items()         // 1:N → OrderItems
$order->pending()       // Scope
$order->confirmed()     // Scope
$order->delivered()     // Scope

// OrderItem
$orderItem->order()     // N:1 → Order
$orderItem->product()   // N:1 → Product
// Auto-calcul du subtotal dans boot()
```

---

## 🌱 Seeders & Factories

### Seeders disponibles
- `RoleSeeder` - 3 rôles (admin, artisan, client)
- `AdminSeeder` - Compte admin par défaut
- `DemoUsersSeeder` - Comptes de test
- `CategorySeeder` - 10 catégories artisanales

### Factories disponibles
- `ArtisanFactory` - States: approved(), pending()
- `ProductFactory` - States: published(), featured(), outOfStock()
- `OrderFactory` - Génère orders avec shipping_address JSON
- `OrderItemFactory` - Génère lignes de commande
- `ProductImageFactory` - Génère images de produits
- `CategoryFactory` - Génère catégories personnalisées

---

## 📦 Commandes utiles

```bash
# Réinitialiser et remplir la DB
php artisan migrate:fresh --seed

# Seeder spécifique
php artisan db:seed --class=CategorySeeder

# Créer des données de test
php artisan tinker
>>> Artisan::factory()->approved()->count(5)->create()
>>> Product::factory()->published()->count(20)->create()
```

---

**Créé le** : 31 janvier 2026  
**Version** : 1.0 (ÉTAPE 3 complétée)
