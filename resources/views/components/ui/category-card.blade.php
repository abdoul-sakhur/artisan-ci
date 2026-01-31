@props(['category'])

<div class="group rounded-xl border border-stone-200 bg-white shadow-sm hover:shadow-md transition-shadow">
    <a href="{{ route('front.shop.index', ['category' => $category->id]) }}" class="block p-4">
        <div class="flex items-center gap-4">
            <div class="relative h-14 w-14 flex-shrink-0 overflow-hidden rounded-lg border border-stone-200 bg-stone-50">
                @if(isset($category->image_url) && $category->image_url)
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-full w-full object-cover"/>
                @else
                    <div class="h-full w-full flex items-center justify-center text-stone-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6" fill="currentColor"><path d="M2 7a5 5 0 015-5h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7zm6 6a4 4 0 108 0 4 4 0 00-8 0z"/></svg>
                    </div>
                @endif
            </div>

            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h3 class="text-stone-900 font-medium">{{ $category->name }}</h3>
                    @if(isset($category->products_count))
                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs text-amber-700 border border-amber-100">
                            {{ $category->products_count }}
                        </span>
                    @endif
                </div>
                @isset($category->description)
                    <p class="mt-1 text-sm text-stone-600 line-clamp-2">{{ Str::limit($category->description, 100) }}</p>
                @endisset
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <span class="text-sm text-stone-500">Parcourir la catégorie</span>
            <span class="rounded-md border border-stone-200 bg-stone-50 px-2 py-1 text-xs text-stone-600 group-hover:border-amber-300 group-hover:bg-amber-50 group-hover:text-amber-700 transition-colors">Voir</span>
        </div>
    </a>
</div>
