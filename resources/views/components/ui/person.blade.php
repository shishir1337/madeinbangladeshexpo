@props([
    'person',
    'featured' => false,
])

@php
    $initials = collect(explode(' ', preg_replace('/^(H\.E\.|Md\.|Dr\.)\s+/u', '', $person->name)))
        ->filter()
        ->map(fn (string $word): string => mb_substr($word, 0, 1))
        ->take(2)
        ->implode('');
@endphp

{{-- One person BBCCI has named: photo (or initials), name, role, optional bio and role email. --}}
<article {{ $attributes->class([
    'flex h-full flex-col rounded-[1.75rem] p-6 md:p-7',
    'bg-midnight text-white' => $featured,
    'bg-white shadow-soft ring-1 ring-ink/5' => ! $featured,
]) }} @if ($featured) data-tone="midnight" @endif>
    <div class="flex items-center gap-4">
        @if ($person->photo)
            <div class="size-20 shrink-0 overflow-hidden rounded-2xl bg-cream-2 ring-1 ring-ink/5">
                <x-ui.img :key="$person->photo" :alt="$person->name" sizes="80px" class="size-full object-cover object-top" />
            </div>
        @else
            <span class="grid size-20 shrink-0 place-items-center rounded-2xl bg-yellow font-display text-2xl font-semibold text-navy" aria-hidden="true">{{ $initials }}</span>
        @endif
        <div class="min-w-0">
            <h3 class="font-display text-xl leading-tight font-semibold text-navy on-dark:text-white">{{ $person->name }}</h3>
            <p class="mt-1 text-sm leading-snug font-medium text-green on-dark:text-mint">{{ $person->role }}</p>
        </div>
    </div>

    @if ($person->bio)
        <p class="mt-5 leading-relaxed text-ink-soft on-dark:text-white/75">{{ $person->bio }}</p>
    @endif

    @if ($person->email)
        <p class="mt-auto pt-5">
            <a href="mailto:{{ $person->email }}" class="inline-flex max-w-full items-center gap-2 text-sm font-semibold text-navy hover:text-green on-dark:text-white on-dark:hover:text-mint">
                <x-ui.icon name="mail" class="size-4 shrink-0" />
                <span class="link-underline break-all">{{ $person->email }}</span>
            </a>
        </p>
    @endif
</article>
