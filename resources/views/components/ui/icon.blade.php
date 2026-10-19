@props([
    'name',
    'label' => null,
])

@php
    $body = \App\Support\Icons\IconSet::body($name);
    $classes = ['size-5' => ! str_contains((string) $attributes->get('class'), 'size-'), 'shrink-0'];
    $inSprite = $body !== null && app(\App\Support\Icons\IconSprite::class)->reference($name);
@endphp

@if ($inSprite)
    <svg {{ $attributes->class($classes) }} @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" focusable="false" @endif><use href="#i-{{ $name }}"/></svg>
@elseif ($body !== null)
    @if (\App\Support\Icons\IconSet::isFilled($name))
        <svg {{ $attributes->class($classes) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" focusable="false" @endif>{!! $body !!}</svg>
    @else
        <svg {{ $attributes->class($classes) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" focusable="false" @endif>{!! $body !!}</svg>
    @endif
@endif
