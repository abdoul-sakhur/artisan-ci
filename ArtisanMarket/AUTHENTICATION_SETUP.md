# 🎯 Configuration du système d'authentification multi-rôles - ArtisanMarket

## ✅ Checklist de configuration

- [x] Modèle User configuré avec HasRoles
- [x] 3 rôles créés en base de données (admin, artisan, client)
- [x] Middleware CheckRole fonctionnel
- [x] Admin par défaut créé
- [x] Routes protégées configurées

---

## 📦 Fichiers créés/modifiés

### 1. **Modèle User** - `app/Models/User.php`
✅ Déjà configuré avec le trait `HasRoles` de Spatie Permission

### 2. **RoleSeeder** - `database/seeders/RoleSeeder.php`
- Crée les 3 rôles : admin, artisan, client
- Crée les permissions associées
- Assigne les permissions aux rôles

### 3. **AdminSeeder** - `database/seeders/AdminSeeder.php`
- Crée l'admin par défaut : `admin@artisanmarket.com` / `password`
- Vérifie si l'admin existe déjà avant de le créer

### 4. **Middleware CheckRole** - `app/Http/Middleware/CheckRole.php`
- Vérifie l'authentification
- Vérifie la présence d'un rôle
- Vérifie les permissions d'accès

### 5. **Configuration Middleware** - `bootstrap/app.php`
- Enregistre l'alias `role` pour le middleware

### 6. **Routes** - `routes/web.php`
- Routes publiques
- Routes admin (prefix: `/admin`)
- Routes artisan (prefix: `/artisan`)
- Routes client (prefix: `/client`)
- Routes shop (accessibles à tous)

### 7. **Vues Dashboard**
- `resources/views/admin/dashboard.blade.php`
- `resources/views/artisan/dashboard.blade.php`
- `resources/views/client/dashboard.blade.php`

---

## 🚀 Commandes d'exécution

### **Étape 1 : Exécuter les seeders**

```powershell
# Exécuter tous les seeders
php artisan db:seed

# OU exécuter les seeders individuellement
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=AdminSeeder
```

### **Étape 2 : Vider le cache**

```powershell
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

### **Étape 3 : Tester le système**

```powershell
# Démarrer le serveur
php artisan serve

# Dans un autre terminal - Compiler les assets
npm run dev
```

---

## 🔐 Comptes de test

### **Administrateur par défaut**
- **Email:** `admin@artisanmarket.com`
- **Mot de passe:** `password`
- **Rôle:** admin
- **Accès:** Toutes les routes admin

⚠️ **IMPORTANT:** Changez ce mot de passe en production !

### **Créer un artisan de test**

```powershell
php artisan tinker
```

```php
$artisan = App\Models\User::create([
    'name' => 'Test Artisan',
    'email' => 'artisan@test.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);
$artisan->assignRole('artisan');
```

### **Créer un client de test**

```php
$client = App\Models\User::create([
    'name' => 'Test Client',
    'email' => 'client@test.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);
$client->assignRole('client');
```

---

## 🛣️ Structure des routes protégées

### **Routes Admin** (require role: admin)
- `/admin/dashboard` - Tableau de bord admin
- `/admin/users` - Gestion des utilisateurs
- `/admin/roles` - Gestion des rôles
- `/admin/artisans` - Gestion des artisans
- `/admin/statistics` - Statistiques globales

### **Routes Artisan** (require role: artisan)
- `/artisan/dashboard` - Tableau de bord artisan
- `/artisan/products` - Gestion des produits
- `/artisan/products/create` - Créer un produit
- `/artisan/orders` - Gestion des commandes
- `/artisan/statistics` - Statistiques de vente
- `/artisan/shop` - Configuration de la boutique

### **Routes Client** (require role: client)
- `/client/dashboard` - Tableau de bord client
- `/client/orders` - Mes commandes
- `/client/cart` - Mon panier
- `/client/favorites` - Mes favoris

### **Routes Shop** (publiques)
- `/shop` - Catalogue des produits
- `/shop/product/{id}` - Détail d'un produit
- `/shop/artisan/{id}` - Boutique d'un artisan
- `/shop/category/{slug}` - Produits par catégorie

---

## 🔒 Permissions créées

### **Permissions Admin**
- `manage-users` - Gérer les utilisateurs
- `manage-roles` - Gérer les rôles
- `manage-permissions` - Gérer les permissions
- `view-dashboard-admin` - Accès au dashboard admin

### **Permissions Artisan**
- `manage-own-products` - Gérer ses propres produits
- `manage-own-orders` - Gérer ses propres commandes
- `view-dashboard-artisan` - Accès au dashboard artisan
- `browse-products` - Parcourir les produits

### **Permissions Client**
- `browse-products` - Parcourir les produits
- `make-purchase` - Effectuer des achats
- `view-own-orders` - Voir ses propres commandes

---

## 🧪 Tests de fonctionnement

### **Test 1 : Connexion admin**
1. Aller sur `/login`
2. Se connecter avec `admin@artisanmarket.com` / `password`
3. Vérifier la redirection vers `/admin/dashboard`

### **Test 2 : Protection des routes**
1. Se connecter en tant que client
2. Essayer d'accéder à `/admin/dashboard`
3. Vérifier la redirection avec message d'erreur

### **Test 3 : Vérification des rôles**
```powershell
php artisan tinker
```

```php
// Vérifier les rôles
\Spatie\Permission\Models\Role::all();

// Vérifier les permissions
\Spatie\Permission\Models\Permission::all();

// Vérifier le rôle d'un utilisateur
$user = App\Models\User::find(1);
$user->roles;
$user->permissions;
```

---

## 🛠️ Middleware CheckRole - Détails

Le middleware `CheckRole` effectue 3 vérifications :

1. **Authentification** : Vérifie que l'utilisateur est connecté
   - Si non → Redirection vers `/login`

2. **Présence d'un rôle** : Vérifie que l'utilisateur a au moins un rôle
   - Si non → Déconnexion + Message d'erreur

3. **Permission d'accès** : Vérifie que l'utilisateur a le rôle requis
   - Si non → Redirection vers `/dashboard` + Message d'erreur

### **Utilisation dans les routes**

```php
// Un seul rôle requis
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Routes admin
});

// Plusieurs rôles autorisés (OR)
Route::middleware(['auth', 'role:admin,artisan'])->group(function () {
    // Routes accessibles aux admins ET artisans
});
```

---

## 📝 Prochaines étapes recommandées

1. ✅ Créer les contrôleurs pour chaque section
2. ✅ Créer les modèles (Product, Order, Category, etc.)
3. ✅ Créer les migrations pour les tables métier
4. ✅ Implémenter les vues Livewire
5. ✅ Ajouter la gestion des images
6. ✅ Implémenter le système de panier
7. ✅ Ajouter le système de paiement

---

## 🐛 Dépannage

### **Erreur : "Role does not exist"**
```powershell
# Réexécuter les seeders
php artisan db:seed --class=RoleSeeder
php artisan optimize:clear
```

### **Erreur : "Class 'Spatie\Permission\Traits\HasRoles' not found"**
```powershell
# Réinstaller le package
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### **Problème de cache**
```powershell
# Vider tous les caches
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📚 Documentation Spatie Permission

- [Documentation officielle](https://spatie.be/docs/laravel-permission)
- [GitHub Repository](https://github.com/spatie/laravel-permission)

---

✅ **Configuration terminée avec succès !**
