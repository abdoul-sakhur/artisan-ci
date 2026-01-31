<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Modifier la catégorie') }} : {{ $category->name }}
            </h2>
            <x-ui.button variant="outline" href="{{ route('admin.categories.index') }}">
                Retour
            </x-ui.button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if($errors->any())
                <x-ui.alert variant="destructive" dismissible class="mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-ui.alert>
            @endif

            <x-ui.card>
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-ui.label for="name" required>Nom de la catégorie</x-ui.label>
                        <x-ui.input 
                            id="name" 
                            name="name" 
                            type="text" 
                            :value="old('name', $category->name)" 
                            required 
                            autofocus
                            placeholder="Ex: Bijoux, Poterie, Textile..."
                        />
                        <p class="mt-1 text-sm text-gray-500">
                            Slug actuel : <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $category->slug }}</code>
                        </p>
                    </div>

                    <div>
                        <x-ui.label for="description">Description</x-ui.label>
                        <x-ui.textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            placeholder="Décrivez cette catégorie..."
                        >{{ old('description', $category->description) }}</x-ui.textarea>
                    </div>

                    <div>
                        <x-ui.label for="image_url">URL de l'image</x-ui.label>
                        <x-ui.input 
                            id="image_url" 
                            name="image_url" 
                            type="url" 
                            :value="old('image_url', $category->image_url)"
                            placeholder="https://example.com/image.jpg"
                        />
                        @if($category->image_url)
                            <div class="mt-3">
                                <p class="text-sm text-gray-500 mb-2">Image actuelle :</p>
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-32 w-32 object-cover rounded-lg border">
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <x-ui.checkbox 
                                id="is_active" 
                                name="is_active" 
                                value="1"
                                :checked="old('is_active', $category->is_active)"
                            />
                            <x-ui.label for="is_active" class="!mb-0">
                                Catégorie active
                            </x-ui.label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Les catégories inactives ne seront pas visibles sur le site</p>
                    </div>

                    @if($category->products_count > 0)
                        <x-ui.alert variant="default">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="ml-3">
                                Cette catégorie contient <strong>{{ $category->products_count }}</strong> {{ $category->products_count > 1 ? 'produits' : 'produit' }}.
                            </div>
                        </x-ui.alert>
                    @endif

                    <div class="flex gap-3 pt-4 border-t">
                        <x-ui.button type="submit" variant="default">
                            Enregistrer les modifications
                        </x-ui.button>
                        <x-ui.button type="button" variant="outline" href="{{ route('admin.categories.index') }}">
                            Annuler
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
