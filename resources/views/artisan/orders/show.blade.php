<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Commande #{{ $order->order_number }}
            </h2>
            <x-ui.button variant="outline" href="{{ route('artisan.orders.index') }}">
                Retour
            </x-ui.button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <x-ui.alert variant="success" dismissible">
                    {{ session('success') }}
                </x-ui.alert>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Détails commande --}}
                <div class="lg:col-span-2 space-y-6">
                    <x-ui.card>
                        <div class="px-4 py-5 sm:px-6 border-b">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Détails de la commande
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Passée le {{ $order->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
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
                            </div>
                        </div>

                        <div class="p-6">
                            <x-ui.table>
                                <thead class="border-b">
                                    <tr>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Produit</th>
                                        <th class="h-12 px-4 text-center align-middle font-medium text-muted-foreground">Quantité</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Prix Unit.</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Sous-total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr class="border-b">
                                            <td class="p-4 align-middle">
                                                <div class="font-medium">{{ $item->product->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $item->product->category->name }}</div>
                                            </td>
                                            <td class="p-4 align-middle text-center">{{ $item->quantity }}</td>
                                            <td class="p-4 align-middle text-right">{{ number_format($item->unit_price, 0) }} FCFA</td>
                                            <td class="p-4 align-middle text-right font-medium">{{ number_format($item->subtotal, 0) }} FCFA</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-t-2">
                                    <tr>
                                        <td colspan="3" class="p-4 text-right font-semibold">Total</td>
                                        <td class="p-4 text-right font-bold text-lg">{{ number_format($order->total_amount, 0) }} FCFA</td>
                                    </tr>
                                </tfoot>
                            </x-ui.table>
                        </div>
                    </x-ui.card>

                    {{-- Adresse de livraison --}}
                    <x-ui.card>
                        <div class="px-4 py-5 sm:px-6 border-b">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Adresse de livraison
                            </h3>
                        </div>
                        <div class="p-6">
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nom complet</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->shipping_address['name'] ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Adresse</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->shipping_address['address'] ?? 'N/A' }}</dd>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Ville</dt>
                                        <dd class="text-sm text-gray-900">{{ $order->shipping_address['city'] ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Code postal</dt>
                                        <dd class="text-sm text-gray-900">{{ $order->shipping_address['postal_code'] ?? 'N/A' }}</dd>
                                    </div>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->shipping_address['phone'] ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </x-ui.card>
                </div>

                {{-- Actions --}}
                <div class="space-y-6">
                    <x-ui.card>
                        <div class="px-4 py-5 sm:px-6 border-b">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Informations client
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nom</p>
                                <p class="text-sm text-gray-900">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="text-sm text-gray-900">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </x-ui.card>

                    <x-ui.card>
                        <div class="px-4 py-5 sm:px-6 border-b">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Mettre à jour le statut
                            </h3>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('artisan.orders.update-status', $order) }}">
                                @csrf
                                <div class="space-y-4">
                                    <x-ui.select id="status" name="status" required>
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>En préparation</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Expédiée</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Livrée</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                    </x-ui.select>
                                    <x-ui.button type="submit" class="w-full justify-center">
                                        Mettre à jour
                                    </x-ui.button>
                                </div>
                            </form>
                        </div>
                    </x-ui.card>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
