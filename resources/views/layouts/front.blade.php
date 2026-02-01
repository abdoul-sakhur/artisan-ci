<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="@yield('meta_description', 'Découvrez des créations artisanales uniques du . Marketplace des artisans ains - qualité, authenticité et savoir-faire traditionnel.')">
    <meta name="keywords" content="@yield('meta_keywords', 'artisanat, , artisans, créations uniques, fait main, marketplace artisanale')">
    <meta name="author" content="Artisans  ">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', config('app.name', 'Artisans  '))">
    <meta property="og:description" content="@yield('og_description', 'Marketplace des créateurs et artisans ')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    
    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter_title', config('app.name', 'Artisans u '))">
    <meta property="twitter:description" content="@yield('twitter_description', 'Marketplace des créateurs et artisans')">
    <meta property="twitter:image" content="@yield('twitter_image', asset('images/og-default.jpg'))">

    <title>@yield('title', config('app.name', 'Artisans'))</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&family=playfair-display:400,500,600,700&display=swap" rel="stylesheet" />
    
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    {{-- Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Additional Styles --}}
    @stack('styles')
    
    <style>
        /* Animation keyframes pour hero et composants */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f5f5f4;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #d97706;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #b45309;
        }
    </style>
</head>

<body class="font-sans antialiased bg-stone-50" x-data="cartManager()" @cart-updated.window="updateCart($event.detail)">
    
    {{-- Navigation publique --}}
    @include('layouts.public-navigation')
    
    {{-- Contenu principal --}}
    <main>
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm" 
                     x-data="{ show: true }" 
                     x-show="show" 
                     x-transition
                     x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" 
                     x-data="{ show: true }" 
                     x-show="show" 
                     x-transition
                     x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    {{-- Footer --}}
    @include('layouts.public-footer')
    
    {{-- Alpine.js Cart Manager --}}
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
                    this.cartTotal = data.formatted_total;
                    this.cartItems = data.items;
                } catch (error) {
                    console.error('Erreur lors du chargement du panier:', error);
                }
            },
            
            async removeItem(productId) {
                try {
                    const response = await fetch(`{{ url('cart/remove') }}/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        this.updateCart(data);
                        window.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
                    }
                } catch (error) {
                    console.error('Erreur lors de la suppression:', error);
                }
            }
        }
    }
    </script>
    
    {{-- Additional Scripts --}}
    @stack('scripts')
    
</body>
</html>
