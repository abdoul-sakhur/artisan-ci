@props(['title' => "Œuvres en vedette", 'products' => collect()])

<section class="py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between">
            <h2 class="text-2xl sm:text-3xl font-semibold text-stone-900">{{ $title }}</h2>
            <a href="{{ route('front.shop.index') }}" class="text-sm rounded-md border border-stone-200 bg-white px-3 py-1.5 text-stone-900 hover:border-amber-300 hover:text-amber-700 transition-colors">Voir tout</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                @include('components.ui.product-card', ['product' => $product])
            @empty
                <div class="col-span-full rounded-xl border border-stone-200 bg-stone-50 p-8 text-center text-stone-600">
                    Aucune œuvre en vedette pour le moment.
                </div>
            @endforelse
        </div>
    </div>
</section>
