<nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false, cartDropdownOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('front.home') }}" class="flex items-center">
                    <span class="text-2xl font-bold text-amber-600">🏺</span>
                    <span class="ml-2 text-xl font-bold text-gray-900">Artisans du Maroc</span>
                </a>
            </div>

            {{-- Navigation principale (Desktop) --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('front.home') }}" 
                   class="text-gray-700 hover:text-amber-600 transition-colors font-medium {{ request()->routeIs('front.home') ? 'text-amber-600' : '' }}">
                    🏠 Accueil
                </a>
                <a href="{{ route('front.shop.index') }}" 
                   class="text-gray-700 hover:text-amber-600 transition-colors font-medium {{ request()->routeIs('front.shop.*') ? 'text-amber-600' : '' }}">
                    🛍️ Boutique
                </a>
                <a href="{{ route('front.artisans.index') }}" 
                   class="text-gray-700 hover:text-amber-600 transition-colors font-medium {{ request()->routeIs('front.artisans.*') ? 'text-amber-600' : '' }}">
                    👥 Artisans
                </a>
            </div>

            {{-- Actions utilisateur (Desktop) --}}
            <div class="hidden md:flex items-center space-x-4">
                
                {{-- Mini panier --}}
                <div class="relative" @click.away="cartDropdownOpen = false">
                    <button @click="cartDropdownOpen = !cartDropdownOpen" 
                            class="relative p-2 text-gray-700 hover:text-amber-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6H19"/>
                        </svg>
                        <span x-show="cartCount > 0" 
                              x-text="cartCount" 
                              class="absolute -top-1 -right-1 bg-amber-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold min-w-[1.25rem]">
                        </span>
                    </button>

                    {{-- Dropdown panier --}}
                    <div x-show="cartDropdownOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 py-4">
                        
                        <div class="px-4 pb-2 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-900">🛒 Mon Panier</h3>
                        </div>
                        
                        <div x-show="cartCount === 0" class="px-4 py-8 text-center text-gray-500">
                            <div class="text-4xl mb-2">🛒</div>
                            <p class="text-sm">Votre panier est vide</p>
                            <a href="{{ route('front.shop.index') }}" 
                               class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                                Découvrir nos créations →
                            </a>
                        </div>
                        
                        <div x-show="cartCount > 0">
                            <div class="max-h-64 overflow-y-auto">
                                <template x-for="item in cartItems" :key="item.product.id">
                                    <div class="px-4 py-3 border-b border-gray-100 last:border-0">
                                        <div class="flex items-center gap-3">
                                            <img :src="item.product.image || '/images/default-product.jpg'" 
                                                 :alt="item.product.name"
                                                 class="w-12 h-12 object-cover rounded">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 truncate" x-text="item.product.name"></h4>
                                                <p class="text-xs text-gray-500">
                                                    <span x-text="item.quantity"></span> × 
                                                    <span x-text="item.product.formatted_price"></span>
                                                </p>
                                            </div>
                                            <div class="text-sm font-semibold text-amber-600" x-text="item.formatted_subtotal"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            
                            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="font-semibold text-gray-900">Total</span>
                                    <span class="font-bold text-amber-600" x-text="cartTotal"></span>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('front.cart.index') }}" 
                                       class="flex-1 text-center bg-gray-100 text-gray-700 py-2 px-3 rounded text-sm hover:bg-gray-200 transition-colors">
                                        Voir panier
                                    </a>
                                    @auth
                                    <a href="{{ route('front.checkout.index') }}" 
                                       class="flex-1 text-center bg-amber-600 text-white py-2 px-3 rounded text-sm hover:bg-amber-700 transition-colors">
                                        Commander
                                    </a>
                                    @else
                                    <a href="{{ route('login') }}" 
                                       class="flex-1 text-center bg-amber-600 text-white py-2 px-3 rounded text-sm hover:bg-amber-700 transition-colors">
                                        Se connecter
                                    </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Authentification --}}
                @auth
                <div class="relative" x-data="{ userMenuOpen: false }" @click.away="userMenuOpen = false">
                    <button @click="userMenuOpen = !userMenuOpen" 
                            class="flex items-center text-gray-700 hover:text-amber-600 transition-colors">
                        <span class="mr-2">👤</span>
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                        <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <div x-show="userMenuOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1">
                        
                        <a href="{{ route('front.client.account') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">
                            📱 Mon compte
                        </a>
                        <a href="{{ route('front.client.orders') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">
                            📦 Mes commandes
                        </a>
                        
                        @if(Auth::user()->role === 'artisan')
                        <div class="border-t border-gray-200 my-1"></div>
                        <a href="{{ route('artisan.dashboard') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">
                            🎨 Espace Artisan
                        </a>
                        @endif
                        
                        @if(Auth::user()->role === 'admin')
                        <div class="border-t border-gray-200 my-1"></div>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">
                            ⚙️ Administration
                        </a>
                        @endif
                        
                        <div class="border-t border-gray-200 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                                🚪 Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 hover:text-amber-600 transition-colors font-medium">
                        🔐 Connexion
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition-colors font-medium">
                        📝 S'inscrire
                    </a>
                </div>
                @endauth
            </div>

            {{-- Menu mobile --}}
            <div class="md:hidden flex items-center space-x-2">
                {{-- Mini panier mobile --}}
                <a href="{{ route('front.cart.index') }}" class="relative p-2 text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6H19"/>
                    </svg>
                    <span x-show="cartCount > 0" 
                          x-text="cartCount" 
                          class="absolute -top-1 -right-1 bg-amber-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold min-w-[1.25rem]">
                    </span>
                </a>
                
                {{-- Bouton menu mobile --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="p-2 text-gray-700 hover:text-amber-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu mobile --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white border-t border-gray-200">
        
        <div class="px-4 py-2 space-y-1">
            <a href="{{ route('front.home') }}" 
               class="block px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded font-medium">
                🏠 Accueil
            </a>
            <a href="{{ route('front.shop.index') }}" 
               class="block px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded font-medium">
                🛍️ Boutique
            </a>
            <a href="{{ route('front.artisans.index') }}" 
               class="block px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded font-medium">
                👥 Artisans
            </a>
            
            @auth
            <div class="border-t border-gray-200 pt-2 mt-2">
                <a href="{{ route('front.client.account') }}" 
                   class="block px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded">
                    📱 Mon compte
                </a>
                <a href="{{ route('front.client.orders') }}" 
                   class="block px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded">
                    📦 Mes commandes
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" 
                            class="w-full text-left px-3 py-2 text-red-600 hover:bg-red-50 rounded">
                        🚪 Déconnexion
                    </button>
                </form>
            </div>
            @else
            <div class="border-t border-gray-200 pt-2 mt-2 space-y-1">
                <a href="{{ route('login') }}" 
                   class="block px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded font-medium">
                    🔐 Connexion
                </a>
                <a href="{{ route('register') }}" 
                   class="block px-3 py-2 bg-amber-600 text-white hover:bg-amber-700 rounded font-medium">
                    📝 S'inscrire
                </a>
            </div>
            @endauth
        </div>
    </div>
</nav>