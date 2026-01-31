@extends('layouts.app')

@section('title', 'Artisans du Maroc - Marketplace des Créateurs')

@section('content')
<div class="min-h-screen" x-data="{ 
    cartCount: 0,
    cartItems: [],
    cartTotal: '0,00 €'
}">
    {{-- Hero Section modernisée --}}
    @include('components.ui.hero')

    {{-- Catégories Populaires --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Explorez par Catégorie</h2>
                <p class="text-gray-600">Découvrez l'artisanat marocain dans toute sa diversité</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    @include('components.ui.category-card', ['category' => $category])
                @endforeach
            </div>
        </div>
    </section>

    {{-- Produits en Vedette modernisés --}}
    @if($featuredProducts->count() > 0)
        @include('components.ui.featured-section', ['title' => '⭐ Œuvres en Vedette', 'products' => $featuredProducts])
    @endif

    {{-- Nouveautés --}}
    @if($newProducts->count() > 0)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">🆕 Dernières Créations</h2>
                    <p class="text-gray-600">Les toutes nouvelles œuvres de nos artisans</p>
                </div>
                <a href="{{ route('front.shop.index', ['sort' => 'latest']) }}" 
                   class="text-amber-600 hover:text-amber-700 font-semibold">
                    Voir toutes les nouveautés →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($newProducts->take(4) as $product)
                    @include('components.ui.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Artisans Recommandés --}}
    @if($artisans->count() > 0)
    <section class="py-16 bg-amber-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">👥 Rencontrez nos Artisans</h2>
                <p class="text-gray-600">Des créateurs passionnés qui perpétuent les traditions</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($artisans->take(6) as $artisan)
                    @include('components.ui.artisan-card', ['artisan' => $artisan])
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('front.artisans.index') }}" 
                   class="bg-white text-amber-600 border border-amber-600 px-8 py-3 rounded-lg hover:bg-amber-600 hover:text-white transition-colors font-semibold">
                    Voir tous les artisans
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- Témoignages --}}
    <section class="py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">💬 Ce que disent nos Clients</h2>
                <p class="text-gray-300">L'authenticité et la qualité reconnues par nos clients</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-800 rounded-xl p-6 text-center">
                    <div class="text-amber-400 text-2xl mb-4">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-300 mb-4">
                        "Une qualité exceptionnelle ! J'ai découvert des pièces uniques qui illuminent ma maison. 
                        Le service client est parfait."
                    </p>
                    <div class="font-semibold text-white">Sarah M.</div>
                    <div class="text-sm text-gray-400">Cliente satisfaite</div>
                </div>

                <div class="bg-gray-800 rounded-xl p-6 text-center">
                    <div class="text-amber-400 text-2xl mb-4">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-300 mb-4">
                        "Chaque achat est une découverte. L'authenticité des œuvres et le savoir-faire des artisans 
                        sont remarquables."
                    </p>
                    <div class="font-semibold text-white">Ahmed B.</div>
                    <div class="text-sm text-gray-400">Collectionneur</div>
                </div>

                <div class="bg-gray-800 rounded-xl p-6 text-center">
                    <div class="text-amber-400 text-2xl mb-4">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-300 mb-4">
                        "Livraison rapide et soignée. Les produits correspondent parfaitement aux descriptions. 
                        Je recommande vivement !"
                    </p>
                    <div class="font-semibold text-white">Marie L.</div>
                    <div class="text-sm text-gray-400">Décoratrice</div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Final --}}
    <section class="py-16 bg-amber-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">
                Prêt à Découvrir l'Art Authentique ?
            </h2>
            <p class="text-xl text-amber-100 mb-8">
                Rejoignez des milliers de clients qui ont déjà trouvé leurs pièces uniques
            </p>
            <a href="{{ route('front.shop.index') }}" 
               class="bg-white text-amber-600 px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors font-semibold text-lg">
                🛍️ Commencer mes Achats
            </a>
        </div>
    </section>
</div>
@endsection