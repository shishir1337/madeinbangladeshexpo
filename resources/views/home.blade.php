@php($eventName = $edition?->name ?: config('app.name'))

<x-layouts.site :title="$eventName">
    <main>
        <h1>{{ $eventName }}</h1>

        <p>{{ $dateRange ?? __('site.dates_to_be_announced') }}</p>

        @if ($edition?->venue)
            <p>{{ $edition->venue->name }}, {{ $edition->venue->city }}</p>
        @endif

        <p>{{ __('site.organised_by', ['organiser' => $settings->organiser_name]) }}</p>

        <p>
            <a href="tel:{{ preg_replace('/[^\d+]/', '', $settings->phone) }}">{{ $settings->phone }}</a>
        </p>
    </main>
</x-layouts.site>
