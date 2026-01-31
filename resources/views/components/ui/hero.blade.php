<section class="relative overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-gradient-to-b from-stone-50 via-amber-50/40 to-white"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-6">
                <span class="inline-flex items-center gap-2 rounded-full border border-stone-200 bg-white/70 backdrop-blur px-3 py-1 text-xs font-medium text-stone-700 shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-amber-600"></span>
                    Sélection premium d'artisans
                </span>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-stone-900">
                    Découvrez l'excellence artisanale marocaine
                </h1>
                <p class="text-stone-600 text-base sm:text-lg leading-relaxed max-w-xl">
                    Des créations uniques façonnées avec passion. Parcourez les œuvres, soutenez des ateliers authentiques et embellissez votre quotidien.
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('front.shop.index') }}" class="inline-flex items-center justify-center rounded-lg bg-amber-600 px-5 py-3 text-white shadow-sm hover:bg-amber-700 transition-colors">
                        Explorer les créations
                    </a>
                    <a href="{{ route('front.artisans.index') }}" class="inline-flex items-center justify-center rounded-lg border border-stone-300 bg-white px-5 py-3 text-stone-900 shadow-sm hover:border-amber-600 hover:text-amber-700 transition-colors">
                        Découvrir les ateliers
                    </a>
                </div>

                <div class="mt-6 flex items-center gap-6 text-sm text-stone-500">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-stone-800">500+</span>
                        œuvres sélectionnées
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-stone-800">100+</span>
                        artisans certifiés
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="rounded-2xl border border-stone-200 bg-white/70 backdrop-blur p-4 shadow-xl">
                    <div class="aspect-[4/3] w-full overflow-hidden rounded-xl">
                        @if(isset($heroImage) && $heroImage)
                            <img src="{{ $heroImage }}" alt="Artisanat marocain" class="h-full w-full object-cover"/>
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-stone-100 via-stone-50 to-amber-50"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
