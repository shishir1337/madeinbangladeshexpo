@props([
    'name' => null,
])

{{-- Native <details>: works without JS, opens for in-page search, and `name` makes the group exclusive. --}}
<div {{ $attributes->class(['divide-y divide-sand border-y border-sand on-dark:divide-white/10 on-dark:border-white/10']) }}>
    {{ $slot }}
</div>
