/**
 * Alpine components for page content (the shell's components live in shell.js).
 */
function numberFormat(options = {}) {
    const lang = document.documentElement.lang || 'en';

    return new Intl.NumberFormat(lang === 'bn' ? 'bn-BD' : lang, { useGrouping: false, ...options });
}

export function registerComponents(Alpine) {
    /**
     * Counts down to an ISO instant, in the page's digits. Pauses when the tab is hidden and on request
     * (WCAG 2.2.2). The server renders the starting values, so it is correct before and without JS.
     */
    Alpine.data('countdown', (targetIso) => ({
        target: Date.parse(targetIso),
        parts: { days: '', hours: '', minutes: '', seconds: '' },
        paused: false,
        timer: null,

        init() {
            this.whole = numberFormat();
            this.twoDigits = numberFormat({ minimumIntegerDigits: 2 });
            this.tick();
            this.start();

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    this.stop();
                } else if (!this.paused) {
                    this.tick();
                    this.start();
                }
            });
        },

        tick() {
            const seconds = Math.max(0, Math.floor((this.target - Date.now()) / 1000));

            this.parts = {
                days: this.whole.format(Math.floor(seconds / 86400)),
                hours: this.twoDigits.format(Math.floor((seconds % 86400) / 3600)),
                minutes: this.twoDigits.format(Math.floor((seconds % 3600) / 60)),
                seconds: this.twoDigits.format(seconds % 60),
            };

            if (seconds === 0) {
                this.stop();
            }
        },

        start() {
            this.stop();
            this.timer = window.setInterval(() => this.tick(), 1000);
        },

        stop() {
            window.clearInterval(this.timer);
        },

        toggle() {
            this.paused = !this.paused;
            this.paused ? this.stop() : (this.tick(), this.start());
        },
    }));

    /**
     * A live HH:MM clock for a time zone, plus whether it is office hours there (09:00–18:00 outside the
     * weekend; Bangladesh's weekend is Friday and Saturday).
     */
    Alpine.data('clock', (timeZone, weekend = timeZone === 'Asia/Dhaka' ? ['Fri', 'Sat'] : ['Sat', 'Sun']) => ({
        time: '',
        open: false,

        init() {
            const lang = document.documentElement.lang || 'en';
            this.formatter = new Intl.DateTimeFormat(lang === 'bn' ? 'bn-BD' : lang, { hour: '2-digit', minute: '2-digit', hourCycle: 'h23', timeZone });
            this.parts = new Intl.DateTimeFormat('en-GB', { hour: 'numeric', hourCycle: 'h23', weekday: 'short', timeZone });
            this.update();
            window.setInterval(() => this.update(), 15000);
        },

        update() {
            const now = new Date();
            const parts = Object.fromEntries(this.parts.formatToParts(now).map((part) => [part.type, part.value]));
            const hour = Number(parts.hour);

            this.time = this.formatter.format(now);
            this.open = !weekend.includes(parts.weekday) && hour >= 9 && hour < 18;
        },
    }));

    /**
     * A YouTube video in a modal <dialog>. The iframe is created only after the visitor presses play.
     */
    Alpine.data('videoDialog', (youtubeId) => ({
        open() {
            const iframe = document.createElement('iframe');

            iframe.src = `https://www.youtube-nocookie.com/embed/${encodeURIComponent(youtubeId)}?autoplay=1&rel=0`;
            iframe.title = this.$refs.dialog.getAttribute('aria-label');
            iframe.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen';
            iframe.allowFullscreen = true;
            iframe.className = 'size-full';

            this.$refs.frame.replaceChildren(iframe);
            this.$refs.dialog.showModal();
        },

        stop() {
            this.$refs.frame.replaceChildren();
        },
    }));

    /**
     * A photo lightbox in a native modal <dialog> (focus stays inside, Esc closes): ←/→ keys, swipe, caption and
     * a counter in the page's digits. Focus returns to the thumbnail that opened it.
     */
    Alpine.data('lightbox', (photos, counterTemplate) => ({
        photos,
        index: 0,
        opener: null,
        touchX: null,

        get current() {
            return this.photos[this.index];
        },

        get counter() {
            const lang = document.documentElement.lang || 'en';
            const number = new Intl.NumberFormat(lang === 'bn' ? 'bn-BD' : lang);

            return counterTemplate.replace(':current', number.format(this.index + 1)).replace(':total', number.format(this.photos.length));
        },

        open(index, event) {
            this.index = index;
            this.opener = event?.currentTarget ?? null;
            this.$refs.dialog.showModal();
        },

        close() {
            this.$refs.dialog.close();
        },

        closed() {
            this.opener?.focus();
        },

        step(by) {
            this.index = (this.index + by + this.photos.length) % this.photos.length;
        },

        touchStart(event) {
            this.touchX = event.changedTouches[0].clientX;
        },

        touchEnd(event) {
            if (this.touchX === null) {
                return;
            }

            const distance = event.changedTouches[0].clientX - this.touchX;
            this.touchX = null;

            if (Math.abs(distance) > 48) {
                this.step(distance < 0 ? 1 : -1);
            }
        },
    }));

    /**
     * An inline YouTube facade: swaps itself for the player on click.
     */
    Alpine.data('youtubeFacade', (youtubeId, title) => ({
        playing: false,

        play() {
            const iframe = document.createElement('iframe');

            iframe.src = `https://www.youtube-nocookie.com/embed/${encodeURIComponent(youtubeId)}?autoplay=1&rel=0`;
            iframe.title = title;
            iframe.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen';
            iframe.allowFullscreen = true;
            iframe.className = 'absolute inset-0 size-full';

            this.$refs.player.replaceChildren(iframe);
            this.playing = true;
        },
    }));

    /**
     * A horizontal scroll-snap track with previous/next buttons; no scroll-jacking.
     */
    Alpine.data('scroller', () => ({
        atStart: true,
        atEnd: false,

        init() {
            this.update();
            this.$refs.track.addEventListener('scroll', () => this.update(), { passive: true });
            window.addEventListener('resize', () => this.update(), { passive: true });
        },

        update() {
            const track = this.$refs.track;
            const isRtl = getComputedStyle(track).direction === 'rtl';
            const position = Math.abs(track.scrollLeft);

            this.atStart = position <= 4;
            this.atEnd = position + track.clientWidth >= track.scrollWidth - 4;

            if (isRtl) {
                [this.atStart, this.atEnd] = [this.atEnd, this.atStart];
            }
        },

        scrollBy(direction) {
            const track = this.$refs.track;
            const reduced = document.documentElement.dataset.motion === 'reduced';

            track.scrollBy({ left: direction * track.clientWidth * 0.8, behavior: reduced ? 'auto' : 'smooth' });
        },
    }));
}
