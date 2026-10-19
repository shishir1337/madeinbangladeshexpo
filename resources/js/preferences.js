const STORAGE_KEY = 'mbe.motion';

function readPreference() {
    try {
        return window.localStorage.getItem(STORAGE_KEY);
    } catch {
        return null;
    }
}

/**
 * Motion is allowed unless the visitor chose "reduce" in the footer, or the OS asks for reduced motion
 * and the visitor has not explicitly opted back in.
 */
export function motionAllowed() {
    const preference = readPreference();

    if (preference === 'reduced') {
        return false;
    }

    if (preference === 'full') {
        return true;
    }

    return !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

/**
 * Stores the visitor's choice and applies it at once, without reloading the page.
 */
export function setMotionPreference(reduced) {
    try {
        window.localStorage.setItem(STORAGE_KEY, reduced ? 'reduced' : 'full');
    } catch {
        // Storage can be blocked; the preference then lasts for this page only.
    }

    document.documentElement.dataset.motion = reduced ? 'reduced' : 'full';
}
