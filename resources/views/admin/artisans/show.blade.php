<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $artisan->shop_name }}
            </h2>
            <x-ui.button variant="outline" href="{{ route('admin.artisans.index') }}">
                Retour
            </x-ui.button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <x-ui.alert variant="success" dismissible>
                    {{ session('success') }}
                </x-ui.alert>
            @endif

            @if(session('error'))
                <x-ui.alert variant="destructive" dismissible>
                    {{ session('error') }}
                </x-ui.alert>
            @endif

            {{-- Informations de la boutique --}}
            <x-ui.card>
                <div class="px-4 py-5 sm:px-6 border-b">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Informations de la boutique
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Détails et statut de l'artisan
                            </p>
                        </div>
                        @if($artisan->is_approved)
                            <x-ui.badge variant="success">Approuvé</x-ui.badge>
                        @else
                            <x-ui.badge variant="warning">En attente</x-ui.badge>
                        @endif
                    </div>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nom de la boutique</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $artisan->shop_name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Propriétaire</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $artisan->user->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $artisan->user->email }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $artisan->phone ?? 'Non renseigné' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Adresse</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $artisan->address ?? 'Non renseignée' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date d'inscription</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $artisan->created_at->format('d/m/Y à H:i') }}</dd>
                        </div>

                        @if($artisan->bio)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Biographie</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $artisan->bio }}</dd>
                            </div>
                        @endif

                        @if($artisan->approved_by)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Approuvé par</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $artisan->approvedBy->name }} le {{ $artisan->approved_at->format('d/m/Y à H:i') }}
                                </dd>
                            </div>
                        @endif
                    </dl>

                    @if(!$artisan->is_approved)
                        <div class="mt-6 flex gap-4 border-t pt-4">
                            <form method="POST" action="{{ route('admin.artisans.approve', $artisan) }}">
                                @csrf
                                <x-ui.button type="submit" variant="default" as="button">
                                    Approuver cet artisan
                                </x-ui.button>
                            </form>

                            <form method="POST" action="{{ route('admin.artisans.reject', $artisan) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir rejeter et supprimer cet artisan ? Cette action est irréversible.')">
                                @csrf
                                <x-ui.button type="submit" variant="destructive" as="button">
                                    Rejeter et supprimer
                                </x-ui.button>
                            </form>
                        </div>
                    @endif
                </div>
            </x-ui.card>

            {{-- Statistiques --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <x-ui.stat-card 
                    title="Produits" 
                    :value="$artisan->products->count()"
                >
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </x-slot>
                </x-ui.stat-card>
                <x-ui.stat-card 
                    title="Commandes" 
                    :value="$artisan->orders->count()"
                >
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4m-3 0h14l1 8H3l1-8z" />
                        </svg>
                    </x-slot>
                </x-ui.stat-card>
                <x-ui.stat-card 
                    title="Revenus" 
                    value="{{ number_format($artisan->orders->sum('total_amount'), 0) }} FCFA"
                >
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </x-slot>
                </x-ui.stat-card>
            </div>

            {{-- Produits --}}
            <x-ui.card>
                <div class="px-4 py-5 sm:px-6 border-b">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Produits ({{ $artisan->products->count() }})
                    </h3>
                </div>

                @if($artisan->products->count() > 0)
                    <x-ui.table>
                        <thead class="border-b">
                            <tr>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Nom</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Catégorie</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Prix</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Stock</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($artisan->products as $product)
                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-4 align-middle font-medium">{{ $product->name }}</td>
                                    <td class="p-4 align-middle">{{ $product->category->name }}</td>
                                    <td class="p-4 align-middle">{{ number_format($product->price, 0) }} FCFA</td>
                                    <td class="p-4 align-middle">{{ $product->quantity }}</td>
                                    <td class="p-4 align-middle">
                                        @if($product->is_published)
                                            <x-ui.badge variant="success">Publié</x-ui.badge>
                                        @else
                                            <x-ui.badge variant="secondary">Brouillon</x-ui.badge>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>
                @else
                    <div class="p-6 text-center text-gray-500">
                        Aucun produit pour le moment
                    </div>
                @endif
            </x-ui.card>

            {{-- Commandes récentes --}}
            <x-ui.card>
                <div class="px-4 py-5 sm:px-6 border-b">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Commandes récentes ({{ $artisan->orders->count() }})
                    </h3>
                </div>

                @if($artisan->orders->count() > 0)
                    <x-ui.table>
                        <thead class="border-b">
                            <tr>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">#</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Client</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Montant</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Statut</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($artisan->orders->sortByDesc('created_at')->take(10) as $order)
                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-4 align-middle font-medium">#{{ $order->id }}</td>
                                    <td class="p-4 align-middle">{{ $order->user->name }}</td>
                                    <td class="p-4 align-middle">{{ number_format($order->total_amount, 0) }} FCFA</td>
                                    <td class="p-4 align-middle">
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'processing' => 'default',
                                                'shipped' => 'default',
                                                'delivered' => 'success',
                                                'cancelled' => 'destructive',
                                            ];
                                        @endphp
                                        <x-ui.badge :variant="$statusColors[$order->status] ?? 'secondary'">
                                            {{ ucfirst($order->status) }}
                                        </x-ui.badge>
                                    </td>
                                    <td class="p-4 align-middle text-sm text-muted-foreground">
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>
                @else
                    <div class="p-6 text-center text-gray-500">
                        Aucune commande pour le moment
                    </div>
                @endif
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
