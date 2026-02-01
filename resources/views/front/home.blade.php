@extends('layouts.front')

@section('title', 'Artisans du  - Marketplace des Créateurs')

@section('content')
<div class="min-h-screen" x-data="{ 
    cartCount: 0,
    cartItems: [],
    cartTotal: '0,00 FCFA'
}">
    {{-- Hero Section modernisée --}}
    @include('components.ui.hero')

    {{-- Catégories Populaires --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Explorez par Catégorie</h2>
                <p class="text-gray-600">Découvrez l'artisanat  dans toute sa diversité</p>
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
        @include('components.ui.featured-section', ['title' => 'Œuvres en Vedette', 'products' => $featuredProducts])
    @endif

    {{-- Nouveautés --}}
    @if($newProducts->count() > 0)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Dernières Créations</h2>
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
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex justify-center items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="#D97706" d="M12 10a4 4 0 1 0 0-8a4 4 0 0 0 0 8"/><path fill="#D97706" d="M2.728 5.818a.75.75 0 1 0-1.455.364l.382 1.528a8.21 8.21 0 0 0 5.595 5.869v4.473c0 .898 0 1.648.08 2.242c.084.628.27 1.195.726 1.65c.455.456 1.022.642 1.65.726c.595.08 1.344.08 2.242.08h.104c.899 0 1.648 0 2.243-.08c.627-.084 1.194-.27 1.65-.726s.64-1.022.725-1.65c.08-.594.08-1.344.08-2.242v-4.193a2.62 2.62 0 0 1 1.856 2.208l.65 5.52a.75.75 0 0 0 1.489-.175l-.65-5.52A4.124 4.124 0 0 0 16 12.25H8.085A6.71 6.71 0 0 1 3.11 7.346z"/></svg> Rencontrez nos Artisans</h2>
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
                <h2 class="text-3xl font-bold text-white mb-4"> Ce que disent nos Clients</h2>
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
               class="bg-white text-amber-600 px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors font-semibold text-lg flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#D97706" d="M6.005 9h13.938l.5-2H8.005V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5.004a1 1 0 0 1-1-1V4h-2V2h3a1 1 0 0 1 1 1zm0 14a2 2 0 1 1 0-4a2 2 0 0 1 0 4m12 0a2 2 0 1 1 0-4a2 2 0 0 1 0 4"/></svg>
 Commencer mes Achats
            </a>
        </div>
    </section>
</div>
@endsection