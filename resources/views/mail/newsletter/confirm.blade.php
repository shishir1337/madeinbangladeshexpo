<x-mail::message>
# {{ __('newsletter.mail.heading') }}

{{ __('newsletter.mail.intro') }}

<x-mail::button :url="$url" color="success">
{{ __('newsletter.mail.button') }}
</x-mail::button>

{{ __('newsletter.mail.expiry', ['days' => $days]) }}

{{ __('newsletter.mail.ignore') }}

{{ __('newsletter.mail.signature') }}
</x-mail::message>
