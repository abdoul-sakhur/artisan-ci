<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ma Boutique') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Configuration de ma boutique</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la boutique</label>
                            <input type="text" value="{{ auth()->user()->name }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Présentez votre boutique..."></textarea>
                        </div>

                        <button class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
