@props(['product'])

<div class="group rounded-xl border border-stone-200 bg-white shadow-sm hover:shadow-md transition-all">
    <a href="{{ route('front.shop.product', $product->slug) }}" class="block">
        <div class="relative overflow-hidden rounded-t-xl">
            <div class="aspect-square bg-stone-50">
                @php($image = $product->images->first())
                @if($image)
                    <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover"/>
                @else
                    <div class="h-full w-full animate-pulse"></div>
                @endif
            </div>

            <div class="absolute inset-x-0 top-0 flex items-center justify-between p-3">
                @if($product->is_featured)
                    <span class="rounded-full bg-amber-600 px-3 py-1 text-xs text-white shadow">Vedette</span>
                @endif
                @if($product->stock_quantity > 0)
                    <span class="rounded-full bg-white/80 backdrop-blur px-3 py-1 text-xs text-stone-800 border border-stone-200 shadow">En stock</span>
                @else
                    <span class="rounded-full bg-stone-900/80 px-3 py-1 text-xs text-white shadow">Épuisé</span>
                @endif
            </div>
        </div>
    </a>

    <div class="p-4">
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <h3 class="text-stone-900 font-medium truncate">{{ $product->name }}</h3>
                <div class="mt-1 text-sm text-stone-500 truncate">
                    @if($product->artisan)
                        Atelier de {{ $product->artisan->name }}
                    @endif
                </div>
            </div>
            <div class="text-right">
                <div class="text-stone-900 font-semibold">{{ $product->formatted_price }}</div>
                <div class="text-xs text-stone-500">TVA incl.</div>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <a href="{{ route('front.artisans.show', $product->artisan?->shop_slug) }}" class="text-xs text-stone-500 hover:text-amber-700 transition-colors">
                Voir l'atelier
            </a>
            @if(!auth()->check() || !auth()->user()->hasRole('artisan'))
            <button
                x-data
                @click.prevent="(async () => {
                    const res = await fetch('{{ route('front.cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ product_id: {{ $product->id }}, quantity: 1 })
                    });
                    const data = await res.json();
                    if (data?.success) {
                        window.dispatchEvent(new CustomEvent('cart-updated', { detail: {
                            count: data.cart.count,
                            formatted_total: data.cart.total,
                            items: data.cart.items
                        }}));
                    }
                })()"
                class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-white shadow-sm hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 disabled:opacity-50"
                @disabled($product->stock_quantity <= 0)
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M3 3h2l3.6 7.59-1.35 2.45A2 2 0 009 15h9a2 2 0 001.8-1.1l3-6A1 1 0 0022 7H7.21l-.94-2H3zm16 16a2 2 0 11-4 0 2 2 0 014 0zm-10 0a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Ajouter au panier
            </button>
            @endif
        </div>
    </div>
</div>
