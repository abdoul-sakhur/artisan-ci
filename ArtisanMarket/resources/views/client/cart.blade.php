<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Panier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Panier d'achat</h3>

                    <div class="text-center py-12">
                        <div class="text-gray-400 text-6xl mb-4">🛒</div>
                        <p class="text-gray-600">Votre panier est vide</p>
                        <p class="text-sm text-gray-500 mt-2">Ajoutez des produits pour commencer vos achats</p>
                        <a href="{{ route('shop.index') }}" class="inline-block mt-4 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                            Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
