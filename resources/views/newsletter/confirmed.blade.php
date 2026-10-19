<x-layouts.site :title="__('newsletter.confirmed.title').' · '.__('site.brand')">
    <x-ui.page-hero :eyebrow="__('newsletter.eyebrow')" :title="__('newsletter.confirmed.title')" :lead="__('newsletter.confirmed.lead')">
        <x-slot:actions>
            <x-ui.button :href="localized_route('home')" icon="arrow-right">{{ __('newsletter.back_home') }}</x-ui.button>
        </x-slot:actions>
    </x-ui.page-hero>
</x-layouts.site>
