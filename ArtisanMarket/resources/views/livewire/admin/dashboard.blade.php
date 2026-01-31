<div>
    <!-- Header Section -->
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-900">Dashboard Admin</h3>
        <p class="mt-1 text-sm text-gray-600">Vue d'ensemble de la plateforme ArtisanMarket</p>
    </div>

    <!-- Period Selector -->
    <div class="mb-6 flex items-center space-x-4">
        <span class="text-sm font-medium text-gray-700">Période :</span>
        <div class="flex space-x-2">
            <button 
                wire:click="changePeriod('7days')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ $period === '7days' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                7 jours
            </button>
            <button 
                wire:click="changePeriod('30days')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ $period === '30days' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                30 jours
            </button>
            <button 
                wire:click="changePeriod('all')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ $period === 'all' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                Tout
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Artisans Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Artisans</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalArtisans }}</p>
                    @if($pendingArtisans > 0)
                        <p class="text-blue-100 text-xs mt-2">
                            {{ $pendingArtisans }} en attente
                        </p>
                    @endif
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Clients Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Clients</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalClients }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Produits</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalProducts }}</p>
                    <p class="text-purple-100 text-xs mt-2">
                        {{ $publishedProducts }} publiés
                    </p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Revenus</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($totalRevenue, 2) }} €</p>
                    <p class="text-yellow-100 text-xs mt-2">
                        {{ $totalOrders }} commandes
                    </p>
                </div>
                <div class="bg-yellow-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900">Commandes Récentes</h4>
            </div>
            <div class="p-6">
                @if($recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ $order->order_number }}
                                        </span>
                                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $order->user->name }} → {{ $order->artisan->shop_name }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $order->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-indigo-600">
                                        {{ number_format($order->total_amount, 2) }} €
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center py-8">Aucune commande récente</p>
                @endif
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900">Produits Populaires</h4>
            </div>
            <div class="p-6">
                @if($topProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($topProducts as $product)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center flex-1">
                                    <div class="w-12 h-12 bg-gray-200 rounded flex-shrink-0">
                                        @if($product->primaryImage)
                                            <img 
                                                src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                                alt="{{ $product->name }}"
                                                class="w-full h-full object-cover rounded">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $product->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $product->category->name }} • {{ $product->artisan->shop_name }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            👁️ {{ $product->views_count }} vues
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="text-sm font-bold text-indigo-600">
                                        {{ number_format($product->price, 2) }} €
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center py-8">Aucun produit publié</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="fixed top-4 right-4 z-50">
        <div class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg flex items-center">
            <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Chargement...
        </div>
    </div>
</div>
