import { Alpine, Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';
import { motionAllowed, setMotionPreference } from './preferences';
import { registerShell } from './shell';

window.mbe = { motionAllowed, setMotionPreference };

registerShell(Alpine);

Livewire.start();

/**
 * GSAP, ScrollTrigger and Lenis load as a separate chunk after first paint, and only when motion is
 * allowed and the page has something to animate, keeping the initial JS inside the spec §5P budget.
 */
function loadMotion() {
    const allowed = motionAllowed();

    document.documentElement.dataset.motion = allowed ? 'full' : 'reduced';

    if (allowed && document.querySelector('[data-reveal], [data-count-to], body[data-smooth]')) {
        import('./motion').then(({ initMotion }) => initMotion());
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadMotion, { once: true });
} else {
    loadMotion();
}
