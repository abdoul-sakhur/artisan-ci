<div>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Mes Commandes</h1>
        <p class="text-gray-600 mt-1">Gérez les commandes de vos produits</p>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Recherche -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Numéro de commande ou nom du client..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Filtre statut -->
            <div>
                <label for="filterStatus" class="block text-sm font-medium text-gray-700 mb-2">Filtrer par statut</label>
                <select 
                    id="filterStatus"
                    wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                >
                    <option value="all">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="processing">En traitement</option>
                    <option value="shipped">Expédiée</option>
                    <option value="delivered">Livrée</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des commandes -->
    @if($orders->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Commande</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">#{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->items->count() }} article(s)</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $order->created_at->format('d/m/Y') }}<br>
                                    <span class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} DH</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <button 
                                        wire:click="showOrderDetails({{ $order->id }})"
                                        class="text-purple-600 hover:text-purple-800 font-medium text-sm"
                                    >
                                        Détails →
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        </div>
    @else
        <!-- État vide -->
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Aucune commande trouvée</h3>
            <p class="text-gray-600">
                @if($search || $filterStatus !== 'all')
                    Aucune commande ne correspond à vos critères.
                @else
                    Vous n'avez pas encore reçu de commandes.
                @endif
            </p>
        </div>
    @endif

    <!-- Modal de détails -->
    @if($showDetailsModal && $selectedOrder)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: @entangle('showDetailsModal') }">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div 
                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                    @click="open = false"
                    x-show="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                ></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <!-- Modal -->
                <div 
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full"
                    x-show="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Commande #{{ $selectedOrder->order_number }}</h3>
                        <button 
                            wire:click="closeModal"
                            class="text-white hover:text-gray-200 transition"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="px-6 py-6">
                        <!-- Info client -->
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-900 mb-2">Informations client</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm"><span class="font-semibold">Nom:</span> {{ $selectedOrder->user->name }}</p>
                                <p class="text-sm mt-1"><span class="font-semibold">Email:</span> {{ $selectedOrder->user->email }}</p>
                                <p class="text-sm mt-1"><span class="font-semibold">Date:</span> {{ $selectedOrder->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>

                        <!-- Produits -->
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-900 mb-2">Produits commandés</h4>
                            <div class="space-y-3">
                                @foreach($selectedOrder->items as $item)
                                    <div class="flex items-center space-x-4 bg-gray-50 rounded-lg p-4">
                                        @if($item->product->primaryImage)
                                            <img src="{{ Storage::url($item->product->primaryImage->image_url) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-600">{{ number_format($item->price, 2) }} DH × {{ $item->quantity }}</p>
                                        </div>
                                        <p class="font-bold text-gray-900">{{ number_format($item->price * $item->quantity, 2) }} DH</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-bold text-gray-900">Total</p>
                                <p class="text-2xl font-bold text-purple-600">{{ number_format($selectedOrder->total_amount, 2) }} DH</p>
                            </div>
                        </div>

                        <!-- Changer le statut -->
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Changer le statut</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                <button 
                                    wire:click="updateOrderStatus({{ $selectedOrder->id }}, 'pending')"
                                    class="px-4 py-2 text-sm font-medium rounded-lg transition
                                        {{ $selectedOrder->status === 'pending' ? 'bg-yellow-500 text-white' : 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' }}"
                                >
                                    En attente
                                </button>
                                <button 
                                    wire:click="updateOrderStatus({{ $selectedOrder->id }}, 'processing')"
                                    class="px-4 py-2 text-sm font-medium rounded-lg transition
                                        {{ $selectedOrder->status === 'processing' ? 'bg-blue-500 text-white' : 'bg-blue-100 text-blue-800 hover:bg-blue-200' }}"
                                >
                                    En traitement
                                </button>
                                <button 
                                    wire:click="updateOrderStatus({{ $selectedOrder->id }}, 'shipped')"
                                    class="px-4 py-2 text-sm font-medium rounded-lg transition
                                        {{ $selectedOrder->status === 'shipped' ? 'bg-purple-500 text-white' : 'bg-purple-100 text-purple-800 hover:bg-purple-200' }}"
                                >
                                    Expédiée
                                </button>
                                <button 
                                    wire:click="updateOrderStatus({{ $selectedOrder->id }}, 'delivered')"
                                    class="px-4 py-2 text-sm font-medium rounded-lg transition
                                        {{ $selectedOrder->status === 'delivered' ? 'bg-green-500 text-white' : 'bg-green-100 text-green-800 hover:bg-green-200' }}"
                                >
                                    Livrée
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4">
                        <button 
                            wire:click="closeModal"
                            class="w-full px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition"
                        >
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
