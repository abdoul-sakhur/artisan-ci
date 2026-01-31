@props([
    'variant' => 'default', // default, destructive, success, warning, info
    'title' => null,
    'dismissible' => false,
])

@php
$baseClasses = 'relative w-full rounded-lg border p-4';

$variantClasses = [
    'default' => 'bg-background text-foreground',
    'destructive' => 'border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive',
    'success' => 'border-green-500/50 bg-green-50 text-green-900 dark:bg-green-900/20 dark:text-green-400 [&>svg]:text-green-600',
    'warning' => 'border-yellow-500/50 bg-yellow-50 text-yellow-900 dark:bg-yellow-900/20 dark:text-yellow-400 [&>svg]:text-yellow-600',
    'info' => 'border-blue-500/50 bg-blue-50 text-blue-900 dark:bg-blue-900/20 dark:text-blue-400 [&>svg]:text-blue-600',
];

$classes = $baseClasses . ' ' . $variantClasses[$variant];
@endphp

<div 
    {{ $attributes->merge(['class' => $classes]) }}
    @if($dismissible)
        x-data="{ show: true }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
    @endif
    role="alert"
>
    <div class="flex items-start gap-3">
        <div class="flex-1">
            @if($title)
                <h5 class="mb-1 font-medium leading-none tracking-tight">{{ $title }}</h5>
            @endif
            <div class="text-sm [&_p]:leading-relaxed">
                {{ $slot }}
            </div>
        </div>
        
        @if($dismissible)
            <button 
                type="button"
                @click="show = false"
                class="opacity-70 hover:opacity-100 transition-opacity"
                aria-label="Fermer"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>
</div>
