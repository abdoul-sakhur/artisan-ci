@props([
    'striped' => false,
    'hoverable' => true,
])

@php
$tableClasses = 'w-full caption-bottom text-sm';
$theadClasses = 'border-b';
$thClasses = 'h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0';
$tbodyClasses = '[&_tr:last-child]:border-0';
$trClasses = 'border-b transition-colors';

if ($hoverable) {
    $trClasses .= ' hover:bg-muted/50';
}

if ($striped) {
    $trClasses .= ' data-[state=selected]:bg-muted even:bg-muted/50';
}

$tdClasses = 'p-4 align-middle [&:has([role=checkbox])]:pr-0';
@endphp

<div class="relative w-full overflow-auto">
    <table {{ $attributes->merge(['class' => $tableClasses]) }}>
        {{ $slot }}
    </table>
</div>

{{-- Usage pattern:
<x-ui.table>
    <thead class="border-b">
        <tr>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Header 1</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Header 2</th>
        </tr>
    </thead>
    <tbody>
        <tr class="border-b transition-colors hover:bg-muted/50">
            <td class="p-4 align-middle">Cell 1</td>
            <td class="p-4 align-middle">Cell 2</td>
        </tr>
    </tbody>
</x-ui.table>
--}}
