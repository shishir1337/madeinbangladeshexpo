@php($sectors = $page->sectors())

{{-- The sectors on a moving tape. Screen readers get the list once; the looping copy is hidden from them. --}}
@if ($sectors->isNotEmpty())
    <div class="relative overflow-hidden border-y border-navy/10 bg-yellow py-3.5 text-navy md:py-4">
        <div class="flex w-max animate-marquee [--marquee-duration:46s] hover:[animation-play-state:paused]">
            @foreach ([false, true] as $copy)
                <ul class="flex shrink-0 items-center" @if ($copy) aria-hidden="true" @else aria-label="{{ __('home.sectors.title') }}" @endif>
                    @foreach ($sectors as $sector)
                        <li class="flex items-center gap-6 pr-6 font-display text-[clamp(1.05rem,0.9rem+0.6vw,1.45rem)] font-semibold whitespace-nowrap uppercase md:gap-8 md:pr-8 lg:tracking-wide">
                            <span>{{ $sector->name }}</span>
                            <span class="flex -space-x-1.5" aria-hidden="true"><span class="size-3 rounded-full bg-sun"></span><span class="size-3 rounded-full bg-globe mix-blend-multiply"></span></span>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
@endif
