@props([
    'name',
    'value' => null,
    'label' => null,
    'disabled' => false,
])

@php
$classes = 'aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50';
@endphp

<div class="flex items-center space-x-2">
    <input 
        type="radio"
        name="{{ $name }}"
        @if($value) value="{{ $value }}" @endif
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $classes]) }}
    >
    @if($label)
        <label {{ $attributes->only('id')->merge(['class' => 'text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70']) }}>
            {{ $label }}
        </label>
    @endif
</div>
