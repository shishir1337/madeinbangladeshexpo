@inject('shell', 'App\View\SiteShell')

<x-layouts.site :title="__('newsletter.unsubscribe_invalid.title').' · '.__('site.brand')" noindex>
    <x-ui.page-hero :eyebrow="__('newsletter.eyebrow')" :title="__('newsletter.unsubscribe_invalid.title')" :lead="__('newsletter.unsubscribe_invalid.lead')">
        <x-slot:actions>
            <x-ui.button :href="'mailto:'.$shell->settings->email.'?subject='.rawurlencode(__('newsletter.unsubscribe_invalid.subject'))" icon-start="mail">{{ __('newsletter.unsubscribe_invalid.write') }}</x-ui.button>
        </x-slot:actions>
    </x-ui.page-hero>
</x-layouts.site>
