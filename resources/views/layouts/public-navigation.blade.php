<nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false, cartDropdownOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('front.home') }}" class="flex items-center">
                    <svg class="w-10 h-10" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="95" fill="#F59E0B" opacity="0.2"/>
                        <path d="M140 70C140 70 145 50 150 45C155 40 165 35 165 35C165 35 170 45 165 55C160 65 150 75 140 70Z" fill="#D97706"/>
                        <ellipse cx="100" cy="85" rx="45" ry="40" fill="#F59E0B"/>
                        <path d="M70 100C70 100 65 140 70 155C75 170 90 175 90 175L95 160L85 145L70 100Z" fill="#D97706"/>
                        <path d="M130 100C130 100 135 140 130 155C125 170 110 175 110 175L105 160L115 145L130 100Z" fill="#D97706"/>
                        <circle cx="85" cy="75" r="6" fill="#1F2937"/>
                        <path d="M95 95C95 95 90 115 85 120C80 125 70 130 65 128C60 126 55 120 55 115C55 110 60 105 70 100C80 95 95 95 95 95Z" fill="#B45309"/>
                        <path d="M100 115L110 125" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"/>
                        <path d="M110 115L100 125" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="ml-3 text-xl font-bold text-gray-900">Artisans de Côte d'Ivoire</span>
                </a>
            </div>

            {{-- Navigation principale (Desktop) --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('front.home') }}" 
                   class="flex items-center gap-1.5 text-gray-700 hover:text-amber-600 transition-colors font-medium {{ request()->routeIs('front.home') ? 'text-amber-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Accueil</span>
                </a>
                <a href="{{ route('front.shop.index') }}" 
                   class="flex items-center gap-1.5 text-gray-700 hover:text-amber-600 transition-colors font-medium {{ request()->routeIs('front.shop.*') ? 'text-amber-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span>Boutique</span>
                </a>
                <a href="{{ route('front.artisans.index') }}" 
                   class="flex items-center gap-1.5 text-gray-700 hover:text-amber-600 transition-colors font-medium {{ request()->routeIs('front.artisans.*') ? 'text-amber-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Artisans</span>
                </a>
            </div>

            {{-- Actions utilisateur (Desktop) --}}
            <div class="hidden md:flex items-center space-x-4">
                
                {{-- Mini panier (uniquement pour non-artisans) --}}
                @if(!auth()->check() || !auth()->user()->hasRole('artisan'))
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
                            <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#D97706" d="M6.005 9h13.938l.5-2H8.005V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5.004a1 1 0 0 1-1-1V4h-2V2h3a1 1 0 0 1 1 1zm0 14a2 2 0 1 1 0-4a2 2 0 0 1 0 4m12 0a2 2 0 1 1 0-4a2 2 0 0 1 0 4"/></svg>
                                Mon Panier
                            </h3>
                        </div>
                        
                        <div x-show="cartCount === 0" class="px-4 py-8 text-center text-gray-500">
                            <div class="mb-2">
                                <svg class="h-10 w-10 text-amber-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6H19"/></svg>
                            </div>
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
                                            <template x-if="item.product.image">
                                                <img :src="item.product.image" 
                                                     :alt="item.product.name"
                                                     class="w-12 h-12 object-cover rounded">
                                            </template>
                                            <template x-if="!item.product.image">
                                                <div class="w-12 h-12 bg-gray-200 rounded"></div>
                                            </template>
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
                @endif

                {{-- Authentification --}}
                @auth
                <div class="relative" x-data="{ userMenuOpen: false }" @click.away="userMenuOpen = false">
                    <button @click="userMenuOpen = !userMenuOpen" 
                            class="flex items-center text-gray-700 hover:text-amber-600 transition-colors">
                        <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
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
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Mon compte
                        </a>
                        <a href="{{ route('front.client.orders') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            Mes commandes
                        </a>
                        
                        @if(Auth::user()->role === 'artisan')
                        <div class="border-t border-gray-200 my-1"></div>
                        <a href="{{ route('artisan.dashboard') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t border-gray-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                            Espace Artisan
                        </a>
                        @endif
                        
                        @if(Auth::user()->role === 'admin')
                        <div class="border-t border-gray-200 my-1"></div>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Administration
                        </a>
                        @endif
                        
                        <div class="border-t border-gray-200 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 flex items-center gap-2">
                                <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="currentColor" d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1zm6-4V8l5 4l-5 4v-3H2v-2z"/></svg>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 hover:text-amber-600 transition-colors font-medium flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#D97706" d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1zm6-4V8l5 4l-5 4v-3H2v-2z"/></svg> Connexion
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition-colors font-medium flex items-center gap-1.5">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#fff" fill-rule="evenodd" d="M10.845 8.095a.75.75 0 0 0 0 1.06l1.72 1.72h-8.19a.75.75 0 0 0 0 1.5h8.19l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 0 0-1.06 0" clip-rule="evenodd"/><path fill="#fff" d="M12.375 5.877c0 .448.274.84.591 1.157l3 3a2.25 2.25 0 0 1 0 3.182l-3 3c-.317.317-.591.709-.591 1.157v2.252a8 8 0 1 0 0-16z"/></svg>                        S'inscrire
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
               class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Accueil</span>
            </a>
            <a href="{{ route('front.shop.index') }}" 
               class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span>Boutique</span>
            </a>
            <a href="{{ route('front.artisans.index') }}" 
               class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>Artisans</span>
            </a>
            
            @auth
            <div class="border-t border-gray-200 pt-2 mt-2">
                <a href="{{ route('front.client.account') }}" 
                   class="block px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Mon compte
                </a>
                <a href="{{ route('front.client.orders') }}" 
                   class="block px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Mes commandes
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" 
                            class="w-full text-left px-3 py-2 text-red-600 hover:bg-red-50 rounded flex items-center gap-2">
                        <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="currentColor" d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1zm6-4V8l5 4l-5 4v-3H2v-2z"/></svg>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
            @else
            <div class="border-t border-gray-200 pt-2 mt-2 space-y-1">
                <a href="{{ route('login') }}" 
                   class="block px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="10" rx="2"/><path d="M8 10V7a4 4 0 018 0v3"/></svg>
                    <span>Connexion</span>
                </a>
                <a href="{{ route('register') }}" 
                   class="block px-3 py-2 bg-amber-600 text-white hover:bg-amber-700 rounded font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#ffffff" d="M12.375 5.877c0 .448.274.84.591 1.157l3 3a2.25 2.25 0 0 1 0 3.182l-3 3c-.317.317-.591.709-.591 1.157v2.252a8 8 0 1 0 0-16z"/><path fill="#ffffff" fill-rule="evenodd" d="M10.845 8.095a.75.75 0 0 0 0 1.06l1.72 1.72h-8.19a.75.75 0 0 0 0 1.5h8.19l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 0 0-1.06 0" clip-rule="evenodd"/></svg>
                    <span>S'inscrire</span>
                </a>
            </div>
            @endauth
        </div>
    </div>
</nav>