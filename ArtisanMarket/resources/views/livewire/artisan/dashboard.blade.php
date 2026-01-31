<div>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord</h1>
        <p class="text-gray-600 mt-1">Bienvenue dans votre espace artisan</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Produits -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Produits</p>
                    <h3 class="text-3xl font-bold mt-1">{{ $totalProducts }}</h3>
                    <p class="text-blue-100 text-xs mt-1">{{ $publishedProducts }} publiés</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Commandes -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Commandes</p>
                    <h3 class="text-3xl font-bold mt-1">{{ $totalOrders }}</h3>
                    <p class="text-green-100 text-xs mt-1">{{ $pendingOrders }} en attente</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenus -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Revenus Total</p>
                    <h3 class="text-3xl font-bold mt-1">{{ number_format($totalRevenue, 0, ',', ' ') }} DH</h3>
                    <p class="text-purple-100 text-xs mt-1">Toutes commandes</p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Vues -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Vues Total</p>
                    <h3 class="text-3xl font-bold mt-1">{{ number_format($totalViews, 0, ',', ' ') }}</h3>
                    <p class="text-orange-100 text-xs mt-1">Sur tous vos produits</p>
                </div>
                <div class="bg-orange-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Commandes Récentes -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-bold text-gray-900">Commandes Récentes</h2>
            </div>
            <div class="p-6">
                @if($recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-semibold text-gray-900">#{{ $order->order_number }}</span>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} DH</p>
                                    <a href="{{ route('artisan.orders.index') }}" class="text-xs text-purple-600 hover:text-purple-800">Voir détails →</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <p class="text-gray-500">Aucune commande pour le moment</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Produits les plus vus -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-bold text-gray-900">Produits les plus vus</h2>
            </div>
            <div class="p-6">
                @if($topProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($topProducts as $product)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                @if($product->primaryImage)
                                    <img src="{{ Storage::url($product->primaryImage->image_url) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ Str::limit($product->name, 30) }}</h3>
                                    <p class="text-sm text-gray-600">{{ number_format($product->price, 2) }} DH</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-purple-600">{{ $product->views_count }}</p>
                                    <p class="text-xs text-gray-500">vues</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="text-gray-500">Aucun produit ajouté</p>
                        <a href="{{ route('artisan.products.create') }}" class="mt-4 inline-block text-purple-600 hover:text-purple-800 font-medium">
                            Ajouter un produit →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
