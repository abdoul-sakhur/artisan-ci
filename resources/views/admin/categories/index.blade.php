<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestion des Catégories') }}
            </h2>
            <x-ui.add-button href="{{ route('admin.categories.create') }}">
                Nouvelle Catégorie
            </x-ui.add-button>
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
                @if($categories->count() > 0)
                    <x-ui.table>
                        <thead class="border-b">
                            <tr>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Nom</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Slug</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Produits</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Statut</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-4 align-middle">
                                        <div class="flex items-center gap-3">
                                            @if($category->image_url)
                                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-10 w-10 rounded-lg object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-medium">{{ $category->name }}</div>
                                                @if($category->description)
                                                    <div class="text-sm text-gray-500">{{ Str::limit($category->description, 50) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle text-sm text-muted-foreground">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="p-4 align-middle">
                                        <x-ui.badge variant="secondary">
                                            {{ $category->products_count }} {{ $category->products_count > 1 ? 'produits' : 'produit' }}
                                        </x-ui.badge>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center">
                                                @if($category->is_active)
                                                    <x-ui.badge variant="success">Active</x-ui.badge>
                                                @else
                                                    <x-ui.badge variant="secondary">Inactive</x-ui.badge>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="flex gap-2">
                                            <x-ui.button 
                                                size="sm" 
                                                variant="outline"
                                                href="{{ route('admin.categories.edit', $category) }}"
                                            >
                                                Modifier
                                            </x-ui.button>

                                            @if($category->products_count === 0)
                                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-ui.button type="submit" size="sm" variant="destructive">
                                                        Supprimer
                                                    </x-ui.button>
                                                </form>
                                            @else
                                                <x-ui.button 
                                                    size="sm" 
                                                    variant="destructive" 
                                                    disabled
                                                    title="Impossible de supprimer une catégorie contenant des produits"
                                                >
                                                    Supprimer
                                                </x-ui.button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>

                    <div class="mt-4 px-4">
                        {{ $categories->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucune catégorie</h3>
                        <p class="mt-1 text-sm text-gray-500">Commencez par créer une nouvelle catégorie.</p>
                        <div class="mt-6">
                            <x-ui.button href="{{ route('admin.categories.create') }}">
                                Créer une catégorie
                            </x-ui.button>
                        </div>
                    </div>
                @endif
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
