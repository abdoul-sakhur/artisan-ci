<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'ArtisanMarket - Marketplace d\'Artisanat Cote d\'ivoire' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation publique -->
        <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <span class="text-2xl font-bold text-gray-900">🏺 ArtisanMarket</span>
                        </a>
                    </div>

                    <!-- Navigation principale -->
                    <div class="hidden md:flex md:items-center md:space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-gray-900 font-semibold' : '' }}">
                            Accueil
                        </a>
                        <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium {{ request()->routeIs('shop.*') ? 'text-gray-900 font-semibold' : '' }}">
                            Boutique
                        </a>
                    </div>

                    <!-- Compte utilisateur -->
                    <div class="flex items-center space-x-4">
                        <!-- Panier (à venir) -->
                        <a href="#" class="relative text-gray-700 hover:text-gray-900">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </a>

                        @auth
                            <!-- Utilisateur connecté -->
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 text-sm font-medium">
                                    {{ Auth::user()->name }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-700 hover:text-gray-900 text-sm">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Utilisateur non connecté -->
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 text-sm font-medium">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800">
                                S'inscrire
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenu principal -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- À propos -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">🏺 ArtisanMarket</h3>
                        <p class="text-gray-400 text-sm">
                            Marketplace dédiée à l'artisanat Cote d'ivoire authentique. Soutenez les artisans locaux.
                        </p>
                    </div>

                    <!-- Liens rapides -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Accueil</a></li>
                            <li><a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-white">Boutique</a></li>
                        </ul>
                    </div>

                    <!-- Informations -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Informations</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-gray-400 hover:text-white">À propos</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Devenir artisan</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li>📧 contact@artisanmarket.ma</li>
                            <li>📞 +212 5XX XX XX XX</li>
                            <li>📍 Cote d'ivoire</li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} ArtisanMarket. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
