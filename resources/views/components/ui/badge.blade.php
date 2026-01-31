@props(['variant' => 'amber'])

@php
  $base = 'inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-medium';
  $variants = [
    'amber' => 'bg-amber-50 text-amber-700 border-amber-100',
    'stone' => 'bg-stone-50 text-stone-700 border-stone-200',
    'success' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
    'danger' => 'bg-red-50 text-red-700 border-red-100',
  ];
  $classes = $base.' '.($variants[$variant] ?? $variants['amber']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</span>
@props([
    'variant' => 'default', // default, secondary, destructive, outline, success, warning
])

@php
$baseClasses = 'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2';

$variantClasses = [
    'default' => 'border-transparent bg-primary text-primary-foreground hover:bg-primary/80',
    'secondary' => 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80',
    'destructive' => 'border-transparent bg-destructive text-destructive-foreground hover:bg-destructive/80',
    'outline' => 'text-foreground',
    'success' => 'border-transparent bg-green-500 text-white hover:bg-green-600',
    'warning' => 'border-transparent bg-yellow-500 text-white hover:bg-yellow-600',
];

$classes = $baseClasses . ' ' . $variantClasses[$variant];
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
