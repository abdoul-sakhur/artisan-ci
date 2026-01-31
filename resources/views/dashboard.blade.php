<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">🛒 Bienvenue {{ Auth::user()->name }} !</h3>
                    <p class="mb-4">Vous êtes connecté en tant que <strong>Client</strong>.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="border rounded-lg p-4 bg-blue-50">
                            <h4 class="font-bold text-lg">Mes Commandes</h4>
                            <p class="text-3xl font-bold text-blue-600">0</p>
                            <p class="text-sm text-gray-600">Commandes passées</p>
                        </div>
                        
                        <div class="border rounded-lg p-4 bg-green-50">
                            <h4 class="font-bold text-lg">En cours</h4>
                            <p class="text-3xl font-bold text-green-600">0</p>
                            <p class="text-sm text-gray-600">Commandes en livraison</p>
                        </div>
                        
                        <div class="border rounded-lg p-4 bg-purple-50">
                            <h4 class="font-bold text-lg">Favoris</h4>
                            <p class="text-3xl font-bold text-purple-600">0</p>
                            <p class="text-sm text-gray-600">Œuvres favorites</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            <strong>📝 Note:</strong> L'espace client complet sera implémenté à l'ÉTAPE 7.
                        </p>
                        <p class="text-sm text-yellow-800 mt-2">
                            Vous pourrez parcourir le catalogue, passer des commandes et suivre vos achats.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

