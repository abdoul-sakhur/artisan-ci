@props([
    'orientation' => 'horizontal', // horizontal, vertical
])

@php
$classes = $orientation === 'horizontal' 
    ? 'shrink-0 bg-border h-[1px] w-full' 
    : 'shrink-0 bg-border w-[1px] h-full';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }} role="separator"></div>
