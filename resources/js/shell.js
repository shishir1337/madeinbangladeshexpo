/**
 * Alpine components for the site shell. Registered before Livewire starts Alpine.
 */
export function registerShell(Alpine) {
    Alpine.data('siteHeader', () => ({
        open: null,
        drawer: false,
        scrolled: false,

        init() {
            const onScroll = () => {
                this.scrolled = window.scrollY > 24;
            };

            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });

            // Leaving the drawer open while resizing to desktop would leave the page inert.
            window.matchMedia('(min-width: 64rem)').addEventListener('change', (event) => {
                if (event.matches) {
                    this.drawer = false;
                }
            });
        },

        toggle(key) {
            this.open = this.open === key ? null : key;
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
        reduced: document.documentElement.dataset.motion === 'reduced',

        toggle() {
            window.mbe.setMotionPreference(!this.reduced);
        },
    }));
}
