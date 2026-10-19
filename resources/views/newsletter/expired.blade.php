<x-layouts.site :title="__('newsletter.expired.title').' · '.__('site.brand')" noindex>
    <x-ui.page-hero :eyebrow="__('newsletter.eyebrow')" :title="__('newsletter.expired.title')" :lead="__('newsletter.expired.lead')">
        <x-slot:actions>
            <x-ui.button :href="localized_route('home').'#updates'" icon="arrow-right">{{ __('newsletter.expired.again') }}</x-ui.button>
        </x-slot:actions>
    </x-ui.page-hero>
</x-layouts.site>
