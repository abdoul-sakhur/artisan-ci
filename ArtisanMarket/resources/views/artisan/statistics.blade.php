<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistiques de Vente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 mb-2">Ventes totales</div>
                        <div class="text-3xl font-bold">0 €</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 mb-2">Commandes</div>
                        <div class="text-3xl font-bold">0</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 mb-2">Produits vendus</div>
                        <div class="text-3xl font-bold">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
