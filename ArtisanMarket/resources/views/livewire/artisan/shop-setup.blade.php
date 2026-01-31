<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Bienvenue sur ArtisanMarket</h1>
            <p class="text-lg text-gray-600">Créez votre boutique en quelques minutes</p>
        </div>

        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white">Configuration de votre boutique</h2>
            </div>

            <form wire:submit.prevent="createShop" class="px-8 py-8 space-y-6">
                <!-- Nom de la boutique -->
                <div>
                    <label for="shop_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nom de la boutique <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="shop_name" 
                        wire:model.blur="shop_name"
                        class="w-full px-4 py-3 border @error('shop_name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="Ex: Atelier Céramique Martin"
                    >
                    @error('shop_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="shop_description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description de votre boutique <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="shop_description" 
                        wire:model.blur="shop_description"
                        rows="5"
                        class="w-full px-4 py-3 border @error('shop_description') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition resize-none"
                        placeholder="Racontez votre histoire, votre savoir-faire, ce qui rend vos créations uniques..."
                    ></textarea>
                    @error('shop_description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Logo de la boutique <span class="text-gray-500 text-xs">(Optionnel, max 2MB)</span>
                    </label>
                    
                    <div class="mt-2 flex items-center space-x-4">
                        @if ($shop_logo)
                            <div class="relative">
                                <img src="{{ $shop_logo->temporaryUrl() }}" alt="Aperçu logo" class="h-24 w-24 object-cover rounded-lg border-2 border-purple-300">
                                <button 
                                    type="button" 
                                    wire:click="$set('shop_logo', null)"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @else
                            <div class="h-24 w-24 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif

                        <label class="cursor-pointer bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium px-6 py-3 rounded-lg transition">
                            <span>Choisir un logo</span>
                            <input type="file" wire:model="shop_logo" accept="image/*" class="hidden">
                        </label>
                    </div>

                    @error('shop_logo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="shop_logo" class="mt-2 text-sm text-purple-600">
                        Téléchargement en cours...
                    </div>
                </div>

                <!-- Bannière -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Bannière de la boutique <span class="text-gray-500 text-xs">(Optionnel, max 3MB)</span>
                    </label>
                    
                    @if ($shop_banner)
                        <div class="relative">
                            <img src="{{ $shop_banner->temporaryUrl() }}" alt="Aperçu bannière" class="w-full h-48 object-cover rounded-lg border-2 border-purple-300">
                            <button 
                                type="button" 
                                wire:click="$set('shop_banner', null)"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <label class="cursor-pointer bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium px-6 py-2 rounded-lg transition">
                                <span>Choisir une bannière</span>
                                <input type="file" wire:model="shop_banner" accept="image/*" class="hidden">
                            </label>
                        </div>
                    @endif

                    @error('shop_banner')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="shop_banner" class="mt-2 text-sm text-purple-600">
                        Téléchargement en cours...
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <div class="pt-4">
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                        wire:target="createShop"
                    >
                        <span wire:loading.remove wire:target="createShop">Créer ma boutique</span>
                        <span wire:loading wire:target="createShop">Création en cours...</span>
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-sm text-gray-600 mt-6">
            Votre boutique sera soumise à validation par notre équipe avant d'être publiée.
        </p>
    </div>
</div>
