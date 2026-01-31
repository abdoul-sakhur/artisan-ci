@extends('layouts.app')

@section('title', $artisan->name . ' - Artisans du Maroc')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb --}}
        <nav class="text-sm mb-6">
            <a href="{{ route('front.home') }}" class="text-gray-500 hover:text-amber-600">Accueil</a>
            <span class="mx-2 text-gray-400">•</span>
            <a href="{{ route('front.artisans.index') }}" class="text-gray-500 hover:text-amber-600">Artisans</a>
            <span class="mx-2 text-gray-400">•</span>
            <span class="text-gray-900 font-medium">{{ $artisan->name }}</span>
        </nav>

        {{-- Profil artisan --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="relative h-48 bg-gradient-to-br from-amber-50 via-orange-50 to-amber-100">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                @if($artisan->is_featured)
                <div class="absolute top-4 right-4">
                    <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                        ⭐ Artisan Certifié
                    </span>
                </div>
                @endif
            </div>
            
            <div class="relative px-6 pb-6">
                <div class="flex flex-col sm:flex-row items-start gap-6 -mt-16 relative z-10">
                    <div class="shrink-0">
                        @if($artisan->logo_url)
                        <img src="{{ $artisan->logo_url }}" 
                             alt="{{ $artisan->name }}"
                             class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-lg">
                        @else
                        <div class="w-32 h-32 bg-amber-100 rounded-full border-4 border-white shadow-lg flex items-center justify-center text-4xl">
                            🎨
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 pt-16 sm:pt-4">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $artisan->name }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-4 mb-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <span class="mr-1">📦</span>
                                <span>{{ $products->total() }} créations</span>
                            </div>
                            <div class="flex items-center">
                                <span class="mr-1">📅</span>
                                <span>Membre depuis {{ $artisan->created_at->format('F Y') }}</span>
                            </div>
                            @if($artisan->city)
                            <div class="flex items-center">
                                <span class="mr-1">📍</span>
                                <span>{{ $artisan->city }}</span>
                            </div>
                            @endif
                        </div>
                        
                        @if($artisan->specialties)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach(explode(',', $artisan->specialties) as $specialty)
                            <span class="bg-amber-100 text-amber-700 text-sm px-3 py-1 rounded-full">
                                {{ trim($specialty) }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                        
                        @if($artisan->bio)
                        <div class="prose prose-sm max-w-none">
                            <p class="text-gray-600 leading-relaxed">{{ $artisan->bio }}</p>
                        </div>
                        @endif
                        
                        @if($artisan->phone || $artisan->email)
                        <div class="mt-4 flex gap-3">
                            @if($artisan->phone)
                            <a href="tel:{{ $artisan->phone }}" 
                               class="flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                                📞 Contacter
                            </a>
                            @endif
                            @if($artisan->email)
                            <a href="mailto:{{ $artisan->email }}" 
                               class="flex items-center px-4 py-2 border border-amber-600 text-amber-600 rounded-lg hover:bg-amber-50 transition-colors">
                                📧 Email
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Filtres et tri --}}
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Créations ({{ $products->total() }})
                    </h2>
                    @if($categories->count() > 1)
                    <select name="category" 
                            onchange="window.location.href = updateUrlParameter(window.location.href, 'category', this.value)"
                            class="px-3 py-1 border border-gray-300 rounded text-sm focus:ring-amber-500 focus:border-amber-500">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @endif
                </div>
                
                <select name="sort" 
                        onchange="window.location.href = updateUrlParameter(window.location.href, 'sort', this.value)"
                        class="px-3 py-1 border border-gray-300 rounded text-sm focus:ring-amber-500 focus:border-amber-500">
                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                        Plus récents
                    </option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                        Prix croissant
                    </option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                        Prix décroissant
                    </option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                        Alphabétique
                    </option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>
                        Plus populaires
                    </option>
                </select>
            </div>
        </div>

        {{-- Grille des produits --}}
        @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($products as $product)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow overflow-hidden">
                <div class="relative">
                    <a href="{{ route('front.shop.product', $product->slug) }}">
                        <img src="{{ $product->images->first()?->image_url ?? '/images/default-product.jpg' }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-64 object-cover">
                    </a>
                    @if($product->is_featured)
                    <div class="absolute top-3 left-3">
                        <span class="bg-amber-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                            ⭐ Vedette
                        </span>
                    </div>
                    @endif
                    @if($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                    <div class="absolute top-3 right-3">
                        <span class="bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                            Stock limité
                        </span>
                    </div>
                    @elseif($product->stock_quantity == 0)
                    <div class="absolute top-3 right-3">
                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                            Rupture
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="p-5">
                    <h3 class="font-semibold text-gray-900 mb-2">
                        <a href="{{ route('front.shop.product', $product->slug) }}" 
                           class="hover:text-amber-600 transition-colors">
                            {{ $product->name }}
                        </a>
                    </h3>
                    
                    <p class="text-sm text-gray-500 mb-3">{{ $product->category->name }}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold text-amber-600">
                            {{ $product->formatted_price }}
                        </span>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $product->views_count }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
        
        @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="text-6xl mb-6">🎨</div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune création disponible</h3>
            <p class="text-gray-600 mb-6">
                Cet artisan n'a pas encore publié de créations ou elles sont en cours de préparation.
            </p>
            <a href="{{ route('front.shop.index') }}" 
               class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors font-semibold">
                Découvrir d'autres créations
            </a>
        </div>
        @endif
    </div>
</div>

<script>
function updateUrlParameter(url, param, paramVal) {
    const newAdditionalURL = param + '=' + paramVal;
    let tempArray = url.split('?');
    let baseURL = tempArray[0];
    let additionalURL = tempArray[1];
    let temp = '';

    if (additionalURL) {
        tempArray = additionalURL.split('&');
        for (let i = 0; i < tempArray.length; i++) {
            if (tempArray[i].split('=')[0] !== param) {
                temp += tempArray[i] + '&';
            }
        }
    }

    return baseURL + '?' + temp + newAdditionalURL;
}
</script>
@endsection