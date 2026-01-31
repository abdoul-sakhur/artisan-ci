# 🔗 Routes Admin - ArtisanMarket

## Accès Admin

**URL de base** : `http://localhost:8000/admin`

**Authentification requise** : 
- Email: `admin@artisanmarket.com`
- Password: `password`

**Protection** : Middleware `auth`, `verified`, `role:admin`

---

## 📊 Dashboard

| Méthode | URL | Nom de Route | Description |
|---------|-----|--------------|-------------|
| GET | `/admin/dashboard` | `admin.dashboard` | Dashboard principal avec statistiques |

### Données affichées :
- 📈 4 statistiques : Utilisateurs, Artisans, Produits, Revenus
- 👥 5 derniers artisans en attente
- 🏆 Top 5 artisans par commandes
- 📦 10 dernières commandes

---

## 🎨 Gestion des Artisans

| Méthode | URL | Nom de Route | Description |
|---------|-----|--------------|-------------|
| GET | `/admin/artisans` | `admin.artisans.index` | Liste des artisans (avec filtres) |
| GET | `/admin/artisans/{artisan}` | `admin.artisans.show` | Détails d'un artisan |
| POST | `/admin/artisans/{artisan}/approve` | `admin.artisans.approve` | Approuver un artisan |
| POST | `/admin/artisans/{artisan}/reject` | `admin.artisans.reject` | Rejeter un artisan |
| DELETE | `/admin/artisans/{artisan}` | `admin.artisans.destroy` | Supprimer un artisan |

### Filtres disponibles :
- `?status=all` - Tous les artisans
- `?status=pending` - Artisans en attente
- `?status=approved` - Artisans approuvés

### Détails affichés (show) :
- Informations boutique (nom, bio, téléphone, adresse)
- Statistiques (produits, commandes, revenus)
- Liste des produits de l'artisan
- 10 dernières commandes

---

## 🏷️ Gestion des Catégories

| Méthode | URL | Nom de Route | Description |
|---------|-----|--------------|-------------|
| GET | `/admin/categories` | `admin.categories.index` | Liste des catégories |
| GET | `/admin/categories/create` | `admin.categories.create` | Formulaire de création |
| POST | `/admin/categories` | `admin.categories.store` | Créer une catégorie |
| GET | `/admin/categories/{category}` | `admin.categories.show` | Détails d'une catégorie |
| GET | `/admin/categories/{category}/edit` | `admin.categories.edit` | Formulaire d'édition |
| PUT/PATCH | `/admin/categories/{category}` | `admin.categories.update` | Mettre à jour une catégorie |
| DELETE | `/admin/categories/{category}` | `admin.categories.destroy` | Supprimer une catégorie |
| POST | `/admin/categories/{category}/toggle-status` | `admin.categories.toggle-status` | Activer/désactiver |

### Champs du formulaire :
- **Nom** (requis, unique) - Ex: "Bijoux"
- **Description** (optionnel) - Description de la catégorie
- **URL Image** (optionnel) - URL de l'image de prévisualisation
- **Statut actif** (checkbox) - Activer/désactiver la catégorie

### Validation :
- ✅ Nom unique
- ✅ Génération automatique du slug (ex: "Bijoux Artisanaux" → "bijoux-artisanaux")
- ✅ Protection : Impossible de supprimer une catégorie avec des produits liés

---

## 🧭 Navigation Admin

Le menu de navigation admin inclut :
- 🏠 Dashboard
- 🎨 Artisans
- 🏷️ Catégories
- 👤 Profil
- 🚪 Déconnexion

### Highlight automatique
Le lien actif est mis en évidence selon la route courante.

---

## 📊 Pagination

- **Artisans** : 15 par page
- **Catégories** : 20 par page

---

## 💬 Messages Flash

Les actions affichent des messages de confirmation :

### Success (vert)
- "Artisan approuvé avec succès !"
- "Catégorie créée avec succès !"
- "Catégorie mise à jour avec succès !"

### Error (rouge)
- "Impossible de supprimer une catégorie contenant des produits"
- "Une erreur s'est produite"

---

## 🔒 Sécurité

### Protection des routes
Toutes les routes admin sont protégées par :
1. `auth` - Utilisateur authentifié
2. `verified` - Email vérifié
3. `role:admin` - Rôle administrateur uniquement

### CSRF
Tous les formulaires POST/PUT/DELETE incluent le token CSRF.

### Soft Delete
Les artisans sont supprimés en soft delete (récupérables).

---

## 🧪 Tests Rapides

```bash
# 1. Connexion admin
http://localhost:8000/login
Email: admin@artisanmarket.com
Password: password

# 2. Dashboard
http://localhost:8000/admin/dashboard

# 3. Liste des artisans
http://localhost:8000/admin/artisans

# 4. Artisans en attente
http://localhost:8000/admin/artisans?status=pending

# 5. Liste des catégories
http://localhost:8000/admin/categories

# 6. Créer une catégorie
http://localhost:8000/admin/categories/create
```

---

## 🎯 Exemples d'Utilisation

### 1. Approuver un artisan

```html
<!-- Formulaire dans la vue -->
<form method="POST" action="{{ route('admin.artisans.approve', $artisan) }}">
    @csrf
    <button type="submit">Approuver</button>
</form>
```

### 2. Créer une catégorie

```html
<form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    <input type="text" name="name" required>
    <textarea name="description"></textarea>
    <input type="url" name="image_url">
    <input type="checkbox" name="is_active" value="1" checked>
    <button type="submit">Créer</button>
</form>
```

### 3. Toggle statut catégorie

```html
<form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}">
    @csrf
    <button type="submit">
        @if($category->is_active)
            Désactiver
        @else
            Activer
        @endif
    </button>
</form>
```

---

## 📝 Notes Importantes

1. **Slug auto-généré** : Le slug des catégories est généré automatiquement à partir du nom (ex: "Bijoux Artisanaux" → "bijoux-artisanaux")

2. **Protection suppression** : Une catégorie ne peut être supprimée que si elle ne contient aucun produit

3. **Eager Loading** : Les relations sont chargées efficacement pour éviter le problème N+1

4. **Pagination** : Utilise la pagination par défaut de Laravel avec Tailwind

5. **Validation** : Toutes les entrées sont validées côté serveur

---

**Voir aussi** :
- [ETAPE_5_COMPLETE.md](docs/ETAPE_5_COMPLETE.md) - Documentation complète
- [UI_COMPONENTS.md](docs/UI_COMPONENTS.md) - Composants utilisés
