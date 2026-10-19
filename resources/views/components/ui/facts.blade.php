@props([
    'items',
])

{{-- Key facts above the fold on landing pages (spec §6): dates, venue, price, next step. --}}
<dl {{ $attributes->class(['grid gap-3 sm:grid-cols-2 xl:grid-cols-4']) }}>
    @foreach ($items as $item)
        <div class="flex items-start gap-3 rounded-2xl bg-white/80 p-4 shadow-ring backdrop-blur on-dark:bg-white/[0.06] on-dark:shadow-none on-dark:ring-1 on-dark:ring-white/10">
            @if ($item['icon'] ?? null)
                <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-green-50 text-green on-dark:bg-white/10 on-dark:text-yellow">
                    <x-ui.icon :name="$item['icon']" class="size-5" />
                </span>
            @endif
            <div class="min-w-0">
                <dt class="text-xs font-semibold tracking-wide text-ink-soft uppercase on-dark:text-white/60">{{ $item['label'] }}</dt>
                <dd class="mt-1 font-semibold leading-snug text-navy on-dark:text-white">{{ $item['value'] }}</dd>
            </div>
        </div>
    @endforeach
</dl>
