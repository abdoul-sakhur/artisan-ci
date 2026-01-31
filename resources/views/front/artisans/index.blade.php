@extends('layouts.app')

@section('title', 'Nos Artisans - Artisans du Maroc')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- En-tête --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">👥 Nos Artisans</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Découvrez les créateurs talentueux qui donnent vie à l'artisanat marocain authentique.
                Chaque artisan apporte son savoir-faire unique et sa passion.
            </p>
        </div>

        {{-- Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-amber-600 mb-2">{{ $artisans->total() }}</div>
                <div class="text-gray-600">Artisans approuvés</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-amber-600 mb-2">{{ $artisans->sum('products_count') }}</div>
                <div class="text-gray-600">Créations disponibles</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-amber-600 mb-2">100%</div>
                <div class="text-gray-600">Authenticité garantie</div>
            </div>
        </div>

        {{-- Grille des artisans --}}
        @if($artisans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            @foreach($artisans as $artisan)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow overflow-hidden">
                <div class="relative">
                    <div class="h-48 bg-gradient-to-br from-amber-50 to-orange-50 flex items-center justify-center">
                        @if($artisan->logo_url)
                        <img src="{{ $artisan->logo_url }}" 
                             alt="{{ $artisan->name }}"
                             class="w-24 h-24 object-cover rounded-full border-4 border-white shadow-lg">
                        @else
                        <div class="w-24 h-24 bg-amber-100 rounded-full flex items-center justify-center text-3xl">
                            🎨
                        </div>
                        @endif
                    </div>
                    @if($artisan->is_featured)
                    <div class="absolute top-4 right-4">
                        <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            ⭐ Certifié
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $artisan->name }}</h3>
                    
                    @if($artisan->bio)
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($artisan->bio, 120) }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between mb-4 text-sm text-gray-500">
                        <div class="flex items-center">
                            <span class="mr-1">📦</span>
                            <span>{{ $artisan->products_count }} créations</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-1">📅</span>
                            <span>Membre depuis {{ $artisan->created_at->format('Y') }}</span>
                        </div>
                    </div>
                    
                    @if($artisan->specialties)
                    <div class="flex flex-wrap gap-1 mb-4">
                        @foreach(explode(',', $artisan->specialties) as $specialty)
                        <span class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded-full">
                            {{ trim($specialty) }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                    
                                        <div class="flex gap-3">
                                                <x-ui.button as="a" variant="primary" size="md" href="{{ route('front.artisans.show', $artisan->shop_slug) }}" class="flex-1 text-center">
                                                    Découvrir l'atelier
                                                </x-ui.button>
                                                @if($artisan->phone || $artisan->email)
                                                <button class="px-4 py-2 border border-stone-300 rounded-lg hover:border-amber-600 hover:text-amber-600 transition-colors"
                                                                title="Contacter">
                            📞
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            {{ $artisans->links() }}
        </div>
        
        @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="text-6xl mb-6">👥</div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun artisan disponible</h3>
            <p class="text-gray-600">
                Revenez bientôt pour découvrir nos créateurs talentueux
            </p>
        </div>
        @endif
        
        {{-- CTA d'inscription --}}
        <div class="mt-16 bg-gradient-to-r from-amber-600 to-orange-600 rounded-2xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-4">🎨 Vous êtes Artisan ?</h2>
            <p class="text-amber-100 mb-6 max-w-2xl mx-auto">
                Rejoignez notre marketplace et partagez vos créations avec des milliers de clients 
                passionnés d'artisanat authentique.
            </p>
            <a href="{{ route('register') }}" 
               class="bg-white text-amber-600 px-8 py-3 rounded-lg hover:bg-amber-50 transition-colors font-semibold inline-block">
                Rejoindre la communauté
            </a>
        </div>
    </div>
</div>
@endsection