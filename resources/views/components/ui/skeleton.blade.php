@props(['type' => 'text'])

@switch($type)
  @case('image')
    <div class="animate-pulse bg-stone-100 rounded-xl w-full h-48"></div>
    @break
  @case('card')
    <div class="animate-pulse rounded-xl border border-stone-200 bg-white p-4 space-y-3">
      <div class="h-40 rounded-lg bg-stone-100"></div>
      <div class="h-4 w-3/4 rounded bg-stone-100"></div>
      <div class="h-4 w-1/2 rounded bg-stone-100"></div>
    </div>
    @break
  @default
    <div class="animate-pulse h-4 rounded bg-stone-100"></div>
@endswitch
