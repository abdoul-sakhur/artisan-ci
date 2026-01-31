<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Boutique Artisanale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Catalogue des Produits</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Exemple de produit -->
                        <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                            <div class="bg-gray-200 h-48 flex items-center justify-center">
                                <span class="text-gray-400 text-4xl">🎨</span>
                            </div>
                            <div class="p-4">
                                <h4 class="font-semibold text-lg">Produit Artisanal</h4>
                                <p class="text-gray-600 text-sm mt-2">Créé par un artisan</p>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="text-indigo-600 font-bold">29.99 €</span>
                                    <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                        Voir
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Plus de produits à venir -->
                        <div class="border border-dashed rounded-lg p-6 flex items-center justify-center">
                            <p class="text-gray-400 text-center">Plus de produits bientôt disponibles</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
