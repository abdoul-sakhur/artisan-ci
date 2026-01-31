<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }" x-cloak>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ArtisanMarket') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar (Mobile) -->
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
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-indigo-800 to-indigo-900 text-white transform lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-200 ease-in-out"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-indigo-900 border-b border-indigo-700">
                <h1 class="text-2xl font-bold">
                    <span class="text-white">Artisan</span><span class="text-yellow-400">Market</span>
                </h1>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Validation Artisans -->
                <a href="{{ route('admin.artisans.approval') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.artisans.approval') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Validation Artisans
                    @php
                        $pendingCount = \App\Models\Artisan::where('is_approved', false)->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto px-2 py-1 text-xs font-semibold rounded-full bg-red-500 text-white">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                <!-- Modération Produits -->
                <a href="{{ route('admin.products.moderation') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.products.moderation') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Modération Produits
                </a>

                <!-- Divider -->
                <div class="my-4 border-t border-indigo-700"></div>

                <!-- Gestion Utilisateurs -->
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Utilisateurs
                </a>

                <!-- Catégories -->
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 text-indigo-100 hover:bg-indigo-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Catégories
                </a>
            </nav>

            <!-- User Profile -->
            <div class="p-4 border-t border-indigo-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-sm font-semibold">{{ substr(Auth::user()->name, 0, 2) }}</span>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-indigo-300">Administrateur</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm text-left text-indigo-100 hover:bg-indigo-700 rounded-lg transition-colors duration-200">
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

                    <!-- Notifications -->
                    <div class="flex items-center space-x-4">
                        <!-- Notification Bell -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                @php
                                    $pendingCount = \App\Models\Artisan::where('is_approved', false)->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                                @endif
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50"
                                 style="display: none;">
                                <div class="p-4 border-b">
                                    <h3 class="text-sm font-semibold text-gray-700">Notifications</h3>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    @if($pendingCount > 0)
                                        <a href="{{ route('admin.artisans.approval') }}" class="block px-4 py-3 hover:bg-gray-50">
                                            <p class="text-sm text-gray-800">{{ $pendingCount }} artisan(s) en attente de validation</p>
                                            <p class="text-xs text-gray-500 mt-1">Il y a quelques minutes</p>
                                        </a>
                                    @else
                                        <div class="px-4 py-8 text-center">
                                            <p class="text-sm text-gray-500">Aucune notification</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} ArtisanMarket. Tous droits réservés.</p>
                    <p>Version 1.0.0</p>
                </div>
            </footer>
        </div>
    </div>

    @livewireScripts
    
    <!-- Livewire Notifications (Toast) -->
    <div 
        x-data="{ show: false, message: '' }"
        @notify.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="fixed top-4 right-4 z-50 px-6 py-4 bg-green-500 text-white rounded-lg shadow-lg"
        style="display: none;">
        <p x-text="message"></p>
    </div>
</body>
</html>
