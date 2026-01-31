<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Artisans du Maroc'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" x-data="cartManager()" @cart-updated.window="updateCart($event.detail)">
        <div class="min-h-screen bg-gray-100">
            @if(request()->is('admin/*') || request()->routeIs('admin.*'))
                @include('components.admin-navigation')
            @elseif(request()->is('artisan/*') || request()->routeIs('artisan.*'))
                @include('components.artisan-navigation')
            @else
                @include('layouts.public-navigation')
            @endif

            <!-- Page Heading -->
            @if(isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @if(!request()->is('admin/*') && !request()->is('artisan/*'))
                    @yield('content')
                @else
                    {{ $slot }}
                @endif
            </main>
        </div>

        <script>
        function cartManager() {
            return {
                cartCount: {{ app('App\Services\CartService')->getCount() }},
                cartTotal: '{{ app('App\Services\CartService')->getFormattedTotal() }}',
                cartItems: @json(app('App\Services\CartService')->getItems()),
                
                updateCart(cartData) {
                    this.cartCount = cartData.count;
                    this.cartTotal = cartData.formatted_total;
                    this.cartItems = cartData.items;
                },
                
                async loadCartData() {
                    try {
                        const response = await fetch('{{ route("front.cart.count") }}');
                        const data = await response.json();
                        this.cartCount = data.count;
                    } catch (error) {
                        console.error('Erreur lors du chargement du panier:', error);
                    }
                }
            }
        }
        </script>
    </body>
</html>
