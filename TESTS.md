# 🧪 Test du Système Multi-Rôles

## Comptes de Test Disponibles

### 🛠 Admin
- **Email**: admin@artisanmarket.com
- **Password**: password
- **Accès**: /admin/dashboard

### 👨‍🎨 Artisan
- **Email**: artisan@test.com
- **Password**: password
- **Accès**: /artisan/dashboard

### 🛒 Client
- **Email**: client@test.com
- **Password**: password
- **Accès**: /dashboard

## Scénarios de Test

### Test 1: Connexion Admin
1. Aller sur http://localhost:8000/login
2. Se connecter avec admin@artisanmarket.com / password
3. ✅ Devrait rediriger vers /admin/dashboard
4. ✅ Devrait afficher le dashboard admin

### Test 2: Connexion Artisan
1. Se déconnecter
2. Se connecter avec artisan@test.com / password
3. ✅ Devrait rediriger vers /artisan/dashboard
4. ✅ Devrait afficher le dashboard artisan

### Test 3: Connexion Client
1. Se déconnecter
2. Se connecter avec client@test.com / password
3. ✅ Devrait rediriger vers /dashboard
4. ✅ Devrait afficher le dashboard client

### Test 4: Inscription nouveau client
1. S'inscrire avec un nouveau compte
2. ✅ Le rôle "client" devrait être assigné automatiquement
3. ✅ Devrait rediriger vers /dashboard

### Test 5: Protection des routes
1. Se connecter en tant que client
2. Essayer d'accéder à /admin/dashboard
3. ✅ Devrait être redirigé vers /dashboard avec un message d'erreur
4. Essayer d'accéder à /artisan/dashboard
5. ✅ Devrait être redirigé vers /dashboard avec un message d'erreur

## Vérifications en Base de Données

```bash
# Vérifier les rôles créés
php artisan tinker
>>> \Spatie\Permission\Models\Role::all()->pluck('name')
# Devrait afficher: ["admin", "artisan", "client"]

# Vérifier l'admin
>>> \App\Models\User::where('email', 'admin@artisanmarket.com')->first()->roles->pluck('name')
# Devrait afficher: ["admin"]

# Vérifier l'artisan
>>> \App\Models\User::where('email', 'artisan@test.com')->first()->roles->pluck('name')
# Devrait afficher: ["artisan"]

# Vérifier le client
>>> \App\Models\User::where('email', 'client@test.com')->first()->roles->pluck('name')
# Devrait afficher: ["client"]
```

## Commandes Utiles

```bash
# Réinitialiser et recréer tous les utilisateurs
php artisan migrate:fresh
php artisan db:seed

# Recréer seulement les rôles
php artisan db:seed --class=RoleSeeder

# Recréer l'admin
php artisan db:seed --class=AdminSeeder

# Recréer les utilisateurs de démo
php artisan db:seed --class=DemoUsersSeeder
```
