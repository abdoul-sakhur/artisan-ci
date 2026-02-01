<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestion des Artisans') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <x-ui.alert variant="success" dismissible>
                    {{ session('success') }}
                </x-ui.alert>
            @endif

            @if(session('error'))
                <x-ui.alert variant="destructive" dismissible>
                    {{ session('error') }}
                </x-ui.alert>
            @endif

            <x-ui.card>
                {{-- Filtres --}}
                <x-ui.tabs defaultTab="{{ $status }}">
                    <x-ui.tabs-list>
                        <x-ui.tabs-trigger value="all">
                            <a href="{{ route('admin.artisans.index', ['status' => 'all']) }}" class="block">
                                Tous
                            </a>
                        </x-ui.tabs-trigger>
                        <x-ui.tabs-trigger value="pending">
                            <a href="{{ route('admin.artisans.index', ['status' => 'pending']) }}" class="block">
                                En attente
                            </a>
                        </x-ui.tabs-trigger>
                        <x-ui.tabs-trigger value="approved">
                            <a href="{{ route('admin.artisans.index', ['status' => 'approved']) }}" class="block">
                                Approuvés
                            </a>
                        </x-ui.tabs-trigger>
                    </x-ui.tabs-list>
                </x-ui.tabs>

                <div class="mt-6">
                    @if($artisans->count() > 0)
                        <x-ui.table>
                            <thead class="border-b">
                                <tr>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Boutique</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Propriétaire</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Email</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Statut</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($artisans as $artisan)
                                    <tr class="border-b transition-colors hover:bg-muted/50">
                                        <td class="p-4 align-middle font-medium">
                                            {{ $artisan->shop_name }}
                                        </td>
                                        <td class="p-4 align-middle">{{ $artisan->user->name }}</td>
                                        <td class="p-4 align-middle text-sm">{{ $artisan->user->email }}</td>
                                        <td class="p-4 align-middle">
                                            @if($artisan->is_approved)
                                                <x-ui.badge variant="success">Approuvé</x-ui.badge>
                                            @else
                                                <x-ui.badge variant="warning">En attente</x-ui.badge>
                                            @endif
                                        </td>
                                        <td class="p-4 align-middle text-sm text-muted-foreground">
                                            {{ $artisan->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="p-4 align-middle">
                                            <div class="flex gap-2">
                                                <x-ui.button 
                                                    size="sm" 
                                                    variant="outline"
                                                    href="{{ route('admin.artisans.show', $artisan) }}"
                                                >
                                                    Voir
                                                </x-ui.button>

                                                @if(!$artisan->is_approved)
                                                    <form method="POST" action="{{ route('admin.artisans.approve', $artisan) }}">
                                                        @csrf
                                                        <x-ui.button type="submit" size="sm" variant="default" as="button">
                                                            Approuver
                                                        </x-ui.button>
                                                    </form>

                                                    <form method="POST" action="{{ route('admin.artisans.reject', $artisan) }}" onsubmit="return confirm('Rejeter et supprimer cet artisan définitivement ?')">
                                                        @csrf
                                                        <x-ui.button type="submit" size="sm" variant="destructive" as="button">
                                                            Rejeter
                                                        </x-ui.button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </x-ui.table>

                        <div class="mt-4">
                            {{ $artisans->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucun artisan</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if($status === 'pending')
                                    Aucun artisan en attente de validation.
                                @elseif($status === 'approved')
                                    Aucun artisan approuvé pour le moment.
                                @else
                                    Aucun artisan enregistré.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
