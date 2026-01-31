<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mes Commandes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <x-ui.alert variant="success" dismissible>
                    {{ session('success') }}
                </x-ui.alert>
            @endif

            <x-ui.card>
                {{-- Filtres --}}
                <div class="px-4 py-4 border-b">
                    <x-ui.tabs defaultTab="{{ $status }}">
                        <x-ui.tabs-list>
                            <x-ui.tabs-trigger value="all">
                                <a href="{{ route('artisan.orders.index') }}" class="block">Toutes</a>
                            </x-ui.tabs-trigger>
                            <x-ui.tabs-trigger value="pending">
                                <a href="{{ route('artisan.orders.index', ['status' => 'pending']) }}" class="block">En attente</a>
                            </x-ui.tabs-trigger>
                            <x-ui.tabs-trigger value="processing">
                                <a href="{{ route('artisan.orders.index', ['status' => 'processing']) }}" class="block">En cours</a>
                            </x-ui.tabs-trigger>
                            <x-ui.tabs-trigger value="shipped">
                                <a href="{{ route('artisan.orders.index', ['status' => 'shipped']) }}" class="block">Expédiées</a>
                            </x-ui.tabs-trigger>
                            <x-ui.tabs-trigger value="delivered">
                                <a href="{{ route('artisan.orders.index', ['status' => 'delivered']) }}" class="block">Livrées</a>
                            </x-ui.tabs-trigger>
                        </x-ui.tabs-list>
                    </x-ui.tabs>
                </div>

                @if($orders->count() > 0)
                    <x-ui.table>
                        <thead class="border-b">
                            <tr>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Numéro</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Client</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Montant</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Statut</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-4 align-middle font-medium">#{{ $order->order_number }}</td>
                                    <td class="p-4 align-middle">{{ $order->user->name }}</td>
                                    <td class="p-4 align-middle">{{ number_format($order->total_amount, 0) }} FCFA</td>
                                    <td class="p-4 align-middle">
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'confirmed' => 'default',
                                                'processing' => 'default',
                                                'shipped' => 'default',
                                                'delivered' => 'success',
                                                'cancelled' => 'destructive',
                                            ];
                                        @endphp
                                        <x-ui.badge :variant="$statusColors[$order->status] ?? 'secondary'">
                                            {{ ucfirst($order->status) }}
                                        </x-ui.badge>
                                    </td>
                                    <td class="p-4 align-middle text-sm text-muted-foreground">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="p-4 align-middle">
                                        <x-ui.button 
                                            size="sm" 
                                            variant="outline"
                                            href="{{ route('artisan.orders.show', $order) }}"
                                        >
                                            Voir
                                        </x-ui.button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>

                    <div class="mt-4 px-4">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucune commande</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if($status === 'pending')
                                Aucune commande en attente.
                            @else
                                Vous n'avez pas encore reçu de commandes.
                            @endif
                        </p>
                    </div>
                @endif
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
