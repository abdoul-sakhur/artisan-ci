@props(['items' => collect(), 'emptyText' => 'Rien à afficher'])

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($items as $item)
        {{ $slot }}
    @empty
        <div class="col-span-full rounded-xl border border-stone-200 bg-stone-50 p-8 text-center text-stone-600">
            {{ $emptyText }}
        </div>
    @endforelse
</div>
