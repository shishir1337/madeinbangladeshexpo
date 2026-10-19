<x-layouts.site :title="__('newsletter.confirm.title').' · '.__('site.brand')" noindex>
    <x-ui.page-hero :eyebrow="__('newsletter.eyebrow')" :title="__('newsletter.confirm.title')" :lead="__('newsletter.confirm.lead')">
        <x-slot:actions>
            <form method="POST" action="{{ $action }}">
                @csrf
                <x-ui.button type="submit" icon="check">{{ __('newsletter.confirm.button') }}</x-ui.button>
            </form>
        </x-slot:actions>
    </x-ui.page-hero>
</x-layouts.site>
