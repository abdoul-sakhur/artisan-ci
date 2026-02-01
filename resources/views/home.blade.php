<x-public-layout>
    <x-slot name="title">Accueil - ArtisanMarket</x-slot>

    {{-- Hero Section --}}
    <div class="bg-gradient-to-r from-amber-50 to-orange-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Découvrez l'Artisanat Ivoirien Authentique
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Soutenez les artisans locaux et découvrez des œuvres uniques fabriquées à la main avec passion et savoir-faire traditionnel.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('shop.index') }}" class="bg-gray-900 text-white px-8 py-4 rounded-lg text-lg font-medium hover:bg-gray-800 transition">
                        Explorer la Boutique
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="bg-white text-gray-900 px-8 py-4 rounded-lg text-lg font-medium border-2 border-gray-900 hover:bg-gray-50 transition">
                            Devenir Artisan
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    {{-- Catégories populaires --}}
    @if($categories->count() > 0)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Catégories Populaires</h2>
                <p class="text-gray-600">Explorez nos différentes catégories d'artisanat</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="group">
                        <div class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition border border-gray-200">
                            <div class="mb-3">
                                @if(!empty($category->icon))
                                    <span class="text-4xl">{{ $category->icon }}</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-600 mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="5" y="7" width="14" height="13" rx="2" />
                                        <path d="M9 7a3 3 0 006 0" />
                                    </svg>
                                @endif
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-gray-600">
                                {{ $category->name }}
                            </h3>
                            <p class="text-sm text-gray-500">{{ $category->products_count }} produits</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Produits en vedette --}}
    @if($featuredProducts->count() > 0)
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Produits en Vedette</h2>
                    <p class="text-gray-600">Découvrez notre sélection de produits exceptionnels</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featuredProducts as $product)
                        <a href="{{ route('shop.show', $product->slug) }}" class="group">
                            <div class="bg-white rounded-lg overflow-hidden hover:shadow-xl transition border border-gray-200">
                                {{-- Image --}}
                                <div class="aspect-w-1 aspect-h-1 bg-gray-200 relative">
                                    @if($product->images->first())
                                        <img src="{{ $product->images->first()->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2">
                                        <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline-block mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor" stroke="none" />
                                            </svg>
                                            <span>Vedette</span>
                                        </span>
                                    </div>
                                </div>

                                {{-- Informations --}}
                                <div class="p-4">
                                    <p class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</p>
                                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-gray-600">
                                        {{ $product->name }}
                                    </h3>
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-900">
                                            {{ number_format($product->price, 0) }} FCFA
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            Stock: {{ $product->quantity }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Par {{ $product->artisan->shop_name }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('shop.index') }}" class="inline-block bg-gray-900 text-white px-8 py-3 rounded-lg font-medium hover:bg-gray-800 transition">
                        Voir tous les produits
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- Nouveaux produits --}}
    @if($newProducts->count() > 0)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Nouveautés</h2>
                <p class="text-gray-600">Les dernières créations de nos artisans</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($newProducts->take(4) as $product)
                    <a href="{{ route('shop.show', $product->slug) }}" class="group">
                        <div class="bg-white rounded-lg overflow-hidden hover:shadow-xl transition border border-gray-200">
                            <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                @if($product->images->first())
                                    <img src="{{ $product->images->first()->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</p>
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">
                                        {{ number_format($product->price, 0) }} FCFA
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Nos artisans --}}
    @if($artisans->count() > 0)
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Nos Artisans</h2>
                    <p class="text-gray-600">Découvrez les talents derrière nos créations</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($artisans as $artisan)
                        <div class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition border border-gray-200">
                            <div class="mb-4">
                                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="8" r="4" />
                                        <path d="M4 20c0-4 4-6 8-6s8 2 8 6" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $artisan->shop_name }}</h3>
                            @if($artisan->shop_description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $artisan->shop_description }}</p>
                            @endif
                            <p class="text-sm text-gray-500 mb-4">{{ $artisan->products_count }} produits</p>
                            <a href="{{ route('shop.index', ['artisan' => $artisan->id]) }}" class="text-sm text-gray-900 font-medium hover:text-gray-600">
                                Voir la boutique →
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</x-public-layout>
