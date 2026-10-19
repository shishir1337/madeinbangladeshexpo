@props([
    'tone' => 'neutral',
    'icon' => null,
])

<span {{ $attributes->class([
    'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold leading-5',
    match ($tone) {
        'green' => 'bg-green-50 text-green',
        'navy' => 'bg-navy-50 text-navy',
        'yellow' => 'bg-yellow-soft text-navy',
        'crimson' => 'bg-crimson-50 text-crimson',
        'dark' => 'bg-white/10 text-white ring-1 ring-white/15',
        default => 'bg-cream-2 text-ink ring-1 ring-sand',
    },
]) }}>
    @if ($icon)
        <x-ui.icon :name="$icon" class="size-3.5" />
    @endif
    {{ $slot }}
</span>
