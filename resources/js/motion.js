/**
 * Scroll reveals and count-up numbers with IntersectionObserver and the Web Animations API: no animation
 * library, so pages stay inside the spec §5P JS budget. Content is never hidden without JS, with reduced
 * motion, on first paint (only below-the-fold elements wait) or in print.
 */
const EASE_OUT_EXPO = 'cubic-bezier(0.16, 1, 0.3, 1)';

let observers = [];

function isInViewport(element) {
    const rect = element.getBoundingClientRect();

    return rect.top < window.innerHeight && rect.bottom > 0;
}

function revealFrom(kind) {
    if (kind === 'scale') {
        return 'scale(0.97)';
    }

    return kind === 'fade' ? 'none' : 'translate3d(0, 22px, 0)';
}

function initReveals() {
    const elements = [...document.querySelectorAll('[data-reveal]')].filter((element) => !isInViewport(element));

    if (elements.length === 0) {
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const element = entry.target;

                observer.unobserve(element);
                element.classList.remove('reveal-pending');
                element.animate([{ opacity: 0, transform: revealFrom(element.dataset.reveal) }, { opacity: 1, transform: 'none' }], {
                    duration: 900,
                    delay: Number(element.dataset.revealDelay ?? 0) * 1000,
                    easing: EASE_OUT_EXPO,
                    fill: 'backwards',
                });
            });
        },
        { rootMargin: '0px 0px -10% 0px' },
    );

    elements.forEach((element) => {
        element.classList.add('reveal-pending');
        observer.observe(element);
    });

    observers.push(observer);
}

/**
 * Counters keep their server-rendered final value; with motion they count up once, in the page's digits
 * (Bangla numerals and lakh grouping on /bn).
 */
function initCounters() {
    const lang = document.documentElement.lang || 'en';
    const elements = document.querySelectorAll('[data-count-to]');

    if (elements.length === 0) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            const element = entry.target;
            const target = Number(element.dataset.countTo);
            const decimals = Number(element.dataset.countDecimals ?? 0);
            const formatter = new Intl.NumberFormat(lang === 'bn' ? 'bn-BD' : lang, { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
            const finalText = element.textContent;
            const started = performance.now();

            observer.unobserve(element);

            const step = (now) => {
                const progress = Math.min(1, (now - started) / 1600);
                const eased = 1 - Math.pow(1 - progress, 3);

                element.textContent = progress < 1 ? formatter.format(target * eased) : finalText;

                if (progress < 1) {
                    requestAnimationFrame(step);
                }
            };

            requestAnimationFrame(step);
        });
    }, { rootMargin: '0px 0px -8% 0px' });

    elements.forEach((element) => observer.observe(element));
    observers.push(observer);
}

async function initSmoothScroll() {
    if (!document.body.hasAttribute('data-smooth') || window.lenis) {
        return;
    }

    const { default: Lenis } = await import('lenis');
    const lenis = new Lenis({ lerp: 0.12, wheelMultiplier: 0.9, autoRaf: true });

    window.lenis = lenis;
}

export function startMotion() {
    initReveals();
    initCounters();
    initSmoothScroll();
}

/**
 * Stops everything at once (the visitor switched to reduced motion): pending reveals show immediately.
 */
export function stopMotion() {
    observers.forEach((observer) => observer.disconnect());
    observers = [];
    document.querySelectorAll('.reveal-pending').forEach((element) => element.classList.remove('reveal-pending'));
    window.lenis?.destroy();
    window.lenis = undefined;
}
