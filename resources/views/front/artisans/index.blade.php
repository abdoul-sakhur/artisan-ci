@extends('layouts.front')

@section('title', 'Nos Artisans - Artisans  ')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- En-tête --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4 flex items-center justify-center gap-3">
                <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>Nos Artisans</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Découvrez les créateurs talentueux qui donnent vie à l'artisanat  authentique.
                Chaque artisan apporte son savoir-faire unique et sa passion.
            </p>
        </div>

        {{-- Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-amber-600 mb-2">{{ $totalArtisans }}</div>
                <div class="text-gray-600">Artisans approuvés</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-amber-600 mb-2">{{ $totalProducts }}</div>
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
                        <div class="w-24 h-24 bg-amber-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                        </div>
                        @endif
                    </div>
                    @if($artisan->is_featured)
                    <div class="absolute top-4 right-4">
                        <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Certifié
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
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span>{{ $artisan->products_count }} créations</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
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
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
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
            <svg class="w-24 h-24 mx-auto mb-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun artisan disponible</h3>
            <p class="text-gray-600">
                Revenez bientôt pour découvrir nos créateurs talentueux
            </p>
        </div>
        @endif
        
        {{-- CTA d'inscription --}}
        <div class="mt-16 bg-gradient-to-r from-amber-600 to-orange-600 rounded-2xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-4 flex items-center justify-center gap-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                <span>Vous êtes Artisan ?</span>
            </h2>
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