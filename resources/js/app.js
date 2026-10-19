import { Alpine, Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';
import { startMotion, stopMotion } from './motion';
import { motionAllowed, setMotionPreference } from './preferences';
import { registerShell } from './shell';
import { registerComponents } from './components';

window.mbe = {
    motionAllowed,
    setMotionPreference(reduced) {
        setMotionPreference(reduced);
        reduced ? stopMotion() : startMotion();
    },
};

registerShell(Alpine);
registerComponents(Alpine);

Livewire.start();

function initMotion() {
    const allowed = motionAllowed();

    document.documentElement.dataset.motion = allowed ? 'full' : 'reduced';

    if (allowed) {
        startMotion();
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMotion, { once: true });
} else {
    initMotion();
}
