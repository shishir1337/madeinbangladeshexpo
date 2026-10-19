@inject('shell', 'App\View\SiteShell')

{{-- One fixed place for help on every page (WCAG 3.2.6). The footer reserves space below it on phones, so it never covers content. --}}
<a
    href="{{ $shell->whatsappUrl() }}"
    target="_blank"
    rel="noopener"
    class="group fixed right-[max(1rem,env(safe-area-inset-right))] bottom-[max(1rem,env(safe-area-inset-bottom))] z-30 inline-flex h-14 items-center gap-2 rounded-full bg-green pr-5 pl-4 text-white shadow-lift ring-1 ring-white/10 transition duration-300 hover:-translate-y-0.5 hover:bg-green-700 max-sm:w-14 max-sm:justify-center max-sm:p-0"
>
    <x-ui.icon name="whatsapp" class="size-6" />
    <span class="text-sm font-semibold max-sm:sr-only">{{ __('site.footer.whatsapp') }}</span>
    <span class="sr-only">: {{ __('site.help.whatsapp_label') }}</span>
</a>
