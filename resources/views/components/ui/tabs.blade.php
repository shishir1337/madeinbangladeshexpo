@props([
    'id',
    'tabs',
    'active' => null,
    'label' => null,
])

@php($current = $active ?? array_key_first($tabs))

{{-- APG tabs pattern. Without JS every panel is shown; with JS the inactive ones are hidden before first paint (see .js [data-tab-hidden]). --}}
<div x-data="tabs(@js($current), @js(array_keys($tabs)))" {{ $attributes }}>
    <div class="no-scrollbar -m-1 overflow-x-auto p-1">
        <div
            role="tablist"
            @if ($label) aria-label="{{ $label }}" @endif
            x-on:keydown.right.prevent="move(1)"
            x-on:keydown.left.prevent="move(-1)"
            x-on:keydown.home.prevent="go(0)"
            x-on:keydown.end.prevent="go(-1)"
            class="inline-flex gap-1 rounded-full bg-cream-2 p-1 ring-1 ring-sand on-dark:bg-white/5 on-dark:ring-white/10"
        >
            @foreach ($tabs as $key => $tabLabel)
                <button
                    type="button"
                    role="tab"
                    id="{{ $id }}-tab-{{ $key }}"
                    aria-controls="{{ $id }}-panel-{{ $key }}"
                    aria-selected="{{ $key === $current ? 'true' : 'false' }}"
                    tabindex="{{ $key === $current ? '0' : '-1' }}"
                    x-ref="tab-{{ $key }}"
                    x-bind:aria-selected="(active === @js($key)).toString()"
                    x-bind:tabindex="active === @js($key) ? 0 : -1"
                    x-on:click="select(@js($key))"
                    class="shrink-0 rounded-full px-4 py-2 text-sm font-semibold whitespace-nowrap text-ink-soft transition hover:text-navy aria-selected:bg-white aria-selected:text-navy aria-selected:shadow-soft on-dark:text-white/70 on-dark:hover:text-white on-dark:aria-selected:bg-white on-dark:aria-selected:text-navy"
                >{{ $tabLabel }}</button>
            @endforeach
        </div>
    </div>

    <div class="mt-6 md:mt-8">{{ $slot }}</div>
</div>
