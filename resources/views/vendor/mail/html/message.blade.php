{{-- Laravel's mail message layout with the header and footer in the recipient's language. --}}
<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ __('site.brand') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
{{ __('site.footer.copyright', ['year' => app(\App\Support\Localization\LocaleFormatter::class)->plain((int) date('Y')), 'organiser' => app(\App\Settings\GeneralSettings::class)->organiser_name]) }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
