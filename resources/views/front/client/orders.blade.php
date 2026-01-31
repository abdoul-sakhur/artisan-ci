@extends('layouts.app')

@section('title', 'Mes Commandes - Artisans du Maroc')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb --}}
        <nav class="text-sm mb-6">
            <a href="{{ route('front.home') }}" class="text-gray-500 hover:text-amber-600">Accueil</a>
            <span class="mx-2 text-gray-400">•</span>
            <a href="{{ route('front.client.account') }}" class="text-gray-500 hover:text-amber-600">Mon Compte</a>
            <span class="mx-2 text-gray-400">•</span>
            <span class="text-gray-900 font-medium">Mes Commandes</span>
        </nav>
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">📦 Mes Commandes</h1>
                <p class="text-gray-600">Suivez l'état de vos commandes et retrouvez vos factures</p>
            </div>
            <a href="{{ route('front.shop.index') }}" 
               class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors font-semibold">
                🛍️ Nouvelle commande
            </a>
        </div>
        
        @if($orders->count() > 0)
        <div class="space-y-6 mb-8">
            @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                Commande {{ $order->order_number }}
                            </h3>
                            <p class="text-sm text-gray-600">
                                Passée le {{ $order->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        <div class="mt-2 sm:mt-0 text-right">
                            <div class="mb-2">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                       ($order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : 
                                       ($order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))) }}">
                                    @switch($order->status)
                                        @case('pending')
                                            🕰️ En attente
                                            @break
                                        @case('processing')
                                            ⚙️ En préparation
                                            @break
                                        @case('shipped')
                                            🚚 Expédiée
                                            @break
                                        @case('delivered')
                                            ✅ Livrée
                                            @break
                                        @case('cancelled')
                                            ❌ Annulée
                                            @break
                                        @default
                                            {{ ucfirst($order->status) }}
                                    @endswitch
                                </span>
                            </div>
                            <div class="text-lg font-bold text-amber-600">
                                {{ number_format($order->total_amount / 100, 2, ',', ' ') }} €
                            </div>
                        </div>
                    </div>
                    
                    {{-- Résumé des articles --}}
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3">
                            Articles ({{ $order->items->sum('quantity') }})
                        </h4>
                        <div class="space-y-2">
                            @foreach($order->items->take(3) as $item)
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-100 rounded overflow-hidden">
                                    @if($item->product && $item->product->images->first())
                                    <img src="{{ $item->product->images->first()->image_url }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        🎨
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h5 class="text-sm font-medium text-gray-900">
                                        {{ $item->product->name ?? 'Produit supprimé' }}
                                    </h5>
                                    <p class="text-xs text-gray-500">
                                        Quantité: {{ $item->quantity }} × {{ number_format($item->price / 100, 2, ',', ' ') }} €
                                    </p>
                                </div>
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ number_format($item->total / 100, 2, ',', ' ') }} €
                                </div>
                            </div>
                            @endforeach
                            
                            @if($order->items->count() > 3)
                            <div class="text-sm text-gray-500 text-center py-2">
                                ... et {{ $order->items->count() - 3 }} autre(s) article(s)
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row gap-3 justify-between items-center pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            @if($order->status === 'processing')
                            📊 Votre commande est en cours de préparation
                            @elseif($order->status === 'shipped')
                            🚚 Votre commande est en route
                            @elseif($order->status === 'delivered')
                            ✅ Commande livrée avec succès
                            @else
                            🕰️ Commande en attente de traitement
                            @endif
                        </div>
                        
                        <div class="flex gap-3">
                            <a href="{{ route('front.orders.show', $order->order_number) }}" 
                               class="px-4 py-2 border border-amber-600 text-amber-600 rounded-lg hover:bg-amber-50 transition-colors font-medium">
                                Voir détails
                            </a>
                            @if($order->status === 'delivered')
                            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                ⬇ Facture PDF
                            </button>
                            @endif
                            @if(in_array($order->status, ['pending', 'processing']))
                            <button class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors font-medium"
                                    onclick="if(confirm('Souhaitez-vous vraiment annuler cette commande ?')) { /* Action d'annulation */ }">
                                Annuler
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            {{ $orders->links() }}
        </div>
        
        @else
        {{-- État vide --}}
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="text-6xl mb-6">📦</div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune commande</h3>
            <p class="text-gray-600 mb-8">
                Vous n'avez pas encore passé de commande. Découvrez nos magnifiques créations artisanales !
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('front.shop.index') }}" 
                   class="bg-amber-600 text-white px-8 py-3 rounded-lg hover:bg-amber-700 transition-colors font-semibold">
                    🛍️ Découvrir la boutique
                </a>
                <a href="{{ route('front.artisans.index') }}" 
                   class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:border-amber-600 hover:text-amber-600 transition-colors font-medium">
                    👥 Nos artisans
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection