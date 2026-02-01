<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Démo des Composants UI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Buttons --}}
            <x-ui.card title="Boutons" description="Différentes variantes de boutons">
                <div class="flex flex-wrap gap-4">
                    <x-ui.button>Default Button</x-ui.button>
                    <x-ui.button variant="destructive">Destructive</x-ui.button>
                    <x-ui.button variant="outline">Outline</x-ui.button>
                    <x-ui.button variant="secondary">Secondary</x-ui.button>
                    <x-ui.button variant="ghost">Ghost</x-ui.button>
                    <x-ui.button variant="link">Link</x-ui.button>
                </div>
                
                <x-ui.separator class="my-4" />
                
                <div class="flex flex-wrap gap-4">
                    <x-ui.button size="sm">Small</x-ui.button>
                    <x-ui.button size="default">Default</x-ui.button>
                    <x-ui.button size="lg">Large</x-ui.button>
                    <x-ui.button size="icon">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </x-ui.button>
                </div>
            </x-ui.card>

            {{-- Badges --}}
            <x-ui.card title="Badges" description="Étiquettes colorées">
                <div class="flex flex-wrap gap-4">
                    <x-ui.badge>Default</x-ui.badge>
                    <x-ui.badge variant="secondary">Secondary</x-ui.badge>
                    <x-ui.badge variant="destructive">Destructive</x-ui.badge>
                    <x-ui.badge variant="outline">Outline</x-ui.badge>
                    <x-ui.badge variant="success">Success</x-ui.badge>
                    <x-ui.badge variant="warning">Warning</x-ui.badge>
                </div>
            </x-ui.card>

            {{-- Alerts --}}
            <x-ui.card title="Alerts" description="Messages d'alerte">
                <div class="space-y-4">
                    <x-ui.alert title="Information" variant="info">
                        Ceci est un message d'information important.
                    </x-ui.alert>
                    
                    <x-ui.alert title="Succès" variant="success">
                        Votre opération a été effectuée avec succès !
                    </x-ui.alert>
                    
                    <x-ui.alert title="Attention" variant="warning">
                        Veuillez vérifier les informations avant de continuer.
                    </x-ui.alert>
                    
                    <x-ui.alert title="Erreur" variant="destructive" dismissible>
                        Une erreur s'est produite. Veuillez réessayer.
                    </x-ui.alert>
                </div>
            </x-ui.card>

            {{-- Forms --}}
            <x-ui.card title="Formulaires" description="Éléments de formulaire">
                <div class="space-y-4 max-w-md">
                    <div>
                        <x-ui.label for="name" required>Nom complet</x-ui.label>
                        <x-ui.input id="name" type="text" placeholder="Jean Dupont" class="mt-1" />
                    </div>
                    
                    <div>
                        <x-ui.label for="email">Email</x-ui.label>
                        <x-ui.input id="email" type="email" placeholder="jean@example.com" class="mt-1" />
                    </div>
                    
                    <div>
                        <x-ui.label for="category">Catégorie</x-ui.label>
                        <x-ui.select id="category" class="mt-1">
                            <option value="">Sélectionner une catégorie</option>
                            <option value="1">Poterie & Céramique</option>
                            <option value="2">Bijoux Artisanaux</option>
                            <option value="3">Maroquinerie</option>
                        </x-ui.select>
                    </div>
                    
                    <div>
                        <x-ui.label for="description">Description</x-ui.label>
                        <x-ui.textarea id="description" placeholder="Décrivez votre produit..." class="mt-1" />
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <x-ui.checkbox id="terms" />
                        <x-ui.label for="terms">J'accepte les conditions d'utilisation</x-ui.label>
                    </div>
                </div>
            </x-ui.card>

            {{-- Stat Cards --}}
            <x-ui.card title="Cartes de Statistiques" description="Affichage des métriques">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <x-ui.stat-card 
                        title="Ventes Totales" 
                        value="12,345 FCFA"
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
                    
                    <x-ui.stat-card 
                        title="Commandes" 
                        value="234"
                        trend="up"
                        trendValue="+8%"
                    >
                        <x-slot name="icon">
                            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </x-slot>
                    </x-ui.stat-card>
                    
                    <x-ui.stat-card 
                        title="Produits" 
                        value="89"
                    >
                        <x-slot name="icon">
                            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </x-slot>
                    </x-ui.stat-card>
                    
                    <x-ui.stat-card 
                        title="Taux de conversion" 
                        value="3.2%"
                        trend="down"
                        trendValue="-2%"
                    >
                        <x-slot name="icon">
                            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </x-slot>
                    </x-ui.stat-card>
                </div>
            </x-ui.card>

            {{-- Tabs --}}
            <x-ui.card title="Onglets" description="Navigation par onglets">
                <x-ui.tabs defaultTab="overview">
                    <x-ui.tabs-list>
                        <x-ui.tabs-trigger value="overview">Vue d'ensemble</x-ui.tabs-trigger>
                        <x-ui.tabs-trigger value="analytics">Analytiques</x-ui.tabs-trigger>
                        <x-ui.tabs-trigger value="reports">Rapports</x-ui.tabs-trigger>
                        <x-ui.tabs-trigger value="notifications">Notifications</x-ui.tabs-trigger>
                    </x-ui.tabs-list>
                    
                    <x-ui.tabs-content value="overview">
                        <div class="p-4 border rounded-md">
                            <h3 class="font-semibold mb-2">Vue d'ensemble</h3>
                            <p class="text-sm text-muted-foreground">
                                Consultez les principales métriques de votre boutique artisanale.
                            </p>
                        </div>
                    </x-ui.tabs-content>
                    
                    <x-ui.tabs-content value="analytics">
                        <div class="p-4 border rounded-md">
                            <h3 class="font-semibold mb-2">Analytiques</h3>
                            <p class="text-sm text-muted-foreground">
                                Analysez les performances de vos produits et ventes.
                            </p>
                        </div>
                    </x-ui.tabs-content>
                    
                    <x-ui.tabs-content value="reports">
                        <div class="p-4 border rounded-md">
                            <h3 class="font-semibold mb-2">Rapports</h3>
                            <p class="text-sm text-muted-foreground">
                                Générez et téléchargez vos rapports financiers.
                            </p>
                        </div>
                    </x-ui.tabs-content>
                    
                    <x-ui.tabs-content value="notifications">
                        <div class="p-4 border rounded-md">
                            <h3 class="font-semibold mb-2">Notifications</h3>
                            <p class="text-sm text-muted-foreground">
                                Gérez vos préférences de notification.
                            </p>
                        </div>
                    </x-ui.tabs-content>
                </x-ui.tabs>
            </x-ui.card>

            {{-- Table --}}
            <x-ui.card title="Table" description="Affichage de données tabulaires">
                <x-ui.table>
                    <thead class="border-b">
                        <tr>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Produit</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Catégorie</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Prix</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Stock</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle font-medium">Vase en céramique</td>
                            <td class="p-4 align-middle">Poterie</td>
                            <td class="p-4 align-middle">45,00 FCFA</td>
                            <td class="p-4 align-middle">12</td>
                            <td class="p-4 align-middle">
                                <x-ui.badge variant="success">Publié</x-ui.badge>
                            </td>
                        </tr>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle font-medium">Bracelet artisanal</td>
                            <td class="p-4 align-middle">Bijoux</td>
                            <td class="p-4 align-middle">28,50 FCFA</td>
                            <td class="p-4 align-middle">5</td>
                            <td class="p-4 align-middle">
                                <x-ui.badge variant="warning">Stock faible</x-ui.badge>
                            </td>
                        </tr>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle font-medium">Sac en cuir</td>
                            <td class="p-4 align-middle">Maroquinerie</td>
                            <td class="p-4 align-middle">120,00 FCFA</td>
                            <td class="p-4 align-middle">0</td>
                            <td class="p-4 align-middle">
                                <x-ui.badge variant="destructive">Rupture</x-ui.badge>
                            </td>
                        </tr>
                    </tbody>
                </x-ui.table>
            </x-ui.card>

            {{-- Modal Demo --}}
            <x-ui.card title="Modal" description="Boîte de dialogue modale">
                <x-ui.button x-on:click="$dispatch('open-modal', 'demo-modal')">
                    Ouvrir le Modal
                </x-ui.button>
                
                <x-ui.modal name="demo-modal" title="Confirmation" description="Êtes-vous sûr de vouloir continuer ?">
                    <div class="space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Cette action est irréversible. Tous les changements seront appliqués immédiatement.
                        </p>
                        
                        <div class="flex justify-end gap-3">
                            <x-ui.button variant="outline" x-on:click="$dispatch('close-modal', 'demo-modal')">
                                Annuler
                            </x-ui.button>
                            <x-ui.button variant="destructive" x-on:click="$dispatch('close-modal', 'demo-modal')">
                                Confirmer
                            </x-ui.button>
                        </div>
                    </div>
                </x-ui.modal>
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
