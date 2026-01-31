# 📚 ArtisanMarket - Index de Documentation

Bienvenue dans la documentation complète du projet **ArtisanMarket** !

---

## 🗂️ Organisation de la documentation

### 1. 🚀 **QUICK_START.md**
**Pour qui ?** : Développeurs qui veulent tester rapidement l'application

**Contenu** :
- Instructions de démarrage du serveur
- Comptes de test (admin, artisan, client)
- Scénarios de test détaillés (6 scénarios complets)
- Dépannage et debug
- Checklist avant de tester

**Commencez ici si** : Vous voulez tester l'application immédiatement

---

### 2. 📊 **PROJECT_SUMMARY.md**
**Pour qui ?** : Chefs de projet, développeurs qui rejoignent le projet

**Contenu** :
- Vue d'ensemble complète du projet
- Architecture technique (stack, rôles, modules)
- Structure complète des fichiers
- Routes principales
- Statistiques du projet (lignes de code, composants)
- Timeline et roadmap

**Commencez ici si** : Vous voulez comprendre l'architecture globale

---

### 3. 🗄️ **DATABASE_SCHEMA.md**
**Pour qui ?** : Développeurs backend, DBA

**Contenu** :
- Schéma complet de la base de données (6 tables)
- Relations entre les modèles
- Migrations Laravel
- Seeders et données de test
- Exemples de requêtes SQL

**Commencez ici si** : Vous travaillez sur la base de données

---

### 4. 👨‍💼 **ADMIN_DASHBOARD_LIVEWIRE.md**
**Pour qui ?** : Développeurs travaillant sur l'espace admin

**Contenu** :
- Documentation du dashboard admin
- 3 composants Livewire (ArtisanApproval, ProductModeration, Dashboard)
- Routes admin
- Fonctionnalités de validation et modération
- Code examples

**Commencez ici si** : Vous développez ou modifiez l'espace admin

---

### 5. 🎨 **ARTISAN_SPACE_LIVEWIRE.md** ⭐ **PRINCIPAL**
**Pour qui ?** : Développeurs travaillant sur l'espace artisan

**Contenu** (30+ pages) :
- Documentation complète de l'espace artisan
- 6 composants Livewire détaillés
- Architecture et fonctionnalités
- Upload d'images multiples
- Validation en temps réel
- Sécurité et bonnes pratiques
- Tests suggérés

**Commencez ici si** : Vous développez ou modifiez l'espace artisan

---

### 6. 🛍️ **ESPACE_ARTISAN_README.md**
**Pour qui ?** : Résumé rapide de l'espace artisan

**Contenu** :
- Résumé des 6 composants Livewire
- Tableau récapitulatif
- Fonctionnalités clés
- Structure des fichiers
- Checklist de tests

**Commencez ici si** : Vous voulez un aperçu rapide de l'espace artisan

---

## 🎯 Parcours recommandés

### 👨‍💻 Nouveau développeur sur le projet
1. **PROJECT_SUMMARY.md** → Vue d'ensemble
2. **DATABASE_SCHEMA.md** → Comprendre les données
3. **QUICK_START.md** → Tester l'application
4. **ARTISAN_SPACE_LIVEWIRE.md** OU **ADMIN_DASHBOARD_LIVEWIRE.md** selon votre rôle

---

### 🧪 Testeur / QA
1. **QUICK_START.md** → Scénarios de test
2. **ESPACE_ARTISAN_README.md** → Fonctionnalités à tester
3. **PROJECT_SUMMARY.md** → Comprendre les modules

---

### 🏗️ Architecte / Chef de projet
1. **PROJECT_SUMMARY.md** → Architecture globale
2. **DATABASE_SCHEMA.md** → Modèle de données
3. **ARTISAN_SPACE_LIVEWIRE.md** → Détails techniques

---

### 🎨 Designer / Frontend
1. **QUICK_START.md** → Lancer l'app
2. **ESPACE_ARTISAN_README.md** → UI/UX de l'espace artisan
3. **ADMIN_DASHBOARD_LIVEWIRE.md** → UI/UX de l'espace admin

---

## 📖 Guide de lecture par besoin

### "Je veux tester l'application maintenant"
→ **QUICK_START.md**

### "Je dois comprendre comment fonctionne l'upload d'images multiples"
→ **ARTISAN_SPACE_LIVEWIRE.md** (section ProductForm)

### "Je dois ajouter une nouvelle table en base"
→ **DATABASE_SCHEMA.md** (section Relations et Migrations)

### "Je dois comprendre le système de rôles"
→ **PROJECT_SUMMARY.md** (section Système de rôles)

### "Je dois modifier la validation des artisans"
→ **ADMIN_DASHBOARD_LIVEWIRE.md** (section ArtisanApproval)

### "Je dois modifier le dashboard artisan"
→ **ARTISAN_SPACE_LIVEWIRE.md** (section Dashboard)

### "Je dois comprendre la structure complète du projet"
→ **PROJECT_SUMMARY.md** (section Structure complète)

---

## 📂 Fichiers du projet

### Documentation (6 fichiers)
```
📚 Documentation/
├── 📄 INDEX.md                          → Ce fichier (index général)
├── 🚀 QUICK_START.md                    → Guide de démarrage rapide
├── 📊 PROJECT_SUMMARY.md                → Vue d'ensemble complète
├── 🗄️ DATABASE_SCHEMA.md                → Schéma base de données
├── 👨‍💼 ADMIN_DASHBOARD_LIVEWIRE.md      → Dashboard admin
├── 🎨 ARTISAN_SPACE_LIVEWIRE.md         → Espace artisan (PRINCIPAL)
└── 🛍️ ESPACE_ARTISAN_README.md          → Résumé espace artisan
```

### Code source
```
ArtisanMarket/
├── app/
│   ├── Http/
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   ├── Livewire/
│   │   ├── Admin/ (3 composants)
│   │   └── Artisan/ (6 composants)
│   └── Models/ (7 modèles)
│
├── database/
│   ├── migrations/ (6 tables)
│   └── seeders/ (6 seeders)
│
├── resources/
│   └── views/
│       ├── components/ (2 layouts)
│       └── livewire/ (9 vues)
│
└── routes/
    └── web.php (30+ routes)
```

---

## 🔍 Recherche rapide

### Par fonctionnalité

| Fonctionnalité | Documentation | Code |
|----------------|---------------|------|
| Onboarding artisan | ARTISAN_SPACE_LIVEWIRE.md | `app/Livewire/Artisan/ShopSetup.php` |
| Upload images multiples | ARTISAN_SPACE_LIVEWIRE.md | `app/Livewire/Artisan/ProductForm.php` |
| Dashboard stats | ARTISAN_SPACE_LIVEWIRE.md | `app/Livewire/Artisan/Dashboard.php` |
| Gestion commandes | ARTISAN_SPACE_LIVEWIRE.md | `app/Livewire/Artisan/OrderList.php` |
| Validation artisans | ADMIN_DASHBOARD_LIVEWIRE.md | `app/Livewire/Admin/ArtisanApproval.php` |
| Modération produits | ADMIN_DASHBOARD_LIVEWIRE.md | `app/Livewire/Admin/ProductModeration.php` |

### Par composant Livewire

| Composant | Documentation | Vue | Route |
|-----------|---------------|-----|-------|
| ShopSetup | ARTISAN_SPACE_LIVEWIRE.md | shop-setup.blade.php | /artisan/setup |
| Dashboard (Artisan) | ARTISAN_SPACE_LIVEWIRE.md | dashboard.blade.php | /artisan/dashboard |
| ProductList | ARTISAN_SPACE_LIVEWIRE.md | product-list.blade.php | /artisan/products |
| ProductForm | ARTISAN_SPACE_LIVEWIRE.md | product-form.blade.php | /artisan/products/create |
| OrderList | ARTISAN_SPACE_LIVEWIRE.md | order-list.blade.php | /artisan/orders |
| ShopSettings | ARTISAN_SPACE_LIVEWIRE.md | shop-settings.blade.php | /artisan/shop/settings |
| ArtisanApproval | ADMIN_DASHBOARD_LIVEWIRE.md | artisan-approval.blade.php | /admin/artisans/approval |
| ProductModeration | ADMIN_DASHBOARD_LIVEWIRE.md | product-moderation.blade.php | /admin/products/moderation |
| Dashboard (Admin) | ADMIN_DASHBOARD_LIVEWIRE.md | dashboard.blade.php | /admin/dashboard |

---

## 🆘 Support et aide

### Problèmes courants

**Erreur "Class not found"**
→ QUICK_START.md (section Dépannage)

**Images ne s'affichent pas**
→ QUICK_START.md (section Dépannage)

**Erreur 403 Forbidden**
→ QUICK_START.md (section Dépannage)

**Comprendre les relations entre tables**
→ DATABASE_SCHEMA.md (section Relations)

**Modifier la validation d'un formulaire**
→ ARTISAN_SPACE_LIVEWIRE.md (section Validation)

---

## 📅 Historique des versions

### Version 1.0 (16 janvier 2025)
- ✅ Documentation complète créée
- ✅ 6 fichiers de documentation
- ✅ Espace Admin complet
- ✅ Espace Artisan complet
- ✅ Base de données avec seeders
- ✅ 9 composants Livewire

---

## 🎯 Statut de la documentation

| Fichier | Statut | Dernière mise à jour | Pages |
|---------|--------|---------------------|-------|
| INDEX.md | ✅ Complet | 16/01/2025 | 5 |
| QUICK_START.md | ✅ Complet | 16/01/2025 | 10 |
| PROJECT_SUMMARY.md | ✅ Complet | 16/01/2025 | 15 |
| DATABASE_SCHEMA.md | ✅ Complet | 16/01/2025 | 8 |
| ADMIN_DASHBOARD_LIVEWIRE.md | ✅ Complet | 16/01/2025 | 12 |
| ARTISAN_SPACE_LIVEWIRE.md | ✅ Complet | 16/01/2025 | 30 |
| ESPACE_ARTISAN_README.md | ✅ Complet | 16/01/2025 | 8 |

**Total** : ~88 pages de documentation

---

## 🚀 Liens rapides

- [Démarrage rapide](#1--quick_startmd)
- [Vue d'ensemble](#2--project_summarymd)
- [Base de données](#3--database_schemamd)
- [Espace Admin](#4--admin_dashboard_livewiremd)
- [Espace Artisan (Principal)](#5--artisan_space_livewiremd-)
- [Résumé Artisan](#6--espace_artisan_readmemd)

---

## 📞 Contact et contribution

Pour toute question ou suggestion d'amélioration de la documentation :

1. Consultez d'abord les fichiers existants
2. Vérifiez la section "Dépannage" de QUICK_START.md
3. Consultez les logs Laravel : `storage/logs/laravel.log`

---

**Bonne lecture et bon développement ! 🎉**

---

**Index créé le** : 16 janvier 2025  
**Version** : 1.0  
**Mainteneur** : ArtisanMarket Team
