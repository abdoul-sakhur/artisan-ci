# 🎯 ArtisanMarket - Guide de Démarrage Rapide

## ✅ Ce qui est déjà fait

### Infrastructure
- ✅ Laravel 11 configuré
- ✅ Base de données avec 6 tables
- ✅ 14 utilisateurs de test (admin, artisans, clients)
- ✅ 24 produits avec images
- ✅ 9 commandes
- ✅ Spatie Permission pour les rôles

### Modules complétés
- ✅ **Dashboard Admin** (3 composants Livewire)
- ✅ **Espace Artisan** (6 composants Livewire)

---

## 🚀 Pour tester l'application

### 1. Démarrer le serveur

```bash
cd c:\Users\DELL\artisan-ci\ArtisanMarket
php artisan serve
```

**URL** : http://127.0.0.1:8000

---

### 2. Se connecter

#### En tant qu'Admin
```
Email: admin@example.com
Mot de passe: password
```

**Dashboard** : http://127.0.0.1:8000/admin/dashboard

**Actions disponibles** :
- ✅ Voir les statistiques globales
- ✅ Valider/Rejeter les artisans
- ✅ Modérer les produits

---

#### En tant qu'Artisan
```
Email: artisan1@example.com
Mot de passe: password
```

**Dashboard** : http://127.0.0.1:8000/artisan/dashboard

**Actions disponibles** :
- ✅ Voir vos statistiques (produits, commandes, revenus)
- ✅ Gérer vos produits
- ✅ Ajouter un nouveau produit avec **images multiples**
- ✅ Voir et gérer vos commandes
- ✅ Modifier les paramètres de votre boutique

---

#### En tant qu'Artisan sans boutique (onboarding)

Créez un nouveau compte avec le rôle "artisan" :

1. Inscription : http://127.0.0.1:8000/register
2. Choisir le rôle "artisan"
3. Vous serez redirigé vers : http://127.0.0.1:8000/artisan/setup
4. **Configurez votre boutique** :
   - Nom de la boutique
   - Description
   - Logo (max 2MB)
   - Bannière (max 3MB)

---

#### En tant que Client
```
Email: client1@example.com
Mot de passe: password
```

**Dashboard** : http://127.0.0.1:8000/client/dashboard

⚠️ **Note** : L'espace client n'est pas encore développé

---

## 📋 Scénarios de test recommandés

### Scénario 1 : Onboarding Artisan
1. Créer un nouveau compte avec rôle "artisan"
2. Accéder à `/artisan/setup`
3. Remplir le formulaire de configuration
4. Uploader un logo et une bannière
5. Soumettre le formulaire
6. Vérifier la création du profil artisan dans la base de données
7. Vérifier que `is_approved = 0` (en attente)

---

### Scénario 2 : Validation Admin
1. Se connecter en tant qu'admin
2. Accéder à `/admin/artisans/approval`
3. Voir le nouvel artisan en attente
4. Cliquer sur "Approuver"
5. Vérifier que `is_approved = 1`
6. L'artisan devrait maintenant apparaître comme "Approuvé"

---

### Scénario 3 : Création de Produit
1. Se connecter en tant qu'artisan approuvé
2. Accéder à `/artisan/products/create`
3. Remplir le formulaire :
   - Nom : "Vase en céramique artisanale"
   - Description : "Magnifique vase fait à la main avec argile locale..."
   - Prix : 250.00 DH
   - Quantité : 5
   - Catégorie : Céramique
   - **Uploader 3-5 images**
   - Cocher "Publier le produit"
4. Soumettre
5. Vérifier la redirection vers `/artisan/products`
6. Voir le nouveau produit dans la liste

---

### Scénario 4 : Modification de Produit
1. Depuis `/artisan/products`
2. Cliquer sur "Modifier" d'un produit
3. Modifier le prix : 300.00 DH
4. Supprimer une image existante
5. Ajouter 2 nouvelles images
6. Enregistrer
7. Vérifier les modifications

---

### Scénario 5 : Gestion de Commandes
1. Accéder à `/artisan/orders`
2. Voir la liste des commandes
3. Filtrer par statut "pending"
4. Cliquer sur "Détails" d'une commande
5. Voir le modal avec :
   - Informations client
   - Produits commandés
   - Total
6. Changer le statut à "processing"
7. Puis "shipped"
8. Puis "delivered"

---

### Scénario 6 : Paramètres Boutique
1. Accéder à `/artisan/shop/settings`
2. Modifier le nom de la boutique
3. Modifier la description
4. Remplacer le logo
5. Remplacer la bannière
6. Enregistrer
7. Vérifier les changements dans le layout (sidebar)

---

## 🐛 Debug et vérifications

### Vérifier les routes
```bash
php artisan route:list --name=artisan
```

### Vérifier la base de données
```sql
-- Artisans en attente
SELECT * FROM artisans WHERE is_approved = 0;

-- Produits d'un artisan
SELECT * FROM products WHERE artisan_id = 1;

-- Images d'un produit
SELECT * FROM product_images WHERE product_id = 1;

-- Commandes
SELECT * FROM orders;
```

### Clear cache si problème
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 📁 Fichiers importants

### Composants Livewire Artisan
```
app/Livewire/Artisan/
├── ShopSetup.php          → Onboarding
├── Dashboard.php          → Stats
├── ProductList.php        → Liste produits
├── ProductForm.php        → CRUD produits
├── OrderList.php          → Commandes
└── ShopSettings.php       → Paramètres
```

### Vues Livewire
```
resources/views/livewire/artisan/
├── shop-setup.blade.php
├── dashboard.blade.php
├── product-list.blade.php
├── product-form.blade.php
├── order-list.blade.php
└── shop-settings.blade.php
```

### Layout
```
resources/views/components/artisan-layout.blade.php
```

---

## 🎨 Captures d'écran attendues

### Dashboard Artisan
- 4 cartes de statistiques (gradient violet)
- Liste des 5 dernières commandes
- Top 5 produits les plus vus

### Liste de Produits
- Grille de 3 colonnes
- Images des produits
- Badge "Publié" / "Brouillon"
- Actions : Publier, Modifier, Supprimer

### Formulaire de Produit
- Formulaire sur 2 colonnes (principal + sidebar)
- Zone de drag & drop pour images
- Aperçu des images uploadées
- Gestion des images existantes (en mode édition)

### Liste de Commandes
- Tableau avec filtres
- Badges de statut colorés
- Modal de détails

---

## 🔧 Dépannage

### Problème : "Class Livewire\... not found"
```bash
composer dump-autoload
php artisan config:clear
```

### Problème : Images ne s'affichent pas
```bash
php artisan storage:link
```

### Problème : Erreur 403 (Forbidden)
Vérifier que l'utilisateur a bien le rôle "artisan" :
```sql
SELECT u.email, r.name 
FROM users u 
JOIN model_has_roles mhr ON u.id = mhr.model_id 
JOIN roles r ON mhr.role_id = r.id;
```

### Problème : "Route not found"
```bash
php artisan route:clear
php artisan route:cache
```

---

## 📊 Statistiques du Dashboard Artisan

### Métriques affichées
1. **Total Produits** : Nombre de produits créés
2. **Produits Publiés** : Produits visibles publiquement
3. **Total Commandes** : Commandes reçues
4. **Commandes en Attente** : Status "pending"
5. **Revenus Total** : Somme de toutes les commandes (DH)
6. **Vues Total** : Nombre de vues sur tous les produits

### Widgets
- **Commandes Récentes** : 5 dernières avec statut
- **Produits les plus vus** : Top 5 par views_count

---

## 🎯 Prochaines étapes de développement

### Court terme (1-2 jours)
1. ✅ **Tester tous les scénarios** ci-dessus
2. ⏳ **Notifications Livewire** : Toaster pour les messages
3. ⏳ **Graphiques** : Chart.js pour les stats
4. ⏳ **Export CSV** : Produits et commandes

### Moyen terme (1 semaine)
1. ⏳ **Espace Client** : Navigation, panier, commandes
2. ⏳ **Page Publique** : Catalogue de produits
3. ⏳ **Recherche** : Filtre par catégorie, prix
4. ⏳ **Système d'avis** : Notation des produits

### Long terme (1 mois)
1. ⏳ **Paiement** : Intégration Stripe/PayPal
2. ⏳ **Email** : Notifications par email
3. ⏳ **Analytics** : Dashboard avancé
4. ⏳ **API** : Pour application mobile

---

## 📚 Documentation complète

1. **PROJECT_SUMMARY.md** : Vue d'ensemble complète
2. **ARTISAN_SPACE_LIVEWIRE.md** : Documentation technique détaillée
3. **ESPACE_ARTISAN_README.md** : Résumé espace artisan
4. **DATABASE_SCHEMA.md** : Schéma de la base de données
5. **ADMIN_DASHBOARD_LIVEWIRE.md** : Dashboard admin
6. **QUICK_START.md** : Ce fichier

---

## ✅ Checklist avant de tester

- [x] Base de données migrée
- [x] Seeders exécutés
- [x] Storage link créé
- [x] Serveur Laravel lancé
- [x] Comptes de test disponibles
- [x] Toutes les routes configurées
- [x] Tous les composants Livewire créés

---

## 🎉 Prêt à tester !

1. **Lancez le serveur** : `php artisan serve`
2. **Accédez à** : http://127.0.0.1:8000
3. **Connectez-vous** avec un compte de test
4. **Explorez** les différentes fonctionnalités

---

**Bon test ! 🚀**

Si vous rencontrez un problème, consultez les fichiers de documentation ou vérifiez les logs Laravel dans `storage/logs/`.

---

**Dernière mise à jour** : 16 janvier 2025
