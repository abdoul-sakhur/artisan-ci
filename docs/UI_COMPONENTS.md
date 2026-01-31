# 🎨 Documentation des Composants UI - ArtisanMarket

Guide complet des composants shadcn/ui adaptés pour Laravel Blade avec Alpine.js.

## 📁 Structure

Tous les composants sont dans `resources/views/components/ui/`

```
components/ui/
├── button.blade.php          # Boutons avec variantes
├── input.blade.php           # Champs de saisie
├── label.blade.php           # Étiquettes de formulaire
├── textarea.blade.php        # Zones de texte
├── select.blade.php          # Listes déroulantes
├── checkbox.blade.php        # Cases à cocher
├── radio.blade.php           # Boutons radio
├── card.blade.php            # Cartes de contenu
├── badge.blade.php           # Badges/étiquettes
├── alert.blade.php           # Messages d'alerte
├── modal.blade.php           # Boîtes de dialogue
├── table.blade.php           # Tables de données
├── tabs.blade.php            # Système d'onglets
├── tabs-list.blade.php
├── tabs-trigger.blade.php
├── tabs-content.blade.php
├── dropdown.blade.php        # Menus déroulants
├── dropdown-item.blade.php
├── separator.blade.php       # Séparateurs
├── stat-card.blade.php       # Cartes de statistiques
├── spinner.blade.php         # Indicateur de chargement
└── add-button.blade.php      # Bouton d'ajout
```

---

## 🔘 Button

Bouton avec plusieurs variantes et tailles.

### Props

| Prop | Type | Défaut | Options |
|------|------|--------|---------|
| `variant` | string | `'default'` | `default`, `destructive`, `outline`, `secondary`, `ghost`, `link` |
| `size` | string | `'default'` | `default`, `sm`, `lg`, `icon` |
| `type` | string | `'button'` | `button`, `submit`, `reset` |
| `href` | string | `null` | URL (transforme en lien) |

### Exemples

```blade
{{-- Bouton par défaut --}}
<x-ui.button>Cliquer ici</x-ui.button>

{{-- Bouton destructif --}}
<x-ui.button variant="destructive">Supprimer</x-ui.button>

{{-- Bouton avec contour --}}
<x-ui.button variant="outline">Annuler</x-ui.button>

{{-- Petit bouton --}}
<x-ui.button size="sm">Petit</x-ui.button>

{{-- Bouton en tant que lien --}}
<x-ui.button href="/artisan/dashboard">Aller au dashboard</x-ui.button>

{{-- Bouton submit de formulaire --}}
<x-ui.button type="submit" variant="default">
    Enregistrer
</x-ui.button>

{{-- Bouton icône uniquement --}}
<x-ui.button size="icon">
    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
</x-ui.button>
```

---

## 📝 Input

Champ de saisie de texte.

### Props

| Prop | Type | Défaut | Description |
|------|------|--------|-------------|
| `disabled` | boolean | `false` | Désactiver le champ |
| `error` | boolean | `false` | Style d'erreur (bordure rouge) |

### Exemples

```blade
{{-- Input basique --}}
<x-ui.input type="text" name="name" placeholder="Votre nom" />

{{-- Input avec erreur --}}
<x-ui.input type="email" name="email" error />

{{-- Input désactivé --}}
<x-ui.input type="text" disabled value="Valeur fixe" />

{{-- Formulaire complet --}}
<div>
    <x-ui.label for="product-name" required>Nom du produit</x-ui.label>
    <x-ui.input 
        id="product-name" 
        type="text" 
        name="name" 
        placeholder="Ex: Vase en céramique"
        class="mt-1"
    />
</div>
```

---

## 🏷️ Label

Étiquette pour éléments de formulaire.

### Props

| Prop | Type | Défaut | Description |
|------|------|--------|-------------|
| `for` | string | `null` | ID de l'élément associé |
| `required` | boolean | `false` | Affiche un astérisque rouge |

### Exemples

```blade
{{-- Label simple --}}
<x-ui.label for="email">Email</x-ui.label>

{{-- Label requis --}}
<x-ui.label for="password" required>Mot de passe</x-ui.label>
```

---

## 📄 Textarea

Zone de texte multiligne.

### Props

| Prop | Type | Défaut | Description |
|------|------|--------|-------------|
| `disabled` | boolean | `false` | Désactiver le champ |
| `error` | boolean | `false` | Style d'erreur |
| `rows` | integer | `4` | Nombre de lignes |

### Exemples

```blade
{{-- Textarea basique --}}
<x-ui.textarea name="description" placeholder="Description du produit..." />

{{-- Textarea avec plus de lignes --}}
<x-ui.textarea rows="6" name="bio">
    Contenu existant...
</x-ui.textarea>
```

---

## 🎴 Card

Carte de contenu avec en-tête et pied de page optionnels.

### Props

| Prop | Type | Défaut | Description |
|------|------|--------|-------------|
| `title` | string | `null` | Titre de la carte |
| `description` | string | `null` | Description sous le titre |
| `header` | slot | `null` | Contenu personnalisé de l'en-tête |
| `footer` | slot | `null` | Pied de page |

### Exemples

```blade
{{-- Card simple --}}
<x-ui.card title="Mes Produits" description="Liste de vos créations">
    <p>Contenu de la carte...</p>
</x-ui.card>

{{-- Card avec footer --}}
<x-ui.card title="Confirmation">
    <p>Êtes-vous sûr de vouloir supprimer ce produit ?</p>
    
    <x-slot name="footer">
        <x-ui.button variant="outline">Annuler</x-ui.button>
        <x-ui.button variant="destructive">Supprimer</x-ui.button>
    </x-slot>
</x-ui.card>
```

---

## 🏷️ Badge

Étiquette colorée pour le statut ou les catégories.

### Props

| Prop | Type | Défaut | Options |
|------|------|--------|---------|
| `variant` | string | `'default'` | `default`, `secondary`, `destructive`, `outline`, `success`, `warning` |

### Exemples

```blade
<x-ui.badge>Nouveau</x-ui.badge>
<x-ui.badge variant="success">Approuvé</x-ui.badge>
<x-ui.badge variant="warning">En attente</x-ui.badge>
<x-ui.badge variant="destructive">Refusé</x-ui.badge>
```

---

## ⚠️ Alert

Messages d'alerte contextuels.

### Props

| Prop | Type | Défaut | Options |
|------|------|--------|---------|
| `variant` | string | `'default'` | `default`, `destructive`, `success`, `warning`, `info` |
| `title` | string | `null` | Titre de l'alerte |
| `dismissible` | boolean | `false` | Bouton de fermeture |

### Exemples

```blade
{{-- Alert d'information --}}
<x-ui.alert title="Information" variant="info">
    Votre profil a été mis à jour avec succès.
</x-ui.alert>

{{-- Alert de succès --}}
<x-ui.alert variant="success" dismissible>
    Produit ajouté au catalogue !
</x-ui.alert>

{{-- Alert d'erreur --}}
<x-ui.alert title="Erreur" variant="destructive">
    Impossible de traiter votre demande.
</x-ui.alert>
```

---

## 💬 Modal

Boîte de dialogue modale avec Alpine.js.

### Props

| Prop | Type | Défaut | Options |
|------|------|--------|---------|
| `name` | string | **requis** | Identifiant unique du modal |
| `title` | string | `null` | Titre du modal |
| `description` | string | `null` | Description sous le titre |
| `show` | boolean | `false` | Afficher par défaut |
| `maxWidth` | string | `'2xl'` | `sm`, `md`, `lg`, `xl`, `2xl`, `full` |

### Exemples

```blade
{{-- Bouton d'ouverture --}}
<x-ui.button x-on:click="$dispatch('open-modal', 'confirm-delete')">
    Supprimer
</x-ui.button>

{{-- Modal --}}
<x-ui.modal 
    name="confirm-delete" 
    title="Confirmer la suppression"
    description="Cette action est irréversible"
>
    <p>Êtes-vous sûr de vouloir supprimer ce produit ?</p>
    
    <div class="mt-6 flex justify-end gap-3">
        <x-ui.button 
            variant="outline" 
            x-on:click="$dispatch('close-modal', 'confirm-delete')"
        >
            Annuler
        </x-ui.button>
        <x-ui.button variant="destructive">
            Confirmer
        </x-ui.button>
    </div>
</x-ui.modal>
```

---

## 📊 Table

Table de données responsive.

### Props

| Prop | Type | Défaut | Description |
|------|------|--------|-------------|
| `striped` | boolean | `false` | Lignes alternées |
| `hoverable` | boolean | `true` | Effet de survol |

### Exemples

```blade
<x-ui.table>
    <thead class="border-b">
        <tr>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Produit</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Prix</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr class="border-b transition-colors hover:bg-muted/50">
                <td class="p-4 align-middle">{{ $product->name }}</td>
                <td class="p-4 align-middle">{{ $product->price }} €</td>
                <td class="p-4 align-middle">
                    <x-ui.button size="sm" variant="outline">Modifier</x-ui.button>
                </td>
            </tr>
        @endforeach
    </tbody>
</x-ui.table>
```

---

## 📑 Tabs

Système d'onglets interactifs avec Alpine.js.

### Composants

- `<x-ui.tabs>` - Container principal
- `<x-ui.tabs-list>` - Liste des onglets
- `<x-ui.tabs-trigger>` - Bouton d'onglet
- `<x-ui.tabs-content>` - Contenu d'onglet

### Exemples

```blade
<x-ui.tabs defaultTab="overview">
    <x-ui.tabs-list>
        <x-ui.tabs-trigger value="overview">Vue d'ensemble</x-ui.tabs-trigger>
        <x-ui.tabs-trigger value="products">Produits</x-ui.tabs-trigger>
        <x-ui.tabs-trigger value="orders">Commandes</x-ui.tabs-trigger>
    </x-ui.tabs-list>
    
    <x-ui.tabs-content value="overview">
        <p>Contenu de la vue d'ensemble...</p>
    </x-ui.tabs-content>
    
    <x-ui.tabs-content value="products">
        <p>Liste des produits...</p>
    </x-ui.tabs-content>
    
    <x-ui.tabs-content value="orders">
        <p>Liste des commandes...</p>
    </x-ui.tabs-content>
</x-ui.tabs>
```

---

## 📈 Stat Card

Carte d'affichage de statistiques avec tendance.

### Props

| Prop | Type | Défaut | Description |
|------|------|--------|-------------|
| `title` | string | **requis** | Titre de la métrique |
| `value` | string | **requis** | Valeur à afficher |
| `icon` | slot | `null` | Icône SVG |
| `trend` | string | `null` | `'up'` ou `'down'` |
| `trendValue` | string | `null` | Valeur de la tendance |
| `description` | string | `null` | Description |

### Exemples

```blade
<x-ui.stat-card 
    title="Ventes du mois" 
    value="2,345 €"
    trend="up"
    trendValue="+12%"
    description="vs mois dernier"
>
    <x-slot name="icon">
        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </x-slot>
</x-ui.stat-card>
```

---

## 🔄 Dropdown

Menu déroulant avec Alpine.js.

### Props

| Prop | Type | Défaut | Options |
|------|------|--------|---------|
| `align` | string | `'right'` | `left`, `right`, `top` |
| `width` | string | `'48'` | `48`, `60`, `72` |
| `open` | boolean | `false` | Ouvert par défaut |

### Exemples

```blade
<x-ui.dropdown align="right" width="48">
    <x-slot name="trigger">
        <x-ui.button variant="outline">
            Options
            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </x-ui.button>
    </x-slot>

    <x-slot name="content">
        <x-ui.dropdown-item href="{{ route('profile.edit') }}">
            Modifier le profil
        </x-ui.dropdown-item>
        <x-ui.dropdown-item href="{{ route('logout') }}">
            Déconnexion
        </x-ui.dropdown-item>
    </x-slot>
</x-ui.dropdown>
```

---

## 🔀 Separator

Ligne de séparation horizontale ou verticale.

### Props

| Prop | Type | Défaut | Options |
|------|------|--------|---------|
| `orientation` | string | `'horizontal'` | `horizontal`, `vertical` |

### Exemples

```blade
{{-- Séparateur horizontal --}}
<x-ui.separator />

{{-- Séparateur vertical (dans un flex row) --}}
<div class="flex items-center gap-4">
    <span>Élément 1</span>
    <x-ui.separator orientation="vertical" class="h-6" />
    <span>Élément 2</span>
</div>
```

---

## 🔘 Select, Checkbox, Radio

### Select (Liste déroulante)

```blade
<x-ui.select name="category">
    <option value="">Choisir une catégorie</option>
    <option value="1">Poterie</option>
    <option value="2">Bijoux</option>
</x-ui.select>
```

### Checkbox

```blade
<div class="flex items-center gap-2">
    <x-ui.checkbox id="terms" name="terms" />
    <x-ui.label for="terms">J'accepte les conditions</x-ui.label>
</div>
```

### Radio

```blade
<x-ui.radio name="status" value="published" label="Publié" />
<x-ui.radio name="status" value="draft" label="Brouillon" />
```

---

## 🎨 Personnalisation

Les composants utilisent les variables CSS définies dans `resources/css/app.css`.

### Variables principales

```css
--primary: 222.2 47.4% 11.2%;
--primary-foreground: 210 40% 98%;
--secondary: 210 40% 96.1%;
--destructive: 0 84.2% 60.2%;
--muted: 210 40% 96.1%;
--accent: 210 40% 96.1%;
--border: 214.3 31.8% 91.4%;
```

Pour personnaliser les couleurs, modifiez ces variables dans le fichier CSS.

---

## 📱 Page de Démo

Accédez à `/components-demo` (après connexion) pour voir tous les composants en action.

---

## 🧪 Utilisation avec Livewire

Les composants sont compatibles avec Livewire. Exemple :

```blade
<div>
    <x-ui.button wire:click="save">
        Enregistrer
    </x-ui.button>
    
    <x-ui.input wire:model="name" />
</div>
```

---

## ⚡ Optimisations

- Tous les composants utilisent `@props` pour la validation des paramètres
- Alpine.js gère l'interactivité côté client (modals, tabs, dropdowns)
- Classes Tailwind compilées et purgées en production
- Pas de JavaScript supplémentaire requis

---

**Créé le** : 31 janvier 2026  
**Version** : 1.0 (ÉTAPE 4 complétée)
