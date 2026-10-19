<x-layouts.site :title="__('newsletter.unsubscribed.title').' · '.__('site.brand')">
    <x-ui.page-hero :eyebrow="__('newsletter.eyebrow')" :title="__('newsletter.unsubscribed.title')" :lead="__('newsletter.unsubscribed.lead')">
        <x-slot:actions>
            <x-ui.button :href="localized_route('home')" variant="secondary">{{ __('newsletter.back_home') }}</x-ui.button>
        </x-slot:actions>
    </x-ui.page-hero>
</x-layouts.site>
