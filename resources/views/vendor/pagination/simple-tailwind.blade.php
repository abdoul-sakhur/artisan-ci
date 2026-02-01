@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-stone-400 bg-white border border-stone-300 cursor-not-allowed leading-5 rounded-md">
                Précédent
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-stone-700 bg-white border border-stone-300 leading-5 rounded-md hover:text-stone-500 focus:outline-none focus:ring ring-stone-300 focus:border-amber-300 active:bg-stone-100 active:text-stone-700 transition ease-in-out duration-150">
                Précédent
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-stone-700 bg-white border border-stone-300 leading-5 rounded-md hover:text-stone-500 focus:outline-none focus:ring ring-stone-300 focus:border-amber-300 active:bg-stone-100 active:text-stone-700 transition ease-in-out duration-150">
                Suivant
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-stone-400 bg-white border border-stone-300 cursor-not-allowed leading-5 rounded-md">
                Suivant
            </span>
        @endif
    </nav>
@endif
