<section class="relative overflow-hidden bg-gradient-to-br from-amber-50 via-white to-stone-50 py-20 lg:py-32">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #d97706 1px, transparent 0); background-size: 32px 32px;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-4xl mx-auto">
            
            {{-- Badge / Tagline --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-100 border border-amber-200 rounded-full text-sm font-medium text-amber-800 mb-6 shadow-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span>Plateforme N°1 des artisans ivoiriens</span>
            </div>

            {{-- Main Title - Style monartisan.ci --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-stone-900 mb-6 leading-tight">
                Des pros en un clic<br/>
                <span class="text-amber-600">pour tous vos besoins</span>
            </h1>

            {{-- Subtitle --}}
            <p class="text-lg sm:text-xl text-stone-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                Découvrez des créations artisanales uniques. Soutenez le savoir-faire traditionnel et trouvez la pièce parfaite pour embellir votre quotidien.
            </p>

            {{-- CTA Principal unique et proéminent --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                <a href="{{ route('front.shop.index') }}" 
                   class="group relative inline-flex items-center justify-center gap-3 px-10 py-5 bg-amber-600 text-white text-lg font-semibold rounded-xl shadow-lg shadow-amber-600/30 transition-all duration-300 hover:bg-amber-700 hover:shadow-xl hover:shadow-amber-600/40 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 min-w-[240px]">
                    <span>Explorer la boutique</span>
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>

                <a href="{{ route('front.artisans.index') }}" 
                   class="group inline-flex items-center justify-center gap-2 px-8 py-5 bg-white border-2 border-stone-200 text-stone-700 text-lg font-medium rounded-xl transition-all duration-300 hover:border-amber-600 hover:text-amber-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-stone-300 focus:ring-offset-2 min-w-[240px]">
                    <span>Découvrir les artisans</span>
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>

            {{-- Trust Indicators / Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 max-w-3xl mx-auto pt-8 border-t border-stone-200">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-amber-600 mb-1">500+</div>
                    <div class="text-sm text-stone-600">Artisans</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-amber-600 mb-1">10K+</div>
                    <div class="text-sm text-stone-600">Créations</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-amber-600 mb-1">98%</div>
                    <div class="text-sm text-stone-600">Satisfaits</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-amber-600 mb-1">🇲🇦</div>
                    <div class="text-sm text-stone-600">100% Local</div>
                </div>
            </div>

        </div>
    </div>
</section>
