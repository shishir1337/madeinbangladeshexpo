/**
 * Alpine components for the site shell. Registered before Livewire starts Alpine.
 */
export function registerShell(Alpine) {
    Alpine.data('motionToggle', () => ({
        reduced: document.documentElement.dataset.motion === 'reduced',
        toggle() {
            window.mbe.setMotionPreference(!this.reduced);
        },
    }));
}
