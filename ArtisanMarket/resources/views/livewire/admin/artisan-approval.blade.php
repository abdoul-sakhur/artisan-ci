<div>
    <!-- Header Section -->
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-900">Validation des Artisans</h3>
        <p class="mt-1 text-sm text-gray-600">Gérez les demandes d'inscription des artisans</p>
    </div>

    <!-- Filters -->
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                    Rechercher
                </label>
                <input 
                    type="text" 
                    id="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Nom, email, boutique..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <!-- Filter Status -->
            <div>
                <label for="filterStatus" class="block text-sm font-medium text-gray-700 mb-2">
                    Statut
                </label>
                <select 
                    id="filterStatus"
                    wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="pending">En attente</option>
                    <option value="approved">Approuvés</option>
                    <option value="all">Tous</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Artisans List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($artisans->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Artisan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Boutique
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date d'inscription
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($artisans as $artisan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($artisan->shop_logo)
                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                     src="{{ asset('storage/' . $artisan->shop_logo) }}" 
                                                     alt="{{ $artisan->shop_name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <span class="text-indigo-600 font-semibold text-lg">
                                                        {{ substr($artisan->shop_name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $artisan->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $artisan->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $artisan->shop_name }}</div>
                                    <div class="text-sm text-gray-500 truncate max-w-xs">
                                        {{ Str::limit($artisan->shop_description, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $artisan->created_at->format('d/m/Y') }}
                                    <br>
                                    <span class="text-xs text-gray-400">
                                        {{ $artisan->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($artisan->is_approved)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Approuvé
                                        </span>
                                        @if($artisan->approved_at)
                                            <div class="text-xs text-gray-400 mt-1">
                                                {{ $artisan->approved_at->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if(!$artisan->is_approved)
                                        <button 
                                            wire:click="approve({{ $artisan->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir approuver cet artisan ?"
                                            class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 mr-2">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Approuver
                                        </button>
                                        <button 
                                            wire:click="reject({{ $artisan->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir rejeter cet artisan ? Cette action est irréversible."
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Rejeter
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-sm italic">Déjà approuvé</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $artisans->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun artisan</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($search)
                        Aucun résultat pour "{{ $search }}"
                    @else
                        Aucun artisan {{ $filterStatus === 'pending' ? 'en attente' : '' }} pour le moment.
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="fixed top-4 right-4 z-50">
        <div class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg flex items-center">
            <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Chargement...
        </div>
    </div>
</div>
