<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nouvelle Catégorie') }}
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
                <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-ui.label for="name" required>Nom de la catégorie</x-ui.label>
                        <x-ui.input 
                            id="name" 
                            name="name" 
                            type="text" 
                            :value="old('name')" 
                            required 
                            autofocus
                            placeholder="Ex: Bijoux, Poterie, Textile..."
                        />
                        <p class="mt-1 text-sm text-gray-500">Le slug sera généré automatiquement</p>
                    </div>

                    <div>
                        <x-ui.label for="description">Description</x-ui.label>
                        <x-ui.textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            placeholder="Décrivez cette catégorie..."
                        >{{ old('description') }}</x-ui.textarea>
                    </div>

                    <div>
                        <x-ui.label for="image_url">URL de l'image</x-ui.label>
                        <x-ui.input 
                            id="image_url" 
                            name="image_url" 
                            type="url" 
                            :value="old('image_url')"
                            placeholder="https://example.com/image.jpg"
                        />
                        <p class="mt-1 text-sm text-gray-500">URL complète de l'image de la catégorie</p>
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <x-ui.checkbox 
                                id="is_active" 
                                name="is_active" 
                                value="1"
                                :checked="old('is_active', true)"
                            />
                            <x-ui.label for="is_active" class="!mb-0">
                                Catégorie active
                            </x-ui.label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Les catégories inactives ne seront pas visibles sur le site</p>
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <x-ui.button type="submit" variant="default" as="button">
                            Créer la catégorie
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
