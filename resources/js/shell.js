/**
 * Alpine components for the site shell. Registered before Livewire starts Alpine.
 */
export function registerShell(Alpine) {
    /**
     * `overlay`: the header starts transparent over a dark hero and turns solid after a short scroll.
     */
    Alpine.data('siteHeader', (overlay = false) => ({
        overlay,
        open: null,
        drawer: false,
        scrolled: false,

        init() {
            const onScroll = () => {
                const scrolled = window.scrollY > 24;

                if (scrolled !== this.scrolled) {
                    this.scrolled = scrolled;
                }
            };

            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });

            // Leaving the drawer open while resizing to desktop would leave the page inert.
            window.matchMedia('(min-width: 80rem)').addEventListener('change', (event) => {
                if (event.matches) {
                    this.drawer = false;
                }
            });
        },

        toggle(key) {
            this.open = this.open === key ? null : key;
        },

        openAndFocus(key) {
            this.open = key;
            this.$nextTick(() => document.querySelector(`#mega-${key} a`)?.focus());
        },

        closeAll(returnFocus = true) {
            if (this.open && returnFocus) {
                this.$refs[`trigger-${this.open}`]?.focus();
            }

            this.open = null;
        },

        openDrawer() {
            this.open = null;
            this.drawer = true;
        },

        closeDrawer() {
            this.drawer = false;
            this.$nextTick(() => this.$refs.drawerButton?.focus());
        },
    }));

    Alpine.data('announcement', (storageKey) => ({
        visible: true,

        init() {
            try {
                this.visible = window.localStorage.getItem(storageKey) !== 'dismissed';
            } catch {
                this.visible = true;
            }
        },

        dismiss() {
            this.visible = false;

            try {
                window.localStorage.setItem(storageKey, 'dismissed');
            } catch {
                // Storage blocked: the bar stays dismissed for this page view only.
            }
        },
    }));

    /**
     * The floating WhatsApp button hides while any [data-hides-help] area is on screen. The attribute's value is how
     * much of that area must show first: "0" hides it as soon as the footer peeks in, "0.5" while the hero fills
     * most of the screen.
     */
    Alpine.data('helpButton', () => ({
        hidden: false,
        showing: new Map(),

        init() {
            const areas = document.querySelectorAll('[data-hides-help]');

            if (areas.length === 0 || !('IntersectionObserver' in window)) {
                return;
            }

            const observer = new IntersectionObserver(
                (entries) => {
                    for (const entry of entries) {
                        const needed = Number(entry.target.dataset.hidesHelp || 0);
                        this.showing.set(entry.target, entry.isIntersecting && entry.intersectionRatio >= needed);
                    }

                    this.hidden = [...this.showing.values()].some(Boolean);
                },
                { threshold: [0, 0.25, 0.5, 0.75] },
            );

            areas.forEach((area) => observer.observe(area));
        },
    }));

    Alpine.data('tabs', (initial, keys) => ({
        active: initial,

        init() {
            // x-show now controls the panels; drop the pre-paint CSS hiding.
            this.$nextTick(() => {
                this.$el.querySelectorAll('[data-tab-hidden]').forEach((panel) => panel.removeAttribute('data-tab-hidden'));
            });
        },

        select(key) {
            this.active = key;
        },

        move(step) {
            const index = keys.indexOf(this.active);
            this.go((index + step + keys.length) % keys.length);
        },

        go(index) {
            const key = keys.at(index);
            this.select(key);
            this.$refs[`tab-${key}`]?.focus();
        },
    }));

    Alpine.data('motionToggle', () => ({
        reduced: !window.mbe.motionAllowed(),

        toggle() {
            this.reduced = !this.reduced;
            window.mbe.setMotionPreference(this.reduced);
        },
    }));
}
