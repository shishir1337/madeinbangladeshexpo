@aware([
    'id',
    'tabs' => [],
    'active' => null,
])

@props([
    'name',
])

@php($current = $active ?? array_key_first($tabs))

<div
    role="tabpanel"
    id="{{ $id }}-panel-{{ $name }}"
    aria-labelledby="{{ $id }}-tab-{{ $name }}"
    tabindex="0"
    x-show="active === @js($name)"
    @if ($name !== $current) data-tab-hidden @endif
    {{ $attributes->class(['rounded-2xl focus-visible:outline-offset-4']) }}
>
    {{ $slot }}
</div>
