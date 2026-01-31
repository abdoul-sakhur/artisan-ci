<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Bienvenue {{ auth()->user()->name }} !</h3>
                    <p class="mb-4">Vous êtes connecté en tant que <strong>client</strong>.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <!-- Card Commandes -->
                        <div class="bg-pink-100 p-6 rounded-lg">
                            <h4 class="font-bold text-lg mb-2">Mes Commandes</h4>
                            <p class="text-3xl font-bold text-pink-600">0</p>
                            <a href="{{ route('client.orders.index') }}" class="text-pink-500 hover:underline mt-2 inline-block">
                                Voir mes commandes →
                            </a>
                        </div>
                        
                        <!-- Card Panier -->
                        <div class="bg-cyan-100 p-6 rounded-lg">
                            <h4 class="font-bold text-lg mb-2">Mon Panier</h4>
                            <p class="text-3xl font-bold text-cyan-600">0</p>
                            <a href="{{ route('client.cart') }}" class="text-cyan-500 hover:underline mt-2 inline-block">
                                Voir mon panier →
                            </a>
                        </div>
                        
                        <!-- Card Favoris -->
                        <div class="bg-rose-100 p-6 rounded-lg">
                            <h4 class="font-bold text-lg mb-2">Mes Favoris</h4>
                            <p class="text-3xl font-bold text-rose-600">0</p>
                            <a href="{{ route('client.favorites') }}" class="text-rose-500 hover:underline mt-2 inline-block">
                                Voir mes favoris →
                            </a>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('shop.index') }}" 
                           class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                            🛍️ Découvrir nos produits artisanaux
                        </a>
                    </div>

                    <div class="mt-6 p-4 bg-green-50 border-l-4 border-green-400">
                        <p class="text-sm">
                            <strong>Votre rôle :</strong> 
                            @foreach(auth()->user()->roles as $role)
                                <span class="inline-block bg-green-200 rounded px-2 py-1 text-xs">{{ $role->name }}</span>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
