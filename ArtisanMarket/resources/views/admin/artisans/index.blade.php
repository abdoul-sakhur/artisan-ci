<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Artisans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Liste des Artisans</h3>
                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            + Ajouter un artisan
                        </button>
                    </div>

                    @php
                        $artisans = \App\Models\User::role('artisan')->get();
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($artisans as $artisan)
                            <div class="border rounded-lg p-6 hover:shadow-lg transition">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <span class="text-2xl font-bold text-indigo-600">
                                            {{ strtoupper(substr($artisan->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-lg">{{ $artisan->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $artisan->email }}</p>
                                    </div>
                                </div>

                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Produits:</span>
                                        <span class="font-semibold">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Commandes:</span>
                                        <span class="font-semibold">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Membre depuis:</span>
                                        <span class="font-semibold">{{ $artisan->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-t flex gap-2">
                                    <button class="flex-1 bg-indigo-600 text-white px-3 py-2 rounded text-sm hover:bg-indigo-700">
                                        Voir profil
                                    </button>
                                    <button class="flex-1 border border-gray-300 px-3 py-2 rounded text-sm hover:bg-gray-50">
                                        Modifier
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <div class="text-gray-400 text-6xl mb-4">🎨</div>
                                <p class="text-gray-600">Aucun artisan inscrit pour le moment</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6 p-4 bg-indigo-50 border-l-4 border-indigo-400">
                        <p class="text-sm text-indigo-700">
                            <strong>Total :</strong> {{ $artisans->count() }} artisan(s) inscrit(s)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
