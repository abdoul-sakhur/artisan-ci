<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Messages Flash --}}
            @if(session('success'))
                <x-ui.alert variant="success" dismissible>
                    {{ session('success') }}
                </x-ui.alert>
            @endif

            {{-- Statistiques Principales --}}
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <x-ui.stat-card 
                    title="Utilisateurs Total" 
                    :value="$stats['total_users']"
                >
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </x-slot>
                </x-ui.stat-card>

                <x-ui.stat-card 
                    title="Artisans" 
                    :value="$stats['total_artisans']"
                    description="{{ $stats['pending_artisans'] }} en attente"
                >
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </x-slot>
                </x-ui.stat-card>

                <x-ui.stat-card 
                    title="Produits" 
                    :value="$stats['total_products']"
                    description="{{ $stats['published_products'] }} publiés"
                >
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </x-slot>
                </x-ui.stat-card>

                <x-ui.stat-card 
                    title="Revenus Total" 
                    :value="number_format($stats['total_revenue'], 2) . ' FCFA'"
                    description="{{ $stats['total_orders'] }} commandes"
                >
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </x-slot>
                </x-ui.stat-card>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                {{-- Artisans En Attente --}}
                <x-ui.card title="Artisans en attente de validation" description="{{ $stats['pending_artisans'] }} artisan(s) à valider">
                    @if($pendingArtisans->count() > 0)
                        <div class="space-y-3">
                            @foreach($pendingArtisans as $artisan)
                                <div class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                                    <div class="flex-1">
                                        <h4 class="font-semibold">{{ $artisan->shop_name }}</h4>
                                        <p class="text-sm text-muted-foreground">{{ $artisan->user->name }} • {{ $artisan->user->email }}</p>
                                        <p class="text-xs text-muted-foreground">{{ $artisan->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <x-ui.button 
                                            size="sm" 
                                            variant="outline"
                                            href="{{ route('admin.artisans.show', $artisan) }}"
                                        >
                                            Voir
                                        </x-ui.button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($stats['pending_artisans'] > 5)
                            <div class="mt-4">
                                <x-ui.button variant="outline" href="{{ route('admin.artisans.index', ['status' => 'pending']) }}" class="w-full">
                                    Voir tous les artisans en attente ({{ $stats['pending_artisans'] }})
                                </x-ui.button>
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-muted-foreground text-center py-8">
                            Aucun artisan en attente de validation
                        </p>
                    @endif
                </x-ui.card>

                {{-- Top Artisans --}}
                <x-ui.card title="Top 5 Artisans" description="Artisans avec le plus de commandes">
                    @if($topArtisans->count() > 0)
                        <div class="space-y-3">
                            @foreach($topArtisans as $index => $artisan)
                                <div class="flex items-center gap-3 p-3 border rounded-lg">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 text-primary font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold">{{ $artisan->shop_name }}</h4>
                                        <p class="text-sm text-muted-foreground">{{ $artisan->user->name }}</p>
                                    </div>
                                    <x-ui.badge variant="secondary">
                                        {{ $artisan->orders_count }} commande(s)
                                    </x-ui.badge>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-muted-foreground text-center py-8">
                            Aucune donnée de vente disponible
                        </p>
                    @endif
                </x-ui.card>
            </div>

            {{-- Dernières Commandes --}}
            <x-ui.card title="Dernières Commandes" description="10 dernières commandes">
                @if($recentOrders->count() > 0)
                    <x-ui.table>
                        <thead class="border-b">
                            <tr>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Commande</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Client</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Artisan</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Montant</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Statut</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-4 align-middle font-medium">{{ $order->order_number }}</td>
                                    <td class="p-4 align-middle">{{ $order->user->name }}</td>
                                    <td class="p-4 align-middle">{{ $order->artisan->shop_name }}</td>
                                    <td class="p-4 align-middle">{{ number_format($order->total_amount, 2) }} FCFA</td>
                                    <td class="p-4 align-middle">
                                        @php
                                            $statusVariant = match($order->status) {
                                                'pending' => 'warning',
                                                'confirmed', 'processing' => 'default',
                                                'shipped' => 'secondary',
                                                'delivered' => 'success',
                                                'cancelled' => 'destructive',
                                                default => 'outline',
                                            };
                                            $statusLabel = match($order->status) {
                                                'pending' => 'En attente',
                                                'confirmed' => 'Confirmée',
                                                'processing' => 'En préparation',
                                                'shipped' => 'Expédiée',
                                                'delivered' => 'Livrée',
                                                'cancelled' => 'Annulée',
                                                default => $order->status,
                                            };
                                        @endphp
                                        <x-ui.badge :variant="$statusVariant">{{ $statusLabel }}</x-ui.badge>
                                    </td>
                                    <td class="p-4 align-middle text-sm text-muted-foreground">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>
                @else
                    <p class="text-sm text-muted-foreground text-center py-8">
                        Aucune commande enregistrée
                    </p>
                @endif
            </x-ui.card>

        </div>
    </div>
</x-app-layout>

