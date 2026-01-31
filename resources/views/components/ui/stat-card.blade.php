@props([
    'title',
    'value',
    'icon' => null,
    'trend' => null, // 'up' or 'down'
    'trendValue' => null,
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-lg border bg-card text-card-foreground shadow-sm p-6']) }}>
    <div class="flex items-center justify-between space-x-4">
        <div class="flex-1 space-y-1">
            <p class="text-sm font-medium text-muted-foreground">{{ $title }}</p>
            <p class="text-2xl font-bold">{{ $value }}</p>
            
            @if($trendValue)
                <div class="flex items-center gap-1 text-xs">
                    @if($trend === 'up')
                        <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-green-600 font-medium">{{ $trendValue }}</span>
                    @elseif($trend === 'down')
                        <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        <span class="text-red-600 font-medium">{{ $trendValue }}</span>
                    @endif
                    @if($description)
                        <span class="text-muted-foreground">{{ $description }}</span>
                    @endif
                </div>
            @endif
        </div>
        
        @if($icon)
            <div class="rounded-full bg-primary/10 p-3">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
