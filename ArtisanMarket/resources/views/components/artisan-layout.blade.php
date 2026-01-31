<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }" x-cloak>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ArtisanMarket') }} - Espace Artisan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             @click.away="sidebarOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 lg:hidden">
        </div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-purple-700 to-purple-900 text-white transform lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-200 ease-in-out"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-purple-900 border-b border-purple-700">
                <h1 class="text-2xl font-bold">
                    <span class="text-white">Artisan</span><span class="text-yellow-400">Market</span>
                </h1>
            </div>

            <!-- Shop Info -->
            @php
                $artisan = Auth::user()->artisan;
            @endphp
            @if($artisan)
                <div class="p-4 border-b border-purple-700 bg-purple-800">
                    <div class="flex items-center">
                        @if($artisan->shop_logo)
                            <img src="{{ asset('storage/' . $artisan->shop_logo) }}" 
                                 class="w-12 h-12 rounded-full object-cover"
                                 alt="{{ $artisan->shop_name }}">
                        @else
                            <div class="w-12 h-12 rounded-full bg-purple-600 flex items-center justify-center">
                                <span class="text-lg font-semibold">{{ substr($artisan->shop_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold truncate">{{ $artisan->shop_name }}</p>
                            @if($artisan->is_approved)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    ✓ Approuvé
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                    En attente
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('artisan.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('artisan.dashboard') ? 'bg-purple-700 text-white' : 'text-purple-100 hover:bg-purple-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Mes Produits -->
                <a href="{{ route('artisan.products.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('artisan.products.*') ? 'bg-purple-700 text-white' : 'text-purple-100 hover:bg-purple-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Mes Produits
                </a>

                <!-- Mes Commandes -->
                <a href="{{ route('artisan.orders.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('artisan.orders.*') ? 'bg-purple-700 text-white' : 'text-purple-100 hover:bg-purple-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Mes Commandes
                    @php
                        $pendingOrders = $artisan ? $artisan->orders()->where('status', 'pending')->count() : 0;
                    @endphp
                    @if($pendingOrders > 0)
                        <span class="ml-auto px-2 py-1 text-xs font-semibold rounded-full bg-red-500 text-white">
                            {{ $pendingOrders }}
                        </span>
                    @endif
                </a>

                <!-- Divider -->
                <div class="my-4 border-t border-purple-700"></div>

                <!-- Paramètres Boutique -->
                <a href="{{ route('artisan.shop.settings') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('artisan.shop.settings') ? 'bg-purple-700 text-white' : 'text-purple-100 hover:bg-purple-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Paramètres
                </a>

                <!-- Ma Boutique Publique -->
                @if($artisan && $artisan->is_approved)
                    <a href="{{ route('shop.show', $artisan->id) }}" 
                       target="_blank"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 text-purple-100 hover:bg-purple-700">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Voir ma boutique
                    </a>
                @endif
            </nav>

            <!-- User Profile -->
            <div class="p-4 border-t border-purple-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center">
                        <span class="text-sm font-semibold">{{ substr(Auth::user()->name, 0, 2) }}</span>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-purple-300">Artisan</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm text-left text-purple-100 hover:bg-purple-700 rounded-lg transition-colors duration-200">
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Mobile menu button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Page Title -->
                    <h2 class="text-xl font-semibold text-gray-800">
                        @yield('header', 'Dashboard')
                    </h2>

                    <!-- Quick Actions -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('artisan.products.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nouveau Produit
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} ArtisanMarket. Tous droits réservés.</p>
                    <p>Espace Artisan</p>
                </div>
            </footer>
        </div>
    </div>

    @livewireScripts
    
    <!-- Livewire Notifications Toast -->
    <div 
        x-data="{ show: false, message: '', type: 'success' }"
        @notify.window="show = true; message = $event.detail.message || $event.detail; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg text-white"
        :class="type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'"
        style="display: none;">
        <p x-text="message"></p>
    </div>
</body>
</html>
