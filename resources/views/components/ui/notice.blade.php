@props([
    'tone' => 'info',
    'title' => null,
])

@php
    [$icon, $classes] = match ($tone) {
        'success' => ['check-circle', 'bg-green-50 text-green ring-green/15'],
        'warning' => ['alert-triangle', 'bg-yellow-soft text-navy ring-yellow'],
        'danger' => ['alert-triangle', 'bg-crimson-50 text-crimson ring-crimson/20'],
        default => ['info', 'bg-navy-50 text-navy ring-navy/10'],
    };
@endphp

<div role="note" {{ $attributes->class(['flex gap-3 rounded-2xl p-4 ring-1 ring-inset md:p-5', $classes]) }}>
    <x-ui.icon :name="$icon" class="mt-0.5 size-5" />
    <div class="min-w-0 text-[0.95rem] leading-relaxed text-ink">
        @if ($title)
            <p class="font-semibold text-current">{{ $title }}</p>
        @endif
        <div @class(['mt-1' => $title])>{{ $slot }}</div>
    </div>
</div>
