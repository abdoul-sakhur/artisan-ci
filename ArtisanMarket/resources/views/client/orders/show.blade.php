<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détail de la commande') }} #{{ $order }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Commande #{{ $order }}</h3>
                        <a href="{{ route('client.orders.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Retour aux commandes
                        </a>
                    </div>

                    <div class="border rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Statut</div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    En attente
                                </span>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Date de commande</div>
                                <div class="font-medium">{{ now()->format('d/m/Y H:i') }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Total</div>
                                <div class="text-2xl font-bold text-indigo-600">0.00 €</div>
                            </div>
                        </div>

                        <div class="border-t pt-6">
                            <h4 class="font-semibold mb-4">Articles commandés</h4>
                            <div class="text-center py-8 text-gray-500">
                                Aucun article dans cette commande
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
