<div>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Paramètres de la boutique</h1>
        <p class="text-gray-600 mt-1">Modifiez les informations de votre boutique</p>
    </div>

    <form wire:submit.prevent="updateSettings" class="max-w-4xl">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Nom de la boutique -->
            <div class="mb-6">
                <label for="shop_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nom de la boutique <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="shop_name" 
                    wire:model.blur="shop_name"
                    class="w-full px-4 py-3 border @error('shop_name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                    placeholder="Nom de votre boutique"
                >
                @error('shop_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="shop_description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="shop_description" 
                    wire:model.blur="shop_description"
                    rows="6"
                    class="w-full px-4 py-3 border @error('shop_description') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition resize-none"
                    placeholder="Description de votre boutique..."
                ></textarea>
                @error('shop_description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Logo de la boutique</label>
                
                <div class="flex items-start space-x-6">
                    <!-- Aperçu actuel -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2">Logo actuel</p>
                        @if($shop_logo)
                            <img src="{{ Storage::url($shop_logo) }}" alt="Logo actuel" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
                        @else
                            <div class="w-32 h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Nouveau logo -->
                    <div class="flex-1">
                        @if($newLogo)
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-2">Nouveau logo (aperçu)</p>
                                <div class="relative inline-block">
                                    <img src="{{ $newLogo->temporaryUrl() }}" alt="Nouveau logo" class="w-32 h-32 object-cover rounded-lg border-2 border-purple-400">
                                    <button 
                                        type="button" 
                                        wire:click="$set('newLogo', null)"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <label class="cursor-pointer inline-block bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium px-6 py-3 rounded-lg transition">
                            <span>{{ $newLogo ? 'Changer le logo' : 'Remplacer le logo' }}</span>
                            <input type="file" wire:model="newLogo" accept="image/*" class="hidden">
                        </label>

                        <p class="text-xs text-gray-500 mt-2">JPG, PNG ou WEBP (max 2MB)</p>

                        @error('newLogo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div wire:loading wire:target="newLogo" class="mt-2 text-sm text-purple-600">
                            Téléchargement en cours...
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bannière -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Bannière de la boutique</label>
                
                <!-- Aperçu actuel -->
                <div class="mb-4">
                    <p class="text-xs text-gray-500 mb-2">Bannière actuelle</p>
                    @if($shop_banner)
                        <img src="{{ Storage::url($shop_banner) }}" alt="Bannière actuelle" class="w-full max-w-2xl h-48 object-cover rounded-lg border-2 border-gray-300">
                    @else
                        <div class="w-full max-w-2xl h-48 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-500">Aucune bannière</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Nouvelle bannière -->
                @if($newBanner)
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2">Nouvelle bannière (aperçu)</p>
                        <div class="relative inline-block w-full max-w-2xl">
                            <img src="{{ $newBanner->temporaryUrl() }}" alt="Nouvelle bannière" class="w-full h-48 object-cover rounded-lg border-2 border-purple-400">
                            <button 
                                type="button" 
                                wire:click="$set('newBanner', null)"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <label class="cursor-pointer inline-block bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium px-6 py-3 rounded-lg transition">
                    <span>{{ $newBanner ? 'Changer la bannière' : 'Remplacer la bannière' }}</span>
                    <input type="file" wire:model="newBanner" accept="image/*" class="hidden">
                </label>

                <p class="text-xs text-gray-500 mt-2">JPG, PNG ou WEBP (max 3MB)</p>

                @error('newBanner')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div wire:loading wire:target="newBanner" class="mt-2 text-sm text-purple-600">
                    Téléchargement en cours...
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 my-8"></div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a 
                    href="{{ route('artisan.dashboard') }}" 
                    class="text-gray-600 hover:text-gray-800 font-medium"
                >
                    ← Retour au tableau de bord
                </a>

                <button 
                    type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled"
                    wire:target="updateSettings, newLogo, newBanner"
                >
                    <span wire:loading.remove wire:target="updateSettings">Enregistrer les modifications</span>
                    <span wire:loading wire:target="updateSettings">Enregistrement...</span>
                </button>
            </div>
        </div>
    </form>
</div>
