@props([
  'variant' => 'primary', // primary, secondary, outline, ghost, link
  'size' => 'md', // sm, md, lg
  'as' => 'a', // a or button
])

@php
  $base = 'inline-flex items-center justify-center rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50';
  $sizes = [
    'sm' => 'px-3 py-1.5 text-sm',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-5 py-3 text-base',
  ];
  $variants = [
    'default' => 'bg-amber-600 text-white hover:bg-amber-700 focus:ring-amber-400',
    'primary' => 'bg-amber-600 text-white hover:bg-amber-700 focus:ring-amber-400',
    'secondary' => 'bg-stone-900 text-white hover:bg-stone-800 focus:ring-stone-400',
    'destructive' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-400',
    'outline' => 'border border-stone-300 text-stone-900 bg-white hover:border-amber-600 hover:text-amber-700 focus:ring-stone-300',
    'ghost' => 'text-stone-900 hover:bg-stone-100',
    'link' => 'text-amber-700 hover:text-amber-800',
  ];
  $classes = $base.' '.$sizes[$size].' '.$variants[$variant];
@endphp

@if($as === 'a')
  <a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
  <button {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
