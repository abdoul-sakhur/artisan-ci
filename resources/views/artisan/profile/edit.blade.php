<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gérer ma Boutique') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <x-ui.alert variant="success" dismissible class="mb-6">
                    {{ session('success') }}
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
                        Informations de la boutique
                    </h3>
                </div>

                <form method="POST" action="{{ route('artisan.profile.update') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-ui.label for="shop_name" required>Nom de la boutique</x-ui.label>
                        <x-ui.input 
                            id="shop_name" 
                            name="shop_name" 
                            type="text" 
                            :value="old('shop_name', $artisan->shop_name)" 
                            required 
                            autofocus
                        />
                        <p class="mt-1 text-sm text-gray-500">
                            Slug actuel : <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $artisan->shop_slug }}</code>
                        </p>
                    </div>

                    <div>
                        <x-ui.label for="shop_description">Description de la boutique</x-ui.label>
                        <x-ui.textarea 
                            id="shop_description" 
                            name="shop_description" 
                            rows="6"
                            placeholder="Parlez de votre artisanat, votre histoire, vos techniques..."
                        >{{ old('shop_description', $artisan->shop_description) }}</x-ui.textarea>
                    </div>

                    <div>
                        <x-ui.label for="shop_logo">Logo de la boutique</x-ui.label>
                        <x-ui.input 
                            id="shop_logo" 
                            name="shop_logo" 
                            type="file"
                            accept="image/png,image/jpeg,image/webp"
                        />
                        @if($artisan->logo_url)
                            <div class="mt-3">
                                <p class="text-sm text-gray-500 mb-2">Logo actuel :</p>
                                <img src="{{ $artisan->logo_url }}" alt="Logo" class="h-24 w-24 object-cover rounded-lg border">
                            </div>
                        @endif
                        <p class="mt-1 text-sm text-gray-500">Formats autorisés: JPG, PNG, WEBP (max 5MB)</p>
                    </div>

                    <div>
                        <x-ui.label for="shop_banner">Bannière de la boutique</x-ui.label>
                        <x-ui.input 
                            id="shop_banner" 
                            name="shop_banner" 
                            type="file"
                            accept="image/png,image/jpeg,image/webp"
                        />
                        @if($artisan->banner_url)
                            <div class="mt-3">
                                <p class="text-sm text-gray-500 mb-2">Bannière actuelle :</p>
                                <img src="{{ $artisan->banner_url }}" alt="Bannière" class="w-full h-32 object-cover rounded-lg border">
                            </div>
                        @endif
                        <p class="mt-1 text-sm text-gray-500">Dimensions recommandées : 1200x400 pixels</p>
                    </div>

                    @if($artisan->is_approved)
                        <x-ui.alert variant="success">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div class="ml-3">
                                Votre boutique est <strong>approuvée</strong> et visible sur la plateforme.
                            </div>
                        </x-ui.alert>
                    @else
                        <x-ui.alert variant="warning">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="ml-3">
                                Votre boutique est <strong>en attente d'approbation</strong>. Vous pourrez ajouter des produits une fois approuvée.
                            </div>
                        </x-ui.alert>
                    @endif

                    <div class="flex gap-3 pt-4 border-t">
                        <x-ui.button type="submit" variant="default" as="button">
                            Enregistrer les modifications
                        </x-ui.button>
                        <x-ui.button type="button" variant="outline" href="{{ route('artisan.dashboard') }}">
                            Annuler
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
