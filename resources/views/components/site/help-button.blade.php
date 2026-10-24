@inject('shell', 'App\View\SiteShell')

{{--
    One fixed place for help on every page (WCAG 3.2.6). It steps aside while a [data-hides-help] area is on screen:
    the hero (big calls to action of its own) and the footer (which lists WhatsApp itself). Without JavaScript it
    always shows, and the footer reserves room below it.
--}}
<a
    x-data="helpButton"
    href="{{ $shell->whatsappUrl() }}"
    target="_blank"
    rel="noopener"
    x-bind:inert="hidden"
    x-bind:class="hidden && 'translate-y-4 opacity-0 pointer-events-none'"
    class="group fixed right-[max(1rem,env(safe-area-inset-right))] bottom-[max(1rem,env(safe-area-inset-bottom))] z-30 inline-flex h-14 items-center gap-2 rounded-full bg-green pr-5 pl-4 text-white shadow-lift ring-1 ring-white/10 transition duration-300 hover:-translate-y-0.5 hover:bg-green-700 max-sm:w-14 max-sm:justify-center max-sm:p-0"
>
    <x-ui.icon name="whatsapp" class="size-6" />
    <span class="text-sm font-semibold max-sm:sr-only">{{ __('site.footer.whatsapp') }}</span>
    <span class="sr-only">: {{ __('site.help.whatsapp_label') }}</span>
</a>
