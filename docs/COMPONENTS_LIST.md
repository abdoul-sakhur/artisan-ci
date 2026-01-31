# 🎨 Composants UI - Liste Complète

## 📦 18 Composants shadcn/ui pour Laravel Blade

Tous situés dans `resources/views/components/ui/`

### ✅ Composants Créés

| # | Composant | Fichier | Description | Alpine.js |
|---|-----------|---------|-------------|-----------|
| 1 | **Button** | `button.blade.php` | 6 variantes + 4 tailles | ❌ |
| 2 | **Input** | `input.blade.php` | Champ de saisie avec erreurs | ❌ |
| 3 | **Label** | `label.blade.php` | Étiquette avec required | ❌ |
| 4 | **Textarea** | `textarea.blade.php` | Zone de texte multiligne | ❌ |
| 5 | **Select** | `select.blade.php` | Liste déroulante | ❌ |
| 6 | **Checkbox** | `checkbox.blade.php` | Case à cocher | ❌ |
| 7 | **Radio** | `radio.blade.php` | Bouton radio | ❌ |
| 8 | **Card** | `card.blade.php` | Carte avec header/footer | ❌ |
| 9 | **Badge** | `badge.blade.php` | 6 variantes de couleurs | ❌ |
| 10 | **Alert** | `alert.blade.php` | 5 variantes + dismissible | ✅ |
| 11 | **Modal** | `modal.blade.php` | Boîte de dialogue | ✅ |
| 12 | **Table** | `table.blade.php` | Table responsive | ❌ |
| 13 | **Tabs** | `tabs.blade.php` | Container d'onglets | ✅ |
| 14 | **Tabs List** | `tabs-list.blade.php` | Liste des onglets | ❌ |
| 15 | **Tabs Trigger** | `tabs-trigger.blade.php` | Bouton d'onglet | ✅ |
| 16 | **Tabs Content** | `tabs-content.blade.php` | Contenu d'onglet | ✅ |
| 17 | **Dropdown** | `dropdown.blade.php` | Menu déroulant | ✅ |
| 18 | **Dropdown Item** | `dropdown-item.blade.php` | Élément de menu | ❌ |
| 19 | **Separator** | `separator.blade.php` | Ligne de séparation | ❌ |
| 20 | **Stat Card** | `stat-card.blade.php` | Carte de statistiques | ❌ |
| 21 | **Spinner** | `spinner.blade.php` | Indicateur chargement | ❌ |
| 22 | **Add Button** | `add-button.blade.php` | Bouton d'ajout | ❌ |

## 🎯 Variantes Disponibles

### Button
- `default` - Bouton principal bleu
- `destructive` - Bouton rouge (supprimer)
- `outline` - Bouton avec bordure
- `secondary` - Bouton secondaire gris
- `ghost` - Bouton transparent
- `link` - Lien souligné

### Badge
- `default` - Badge bleu
- `secondary` - Badge gris
- `destructive` - Badge rouge
- `outline` - Badge avec bordure
- `success` - Badge vert
- `warning` - Badge jaune

### Alert
- `default` - Alerte neutre
- `info` - Information bleue
- `success` - Succès vert
- `warning` - Attention jaune
- `destructive` - Erreur rouge

## 📐 Tailles Disponibles

### Button
- `sm` - Petit (h-9)
- `default` - Normal (h-10)
- `lg` - Grand (h-11)
- `icon` - Icône seule (10x10)

## 🎨 Props Communes

### Tous les composants acceptent :
- `class` - Classes CSS personnalisées
- `id` - Identifiant unique
- Tous les attributs HTML standards

### Composants de formulaire :
- `name` - Nom du champ
- `value` - Valeur par défaut
- `disabled` - Désactivé
- `required` - Requis (pour label)
- `error` - Style d'erreur (pour input/textarea)

## 📱 Responsive & Accessibilité

✅ Tous les composants sont :
- Responsive (mobile-first)
- Accessibles (ARIA labels, roles)
- Dark mode ready (via classe `.dark`)
- Compatible lecteurs d'écran

## 🔧 Technologie

- **Blade** - Templating Laravel
- **Alpine.js** - Interactivité (modals, tabs, dropdowns)
- **TailwindCSS** - Styling utility-first
- **CSS Variables** - Personnalisation facile

## 📖 Documentation

- [docs/UI_COMPONENTS.md](../docs/UI_COMPONENTS.md) - Guide complet
- `/components-demo` - Démo interactive

## 🚀 Utilisation Rapide

```blade
{{-- Bouton --}}
<x-ui.button variant="destructive">Supprimer</x-ui.button>

{{-- Formulaire --}}
<x-ui.label for="email" required>Email</x-ui.label>
<x-ui.input id="email" type="email" />

{{-- Card --}}
<x-ui.card title="Mon Titre">
    Contenu de la carte
</x-ui.card>

{{-- Alert --}}
<x-ui.alert variant="success" dismissible>
    Opération réussie !
</x-ui.alert>

{{-- Modal --}}
<x-ui.button x-on:click="$dispatch('open-modal', 'my-modal')">
    Ouvrir
</x-ui.button>

<x-ui.modal name="my-modal" title="Titre">
    Contenu du modal
</x-ui.modal>

{{-- Tabs --}}
<x-ui.tabs defaultTab="tab1">
    <x-ui.tabs-list>
        <x-ui.tabs-trigger value="tab1">Onglet 1</x-ui.tabs-trigger>
        <x-ui.tabs-trigger value="tab2">Onglet 2</x-ui.tabs-trigger>
    </x-ui.tabs-list>
    
    <x-ui.tabs-content value="tab1">Contenu 1</x-ui.tabs-content>
    <x-ui.tabs-content value="tab2">Contenu 2</x-ui.tabs-content>
</x-ui.tabs>

{{-- Table --}}
<x-ui.table>
    <thead class="border-b">
        <tr>
            <th class="h-12 px-4 text-left">Colonne 1</th>
            <th class="h-12 px-4 text-left">Colonne 2</th>
        </tr>
    </thead>
    <tbody>
        <tr class="border-b hover:bg-muted/50">
            <td class="p-4">Valeur 1</td>
            <td class="p-4">Valeur 2</td>
        </tr>
    </tbody>
</x-ui.table>
```

---

**Total** : 22 composants Blade  
**Date de création** : 31 janvier 2026  
**Version** : 1.0 (ÉTAPE 4)
