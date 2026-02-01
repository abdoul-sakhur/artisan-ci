<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Créer ma Boutique Artisan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('info'))
                <x-ui.alert variant="info" dismissible class="mb-6">
                    {{ session('info') }}
                </x-ui.alert>
            @endif

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
                <div class="px-4 py-5 sm:px-6 border-b">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Bienvenue chez Artisan CI
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Commencez par créer votre boutique. Vous pourrez ajouter vos produits une fois celle-ci approuvée.
                    </p>
                </div>

                <form method="POST" action="{{ route('artisan.profile.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf

                    <div>
                        <x-ui.label for="shop_name" required>Nom de la boutique</x-ui.label>
                        <x-ui.input 
                            id="shop_name" 
                            name="shop_name" 
                            type="text" 
                            :value="old('shop_name')" 
                            required 
                            autofocus
                            placeholder="Ex: Atelier de Poterie Abidjan"
                        />
                        <p class="mt-1 text-sm text-gray-500">
                            Un identifiant unique sera généré automatiquement
                        </p>
                    </div>

                    <div>
                        <x-ui.label for="shop_description">Description de la boutique</x-ui.label>
                        <x-ui.textarea 
                            id="shop_description" 
                            name="shop_description" 
                            rows="6"
                            placeholder="Parlez de votre artisanat, votre histoire, vos techniques..."
                        >{{ old('shop_description') }}</x-ui.textarea>
                        <p class="mt-1 text-sm text-gray-500">
                            Présentez votre savoir-faire et ce qui rend votre travail unique
                        </p>
                    </div>

                    <div>
                        <x-ui.label for="shop_logo">Logo de la boutique (optionnel)</x-ui.label>
                        <x-ui.input 
                            id="shop_logo" 
                            name="shop_logo" 
                            type="file"
                            accept="image/png,image/jpeg,image/webp"
                        />
                        <p class="mt-1 text-sm text-gray-500">
                            Formats autorisés: JPG, PNG, WEBP (max 5MB)
                        </p>
                    </div>

                    <div>
                        <x-ui.label for="shop_banner">Bannière de la boutique (optionnel)</x-ui.label>
                        <x-ui.input 
                            id="shop_banner" 
                            name="shop_banner" 
                            type="file"
                            accept="image/png,image/jpeg,image/webp"
                        />
                        <p class="mt-1 text-sm text-gray-500">Dimensions recommandées : 1200x400 pixels (max 8MB)</p>
                    </div>

                    <x-ui.alert variant="info">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Processus d'approbation</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>Après la création de votre boutique, notre équipe examinera votre demande. Vous serez notifié par email dès que votre boutique sera approuvée (généralement sous 48h).</p>
                                </div>
                            </div>
                        </div>
                    </x-ui.alert>

                    <div class="flex items-center gap-3 pt-4">
                        <x-ui.button type="submit" as="button">
                            Créer ma boutique
                        </x-ui.button>
                        
                        <x-ui.button variant="outline" href="{{ route('dashboard') }}" type="button">
                            Annuler
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
