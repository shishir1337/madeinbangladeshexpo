@if (config('expo.demo_mode'))
    <div role="note" class="demo-ribbon relative z-[60] bg-crimson px-4 py-1.5 text-center text-xs font-semibold tracking-wide text-white">
        <span class="inline-flex items-center gap-1.5">
            <x-ui.icon name="info" class="size-3.5" />
            {{ __('site.demo_ribbon') }}
        </span>
    </div>
@endif
