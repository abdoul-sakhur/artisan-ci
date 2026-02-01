@extends('layouts.front')

@section('title', 'Mes Commandes - Artisans de Côte d\'Ivoire')

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
                <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Mes Commandes
                </h1>
                <p class="text-gray-600">Suivez l'état de vos commandes et retrouvez vos factures</p>
            </div>
            <a href="{{ route('front.shop.index') }}" 
               class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors font-semibold inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Nouvelle commande
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
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            En attente
                                            @break
                                        @case('processing')
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            En préparation
                                            @break
                                        @case('shipped')
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                            Expédiée
                                            @break
                                        @case('delivered')
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Livrée
                                            @break
                                        @case('cancelled')
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Annulée
                                            @break
                                        @default
                                            {{ ucfirst($order->status) }}
                                    @endswitch
                                </span>
                            </div>
                            <div class="text-lg font-bold text-amber-600">
                                {{ number_format($order->total_amount / 100, 2, ',', ' ') }} FCFA
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
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h5 class="text-sm font-medium text-gray-900">
                                        {{ $item->product->name ?? 'Produit supprimé' }}
                                    </h5>
                                    <p class="text-xs text-gray-500">
                                        Quantité: {{ $item->quantity }} × {{ number_format($item->price / 100, 2, ',', ' ') }} FCFA
                                    </p>
                                </div>
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ number_format($item->total / 100, 2, ',', ' ') }} FCFA
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
            <div class="mb-6">
                <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune commande</h3>
            <p class="text-gray-600 mb-8">
                Vous n'avez pas encore passé de commande. Découvrez nos magnifiques créations artisanales !
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('front.shop.index') }}" 
                   class="bg-amber-600 text-white px-8 py-3 rounded-lg hover:bg-amber-700 transition-colors font-semibold inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Découvrir la boutique
                </a>
                <a href="{{ route('front.artisans.index') }}" 
                   class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:border-amber-600 hover:text-amber-600 transition-colors font-medium inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Nos artisans
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection