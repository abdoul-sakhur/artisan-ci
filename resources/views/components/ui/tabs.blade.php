@props([
    'defaultTab' => null,
])

<div 
    x-data="{ activeTab: '{{ $defaultTab }}' }"
    {{ $attributes->merge(['class' => 'w-full']) }}
>
    {{ $slot }}
</div>
