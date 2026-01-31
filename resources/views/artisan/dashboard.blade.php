<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Artisan') }} - {{ $artisan->shop_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <x-ui.alert variant="success" dismissible>
                    {{ session('success') }}
                </x-ui.alert>
            @endif

            {{-- Statistiques principales --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <x-ui.stat-card 
                    title="Produits" 
                    :value="$stats['total_products']" 
                    icon="cube"
                    :subtitle="$stats['published_products'] . ' publiés'"
                />
                <x-ui.stat-card 
                    title="Commandes" 
                    :value="$stats['total_orders']" 
                    icon="shopping-bag"
                    :subtitle="$stats['pending_orders'] . ' en attente'"
                    :color="$stats['pending_orders'] > 0 ? 'warning' : 'default'"
                />
                <x-ui.stat-card 
                    title="Revenus" 
                    :value="number_format($stats['total_revenue'], 0) . ' FCFA'" 
                    icon="currency-dollar"
                />
                <x-ui.stat-card 
                    title="Stock Bas" 
                    :value="$stats['low_stock_products']" 
                    icon="exclamation"
                    :color="$stats['low_stock_products'] > 0 ? 'destructive' : 'success'"
                />
            </div>

            {{-- Alertes produits --}}
            @if($outOfStockProducts->count() > 0)
                <x-ui.alert variant="warning">
                    <div class="flex justify-between items-center">
                        <div>
                            <strong>Attention !</strong> {{ $outOfStockProducts->count() }} produit(s) en rupture ou stock faible.
                        </div>
                        <x-ui.button size="sm" variant="outline" href="{{ route('artisan.products.index', ['status' => 'low_stock']) }}">
                            Voir
                        </x-ui.button>
                    </div>
                </x-ui.alert>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Dernières commandes --}}
                <x-ui.card>
                    <div class="px-4 py-5 sm:px-6 border-b">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Dernières Commandes
                            </h3>
                            <x-ui.button size="sm" variant="outline" href="{{ route('artisan.orders.index') }}">
                                Voir tout
                            </x-ui.button>
                        </div>
                    </div>

                    @if($recentOrders->count() > 0)
                        <div class="divide-y">
                            @foreach($recentOrders->take(5) as $order)
                                <div class="p-4 hover:bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                #{{ $order->order_number }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $order->user->name }} • {{ $order->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'confirmed' => 'default',
                                                    'processing' => 'default',
                                                    'shipped' => 'default',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'destructive',
                                                ];
                                            @endphp
                                            <x-ui.badge :variant="$statusColors[$order->status] ?? 'secondary'">
                                                {{ ucfirst($order->status) }}
                                            </x-ui.badge>
                                            <p class="text-sm font-medium text-gray-900 mt-1">
                                                {{ number_format($order->total_amount, 0) }} FCFA
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            Aucune commande pour le moment
                        </div>
                    @endif
                </x-ui.card>

                {{-- Produits les plus vendus --}}
                <x-ui.card>
                    <div class="px-4 py-5 sm:px-6 border-b">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Top 5 Produits
                        </h3>
                    </div>

                    @if($topProducts->count() > 0)
                        <div class="divide-y">
                            @foreach($topProducts as $product)
                                <div class="p-4 hover:bg-gray-50">
                                    <div class="flex justify-between items-center">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $product->name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $product->order_items_count }} vente(s) • Stock: {{ $product->quantity }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ number_format($product->price, 0) }} FCFA
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            Aucune vente pour le moment
                        </div>
                    @endif
                </x-ui.card>
            </div>

            {{-- Actions rapides --}}
            <x-ui.card>
                <div class="px-4 py-5 sm:px-6 border-b">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Actions Rapides
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <x-ui.button href="{{ route('artisan.products.create') }}" class="justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Nouveau Produit
                        </x-ui.button>
                        <x-ui.button variant="outline" href="{{ route('artisan.orders.index', ['status' => 'pending']) }}" class="justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Commandes en Attente
                        </x-ui.button>
                        <x-ui.button variant="outline" href="{{ route('artisan.profile.edit') }}" class="justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Gérer ma Boutique
                        </x-ui.button>
                    </div>
                </div>
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
