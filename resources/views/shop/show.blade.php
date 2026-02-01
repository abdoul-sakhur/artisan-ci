<x-public-layout>
    <x-slot name="title">{{ $product->name }} - ArtisanMarket</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Fil d'Ariane --}}
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Accueil</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ route('shop.index') }}" class="text-gray-500 hover:text-gray-700">Boutique</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ route('shop.index', ['category' => $product->category_id]) }}" class="text-gray-500 hover:text-gray-700">{{ $product->category->name }}</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><span class="text-gray-900 font-medium">{{ $product->name }}</span></li>
            </ol>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-12">
            
            {{-- Galerie d'images --}}
            <div class="mb-8 lg:mb-0">
                <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden mb-4">
                    @if($product->images->first())
                        <img id="mainImage" src="{{ $product->images->first()->image_url }}" alt="{{ $product->name }}" class="w-full h-96 lg:h-[500px] object-cover">
                    @else
                        <div class="w-full h-96 lg:h-[500px] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Miniatures (si plusieurs images) --}}
                @if($product->images->count() > 1)
                    <div class="flex space-x-2 overflow-x-auto">
                        @foreach($product->images as $index => $image)
                            <button 
                                onclick="changeImage('{{ $image->image_url }}')" 
                                class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-lg overflow-hidden border-2 border-transparent hover:border-gray-300 {{ $index == 0 ? 'border-gray-900' : '' }}"
                            >
                                <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Informations produit --}}
            <div>
                {{-- En-tête --}}
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-2">{{ $product->category->name }}</p>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="text-3xl font-bold text-gray-900">
                            {{ number_format($product->price, 0) }} FCFA
                        </span>
                        @if($product->is_featured)
                            <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor" stroke="none" />
                                </svg>
                                <span>Vedette</span>
                            </span>
                        @endif
                    </div>

                    {{-- Stock --}}
                    <div class="flex items-center space-x-2 mb-4">
                        @if($product->quantity > 0)
                            <div class="flex items-center text-green-600">
                                <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">En stock ({{ $product->quantity }} disponibles)</span>
                            </div>
                        @else
                            <div class="flex items-center text-red-600">
                                <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">Rupture de stock</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Description</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                {{-- Informations artisan --}}
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">À propos de l'artisan</h3>
                    <div class="flex items-start space-x-4">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 4-6 8-6s8 2 8 6" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $product->artisan->shop_name }}</h4>
                            <p class="text-sm text-gray-600 mb-2">Propriétaire: {{ $product->artisan->user->name }}</p>
                            @if($product->artisan->shop_description)
                                <p class="text-sm text-gray-700">{{ $product->artisan->shop_description }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('shop.index', ['artisan' => $product->artisan_id]) }}" class="text-sm text-gray-900 font-medium hover:text-gray-600">
                            Voir tous les produits de cet artisan →
                        </a>
                    </div>
                </div>

                {{-- Bouton d'achat --}}
                @if($product->quantity > 0)
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button type="button" onclick="decrementQuantity()" class="px-3 py-2 hover:bg-gray-50">-</button>
                            <input type="number" id="quantity" value="1" min="1" max="{{ $product->quantity }}" class="w-16 text-center border-0 focus:ring-0">
                            <button type="button" onclick="incrementQuantity()" class="px-3 py-2 hover:bg-gray-50">+</button>
                        </div>
                        <button onclick="addToCart({{ $product->id }})" class="flex-1 bg-amber-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-amber-700 transition">
                            Ajouter au panier
                        </button>
                    </div>
                @else
                    <div class="mb-8">
                        <button disabled class="w-full bg-gray-300 text-gray-500 px-8 py-3 rounded-lg font-medium cursor-not-allowed">
                            Produit indisponible
                        </button>
                    </div>
                @endif

                {{-- Informations techniques --}}
                <div class="border-t border-gray-200 pt-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        @if($product->sku)
                            <div>
                                <dt class="font-medium text-gray-900">SKU</dt>
                                <dd class="text-gray-700">{{ $product->sku }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="font-medium text-gray-900">Catégorie</dt>
                            <dd class="text-gray-700">{{ $product->category->name }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-900">Vues</dt>
                            <dd class="text-gray-700">{{ $product->views_count }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-900">Ajouté le</dt>
                            <dd class="text-gray-700">{{ $product->created_at->format('d/m/Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Autres produits du même artisan --}}
        @if($artisanProducts->count() > 0)
            <div class="mt-16 pt-16 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Autres produits de {{ $product->artisan->shop_name }}</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($artisanProducts as $otherProduct)
                        <a href="{{ route('shop.show', $otherProduct->slug) }}" class="group">
                            <div class="bg-white rounded-lg overflow-hidden hover:shadow-lg transition border border-gray-200">
                                <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                    @if($otherProduct->images->first())
                                        <img src="{{ $otherProduct->images->first()->image_url }}" alt="{{ $otherProduct->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-gray-500 mb-1">{{ $otherProduct->category->name }}</p>
                                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $otherProduct->name }}</h3>
                                    <span class="text-lg font-bold text-gray-900">
                                        {{ number_format($otherProduct->price, 0) }} FCFA
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Produits similaires --}}
        @if($relatedProducts->count() > 0)
            <div class="mt-16 pt-16 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Produits similaires</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <a href="{{ route('shop.show', $relatedProduct->slug) }}" class="group">
                            <div class="bg-white rounded-lg overflow-hidden hover:shadow-lg transition border border-gray-200">
                                <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                    @if($relatedProduct->images->first())
                                        <img src="{{ $relatedProduct->images->first()->image_url }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-gray-500 mb-1">{{ $relatedProduct->category->name }}</p>
                                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $relatedProduct->name }}</h3>
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-900">
                                            {{ number_format($relatedProduct->price, 0) }} FCFA
                                        </span>
                                        <span class="text-xs text-gray-500">Par {{ $relatedProduct->artisan->shop_name }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- JavaScript pour interactions --}}
    <script>
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
            
            // Mettre à jour les bordures des miniatures
            document.querySelectorAll('.flex-shrink-0 button').forEach(btn => {
                btn.classList.remove('border-gray-900');
                btn.classList.add('border-transparent');
            });
            event.target.closest('button').classList.add('border-gray-900');
            event.target.closest('button').classList.remove('border-transparent');
        }

        function incrementQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantity');
            const min = parseInt(input.getAttribute('min'));
            const current = parseInt(input.value);
            if (current > min) {
                input.value = current - 1;
            }
        }

        function addToCart(productId) {
            const quantity = parseInt(document.getElementById('quantity').value);
            
            // TODO: Implémenter l'ajout au panier via AJAX
            alert(`Produit ajouté au panier ! Quantité: ${quantity}`);
            
            // Ici on ferait un appel AJAX pour ajouter au panier
            // fetch('/cart/add', { method: 'POST', ... })
        }
    </script>

</x-public-layout>