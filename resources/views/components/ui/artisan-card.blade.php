@props(['artisan'])

<div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 text-center border border-stone-200">
  <div class="relative mb-6">
    <div class="w-20 h-20 rounded-full mx-auto overflow-hidden border-4 border-amber-100 bg-stone-50">
      @if(!empty($artisan->logo_url))
        <img src="{{ $artisan->logo_url }}" alt="{{ $artisan->name }}" class="w-full h-full object-cover"/>
      @else
        <div class="w-full h-full flex items-center justify-center text-stone-400">🏺</div>
      @endif
    </div>
    @if(!empty($artisan->is_featured))
      <div class="absolute -top-1 -right-1">
        <span class="bg-amber-500 text-white text-xs px-2 py-1 rounded-full">⭐</span>
      </div>
    @endif
  </div>

  <h3 class="font-semibold text-stone-900 mb-1">{{ $artisan->name }}</h3>
  @if(!empty($artisan->bio))
    <p class="text-sm text-stone-600 mb-4 line-clamp-2">{{ Str::limit($artisan->bio, 100) }}</p>
  @endif

  <div class="flex items-center justify-center gap-2 text-sm text-stone-500 mb-4">
    <span>📦 {{ $artisan->products_count }} créations</span>
  </div>

  <x-ui.button as="a" variant="primary" size="md" href="{{ route('front.artisans.show', $artisan->shop_slug) }}">
    Découvrir l'atelier
  </x-ui.button>
</div>
