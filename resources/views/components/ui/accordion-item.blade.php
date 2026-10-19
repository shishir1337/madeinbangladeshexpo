@aware([
    'name' => null,
])

@props([
    'title',
    'open' => false,
])

<details @if ($name) name="{{ $name }}" @endif @if ($open) open @endif {{ $attributes->class(['group/acc']) }}>
    <summary class="flex cursor-pointer list-none items-start justify-between gap-6 py-5 text-left font-semibold text-navy transition-colors hover:text-green-700 on-dark:text-white [&::-webkit-details-marker]:hidden">
        <span class="text-[1.05rem] leading-snug">{{ $title }}</span>
        <span class="mt-0.5 grid size-7 shrink-0 place-items-center rounded-full bg-white text-navy shadow-ring transition-transform duration-300 group-open/acc:rotate-45">
            <x-ui.icon name="plus" class="size-4" />
        </span>
    </summary>
    <div class="prose-site pb-6 pr-4 text-ink-soft md:pr-14 on-dark:text-white/75">
        {{ $slot }}
    </div>
</details>
