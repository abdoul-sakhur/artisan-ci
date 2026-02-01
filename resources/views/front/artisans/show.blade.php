@extends('layouts.front')

@section('title', $artisan->name . ' - Artisans de Côte d\'Ivoire')

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
                    <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M9.153 5.408C10.42 3.136 11.053 2 12 2c.947 0 1.58 1.136 2.847 3.408l.328.588c.36.646.54.969.82 1.182.28.213.63.292 1.33.45l.636.144c2.46.557 3.689.835 3.982 1.776.292.94-.546 1.921-2.223 3.882l-.434.507c-.476.557-.715.836-.822 1.18-.107.345-.071.717.001 1.46l.066.677c.253 2.617.38 3.925-.386 4.506-.766.582-1.918.051-4.22-1.009l-.597-.274c-.654-.302-.981-.452-1.328-.452-.347 0-.674.15-1.328.452l-.596.274c-2.303 1.06-3.455 1.59-4.22 1.01-.767-.582-.64-1.89-.387-4.507l.066-.676c.072-.744.108-1.116.001-1.46-.107-.345-.346-.624-.822-1.18l-.434-.508c-1.677-1.96-2.515-2.941-2.223-3.882.293-.941 1.523-1.22 3.983-1.776l.636-.144c.699-.158 1.048-.237 1.329-.45.28-.213.46-.536.82-1.182l.328-.588Z"/></svg>
                        Artisan Certifié
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
                        <div class="w-32 h-32 bg-amber-100 rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                            <svg class="w-16 h-16" viewBox="0 0 24 24" fill="#D97706"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" opacity=".5"/><path d="M8.5 14a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM15.5 14a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM12 10a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM12 18a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" fill="#D97706"/></svg>
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 pt-16 sm:pt-4">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $artisan->name }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-4 mb-4 text-sm text-gray-600">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="#D97706"><path d="M3.742 18.555C2 16.623 2 13.742 2 8c0-5.742 0-8.614 1.758-10.555C5.515-4.5 8.51-4.5 14.5-4.5h-5c5.99 0 8.985 0 10.742 1.945C22 -4.614 22-1.742 22 4c0 5.742 0 8.614-1.758 10.555C18.485 16.5 15.49 16.5 9.5 16.5h5c-5.99 0-8.985 0-10.758-1.945Z" opacity=".5"/><path d="M9.945 2.293a1 1 0 0 0-1.414 0L7.099 3.725a3.498 3.498 0 0 0 0 4.95l1.432 1.432a1 1 0 0 0 1.414-1.414l-1.432-1.432a1.498 1.498 0 0 1 0-2.122l1.432-1.432a1 1 0 0 0 0-1.414ZM14.055 2.293a1 1 0 0 1 1.414 0l1.432 1.432a3.498 3.498 0 0 1 0 4.95l-1.432 1.432a1 1 0 0 1-1.414-1.414l1.432-1.432a1.498 1.498 0 0 0 0-2.122l-1.432-1.432a1 1 0 0 1 0-1.414Z" fill="#D97706"/></svg>
                                <span>{{ $products->total() }} créations</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="#D97706"><path d="M6.94 2c.416 0 .753.324.753.724v1.46c0 .4-.337.724-.753.724-.416 0-.753-.324-.753-.724V2.724c0-.4.337-.724.753-.724ZM17.06 2c.416 0 .753.324.753.724v1.46c0 .4-.337.724-.753.724-.416 0-.753-.324-.753-.724V2.724c0-.4.337-.724.753-.724Z" fill="#D97706"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22ZM7 18a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm0-4a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm0-4a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm0-4a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" opacity=".5"/></svg>
                                <span>Membre depuis {{ $artisan->created_at->format('F Y') }}</span>
                            </div>
                            @if($artisan->city)
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="#D97706"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2c-4.418 0-8 3.646-8 8.143 0 4.462 2.553 9.67 6.537 11.531a3.45 3.45 0 0 0 2.926 0C17.447 19.812 20 14.605 20 10.143 20 5.646 16.418 2 12 2Zm0 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" opacity=".5"/><path d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" fill="#D97706"/></svg>
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
                               class="flex items-center gap-2 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M16.1 13.359a1.5 1.5 0 0 1 2.124 0l2.122 2.122c1.172 1.171 1.172 3.071 0 4.242l-1.03 1.03c-2.121 2.122-5.303 2.427-7.778.305-2.121-1.415-4.242-3.182-6.01-5.303-1.768-2.122-3.182-4.596-4.596-6.717C.525 6.514.22 3.686 2.341 1.565l1.03-1.03c1.172-1.172 3.071-1.172 4.243 0l2.121 2.121a1.5 1.5 0 0 1 0 2.122L8.14 6.37c-.21.212-.21.424 0 .636.424.424 1.061 1.06 1.768 1.768.707.707 1.344 1.344 1.768 1.768.212.212.424.212.636 0l1.596-1.596a1.5 1.5 0 0 1 2.121 0l.352.352" opacity=".5"/><path d="m9.908 8.774-.353-.353a1.5 1.5 0 0 1 0-2.121L11.151 4.7c.636-.636.636-1.414 0-2.05L9.03.528C8.393-.11 7.615-.11 6.98.527l-1.03 1.03c-1.06 1.061-1.273 2.475-.988 3.889L6.98 3.428a1.5 1.5 0 0 1 2.121 0l1.768 1.768c.212.212.212.424 0 .636l-.961.962Z" fill="currentColor"/></svg>
                                Contacter
                            </a>
                            @endif
                            @if($artisan->email)
                            <a href="mailto:{{ $artisan->email }}" 
                               class="flex items-center gap-2 px-4 py-2 border border-amber-600 text-amber-600 rounded-lg hover:bg-amber-50 transition-colors">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path opacity=".5" d="M2 12c0-3.771 0-5.657 1.172-6.828C4.343 4 6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172C22 6.343 22 8.229 22 12c0 3.771 0 5.657-1.172 6.828C19.657 20 17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172C2 17.657 2 15.771 2 12Z"/><path d="m6 8 2.159 1.8c1.837 1.53 2.755 2.295 3.841 2.295 1.086 0 2.005-.765 3.841-2.296L18 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                Email
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
                        @if($product->images->first())
                            <img src="{{ $product->images->first()->image_url }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-64 object-cover">
                        @else
                            <div class="w-full h-64 bg-gray-200"></div>
                        @endif
                    </a>
                    @if($product->is_featured)
                    <div class="absolute top-3 left-3">
                        <span class="bg-amber-500 text-white px-2 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M9.153 5.408C10.42 3.136 11.053 2 12 2c.947 0 1.58 1.136 2.847 3.408l.328.588c.36.646.54.969.82 1.182.28.213.63.292 1.33.45l.636.144c2.46.557 3.689.835 3.982 1.776.292.94-.546 1.921-2.223 3.882l-.434.507c-.476.557-.715.836-.822 1.18-.107.345-.071.717.001 1.46l.066.677c.253 2.617.38 3.925-.386 4.506-.766.582-1.918.051-4.22-1.009l-.597-.274c-.654-.302-.981-.452-1.328-.452-.347 0-.674.15-1.328.452l-.596.274c-2.303 1.06-3.455 1.59-4.22 1.01-.767-.582-.64-1.89-.387-4.507l.066-.676c.072-.744.108-1.116.001-1.46-.107-.345-.346-.624-.822-1.18l-.434-.508c-1.677-1.96-2.515-2.941-2.223-3.882.293-.941 1.523-1.22 3.983-1.776l.636-.144c.699-.158 1.048-.237 1.329-.45.28-.213.46-.536.82-1.182l.328-.588Z"/></svg>
                            Vedette
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
            <div class="mb-6 flex justify-center">
                <svg class="w-24 h-24" viewBox="0 0 24 24" fill="#D97706"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" opacity=".5"/><path d="M8.5 14a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM15.5 14a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM12 10a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM12 18a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" fill="#D97706"/></svg>
            </div>
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