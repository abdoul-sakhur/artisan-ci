@props([
    'name' => 'images',
    'label' => 'Images',
    'multiple' => true,
    'accept' => 'image/jpeg,image/jpg,image/png,image/webp',
    'maxSize' => '5', // MB
    'existingImages' => [],
])

<div class="space-y-4" x-data="imageUploader({{ json_encode($existingImages) }})">
    <div>
        <x-ui.label :for="$name">{{ $label }}</x-ui.label>
        <p class="text-sm text-gray-500 mt-1">
            Format acceptés : JPEG, JPG, PNG, WEBP. Taille max : {{ $maxSize }}MB{{ $multiple ? '. Vous pouvez sélectionner plusieurs images.' : '.' }}
        </p>
    </div>

    <!-- Input file caché -->
    <input 
        type="file" 
        id="{{ $name }}"
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        accept="{{ $accept }}"
        {{ $multiple ? 'multiple' : '' }}
        class="hidden"
        @change="handleFiles($event)"
    />

    <!-- Zone de drop -->
    <div 
        @click="$el.previousElementSibling.click()"
        @dragover.prevent="dragover = true"
        @dragleave.prevent="dragover = false"
        @drop.prevent="handleDrop($event)"
        :class="dragover ? 'border-amber-500 bg-amber-50' : 'border-gray-300 hover:border-amber-400'"
        class="border-2 border-dashed rounded-lg p-8 text-center cursor-pointer transition-colors"
    >
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <p class="mt-2 text-sm text-gray-600">
            <span class="font-semibold text-amber-600">Cliquez pour parcourir</span> ou glissez-déposez
        </p>
    </div>

    <!-- Images existantes (pour édition) -->
    <template x-if="existingImages.length > 0">
        <div>
            <p class="text-sm font-medium text-gray-700 mb-3">Images actuelles</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <template x-for="(image, index) in existingImages" :key="image.id">
                    <div class="relative group">
                        <img :src="image.thumbnail_url" :alt="'Image ' + (index + 1)" class="w-full h-32 object-cover rounded-lg border">
                        <div class="absolute top-2 right-2 flex gap-1">
                            <template x-if="image.is_primary">
                                <span class="bg-amber-600 text-white text-xs px-2 py-1 rounded">Principale</span>
                            </template>
                            <button 
                                type="button"
                                @click="removeExistingImage(image.id)"
                                class="bg-red-600 text-white p-1.5 rounded hover:bg-red-700 transition"
                                title="Supprimer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 truncate" x-text="image.formatted_size"></p>
                    </div>
                </template>
            </div>
            <!-- Hidden inputs pour images à supprimer -->
            <template x-for="imageId in imagesToDelete" :key="imageId">
                <input type="hidden" name="delete_images[]" :value="imageId">
            </template>
        </div>
    </template>

    <!-- Prévisualisation des nouvelles images -->
    <template x-if="previews.length > 0">
        <div>
            <p class="text-sm font-medium text-gray-700 mb-3">
                Nouvelles images (<span x-text="previews.length"></span>)
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <template x-for="(preview, index) in previews" :key="index">
                    <div class="relative group">
                        <img :src="preview.url" :alt="preview.name" class="w-full h-32 object-cover rounded-lg border">
                        <button 
                            type="button"
                            @click="removePreview(index)"
                            class="absolute top-2 right-2 bg-red-600 text-white p-1.5 rounded hover:bg-red-700 transition"
                            title="Retirer"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <p class="text-xs text-gray-500 mt-1 truncate" x-text="preview.name"></p>
                        <p class="text-xs text-gray-400" x-text="formatSize(preview.size)"></p>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <!-- Messages d'erreur -->
    <template x-if="errors.length > 0">
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Erreurs de validation</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <template x-for="error in errors" :key="error">
                                <li x-text="error"></li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
function imageUploader(existingImages = []) {
    return {
        dragover: false,
        previews: [],
        files: [],
        errors: [],
        existingImages: existingImages,
        imagesToDelete: [],
        maxFileSize: {{ $maxSize }} * 1024 * 1024, // Convert MB to bytes
        
        handleFiles(event) {
            this.errors = [];
            const newFiles = Array.from(event.target.files);
            this.addFiles(newFiles);
        },
        
        handleDrop(event) {
            this.dragover = false;
            this.errors = [];
            const newFiles = Array.from(event.dataTransfer.files);
            this.addFiles(newFiles);
        },
        
        addFiles(newFiles) {
            newFiles.forEach(file => {
                // Validation
                if (!file.type.match('image.*')) {
                    this.errors.push(`${file.name} n'est pas une image valide.`);
                    return;
                }
                
                if (file.size > this.maxFileSize) {
                    this.errors.push(`${file.name} dépasse la taille maximale de {{ $maxSize }}MB.`);
                    return;
                }
                
                // Créer preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previews.push({
                        url: e.target.result,
                        name: file.name,
                        size: file.size
                    });
                };
                reader.readAsDataURL(file);
                
                this.files.push(file);
            });
            
            // Update file input
            this.updateFileInput();
        },
        
        removePreview(index) {
            this.previews.splice(index, 1);
            this.files.splice(index, 1);
            this.updateFileInput();
        },
        
        removeExistingImage(imageId) {
            // Marquer pour suppression
            if (!this.imagesToDelete.includes(imageId)) {
                this.imagesToDelete.push(imageId);
            }
            // Retirer de l'affichage
            this.existingImages = this.existingImages.filter(img => img.id !== imageId);
        },
        
        updateFileInput() {
            const input = document.getElementById('{{ $name }}');
            const dataTransfer = new DataTransfer();
            
            this.files.forEach(file => {
                dataTransfer.items.add(file);
            });
            
            input.files = dataTransfer.files;
        },
        
        formatSize(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
        }
    }
}
</script>
