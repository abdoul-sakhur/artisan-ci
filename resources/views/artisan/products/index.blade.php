<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Mes Produits') }}
            </h2>
            <x-ui.add-button href="{{ route('artisan.products.create') }}">
                Nouveau Produit
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

            <x-ui.card>
                {{-- Filtres --}}
                <div class="px-4 py-4 border-b">
                    <x-ui.tabs defaultTab="{{ $status }}">
                        <x-ui.tabs-list>
                            <x-ui.tabs-trigger value="all">
                                <a href="{{ route('artisan.products.index') }}" class="block">Tous</a>
                            </x-ui.tabs-trigger>
                            <x-ui.tabs-trigger value="published">
                                <a href="{{ route('artisan.products.index', ['status' => 'published']) }}" class="block">Publiés</a>
                            </x-ui.tabs-trigger>
                            <x-ui.tabs-trigger value="draft">
                                <a href="{{ route('artisan.products.index', ['status' => 'draft']) }}" class="block">Brouillons</a>
                            </x-ui.tabs-trigger>
                            <x-ui.tabs-trigger value="low_stock">
                                <a href="{{ route('artisan.products.index', ['status' => 'low_stock']) }}" class="block">Stock Bas</a>
                            </x-ui.tabs-trigger>
                            <x-ui.tabs-trigger value="out_of_stock">
                                <a href="{{ route('artisan.products.index', ['status' => 'out_of_stock']) }}" class="block">Rupture</a>
                            </x-ui.tabs-trigger>
                        </x-ui.tabs-list>
                    </x-ui.tabs>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        @foreach($products as $product)
                            <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                                <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                                    @if($product->images->first())
                                        <img src="{{ $product->images->first()->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                            <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-gray-900 line-clamp-1">{{ $product->name }}</h3>
                                        <div class="flex gap-1">
                                            @if($product->is_published)
                                                <x-ui.badge variant="success" size="sm">Publié</x-ui.badge>
                                            @else
                                                <x-ui.badge variant="secondary" size="sm">Brouillon</x-ui.badge>
                                            @endif
                                            @if($product->is_featured)
                                                <x-ui.badge variant="default" size="sm">★</x-ui.badge>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>
                                    
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-lg font-bold text-gray-900">{{ number_format($product->price, 0) }} FCFA</span>
                                        <span class="text-sm text-gray-500">
                                            Stock: 
                                            <span class="{{ $product->quantity < 10 ? 'text-red-600 font-semibold' : '' }}">
                                                {{ $product->quantity }}
                                            </span>
                                        </span>
                                    </div>
                                    
                                    <div class="flex gap-2">
                                        <x-ui.button size="sm" variant="outline" href="{{ route('artisan.products.edit', $product) }}" class="flex-1 justify-center">
                                            Modifier
                                        </x-ui.button>
                                        <form method="POST" action="{{ route('artisan.products.destroy', $product) }}" onsubmit="return confirm('Supprimer ce produit ?')">
                                            @csrf
                                            @method('DELETE')
                                            <x-ui.button type="submit" size="sm" variant="destructive" as="button">
                                                Supprimer
                                            </x-ui.button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 pb-6">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucun produit</h3>
                        <p class="mt-1 text-sm text-gray-500">Commencez par créer votre premier produit.</p>
                        <div class="mt-6">
                            <x-ui.button href="{{ route('artisan.products.create') }}">
                                Créer un produit
                            </x-ui.button>
                        </div>
                    </div>
                @endif
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
