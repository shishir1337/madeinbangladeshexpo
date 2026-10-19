@props([
    'href',
    'icon' => 'arrow-right',
])

<a href="{{ $href }}" {{ $attributes->class(['group/link inline-flex items-center gap-1.5 font-semibold text-navy on-dark:text-white']) }}>
    <span class="link-underline">{{ $slot }}</span>
    @if ($icon)
        <x-ui.icon :name="$icon" class="size-4 transition-transform duration-300 group-hover/link:translate-x-0.5" />
    @endif
</a>
