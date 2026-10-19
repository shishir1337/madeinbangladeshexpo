/**
 * Scroll reveals, count-ups, route drawing, slideshows and off-screen pausing, with IntersectionObserver and the
 * Web Animations API: no animation library and no scroll hijacking. Only transform and opacity animate. Content
 * is never hidden without JS, with reduced motion, on first paint (only below-the-fold elements wait) or in print.
 */
const EASE_OUT = 'cubic-bezier(0.22, 1, 0.36, 1)';
const STAGGER = 0.075;
const MAX_STAGGER = 0.45;

const FROM = {
    up: 'translate3d(0, 34px, 0)',
    left: 'translate3d(44px, 0, 0)',
    right: 'translate3d(-44px, 0, 0)',
    scale: 'scale(0.94)',
    zoom: 'scale(1.14)',
    fade: 'none',
};

let observers = [];
let timers = [];

function isInViewport(element) {
    const rect = element.getBoundingClientRect();

    return rect.top < window.innerHeight && rect.bottom > 0;
}

function observe(callback, options) {
    const observer = new IntersectionObserver(callback, options);

    observers.push(observer);

    return observer;
}

/**
 * Elements that enter together are revealed one after another in document order (like a batch), so a row of
 * cards cascades while a card that scrolls in alone never waits for its neighbours.
 */
function initReveals() {
    const elements = [...document.querySelectorAll('[data-reveal]')].filter((element) => !isInViewport(element));

    if (elements.length === 0) {
        return;
    }

    const observer = observe(
        (entries) => {
            const entering = entries
                .filter((entry) => entry.isIntersecting)
                .map((entry) => entry.target)
                .sort((a, b) => (a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING ? -1 : 1));

            entering.forEach((element, index) => {
                observer.unobserve(element);
                element.classList.remove('reveal-pending');

                const kind = element.dataset.reveal || 'up';
                const delay = element.dataset.revealDelay !== undefined ? Number(element.dataset.revealDelay) : Math.min(index * STAGGER, MAX_STAGGER);

                element.animate([{ opacity: kind === 'zoom' ? 1 : 0, transform: FROM[kind] ?? FROM.up }, { opacity: 1, transform: 'none' }], {
                    duration: kind === 'zoom' ? 1400 : 950,
                    delay: delay * 1000,
                    easing: EASE_OUT,
                    fill: 'backwards',
                });
            });
        },
        { rootMargin: '0px 0px -6% 0px', threshold: 0.01 },
    );

    elements.forEach((element) => {
        if (element.dataset.reveal !== 'zoom') {
            element.classList.add('reveal-pending');
        }

        observer.observe(element);
    });
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

    const observer = observe(
        (entries) => {
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
                    const progress = Math.min(1, (now - started) / 1800);
                    const eased = 1 - Math.pow(1 - progress, 4);

                    element.textContent = progress < 1 ? formatter.format(target * eased) : finalText;

                    if (progress < 1) {
                        requestAnimationFrame(step);
                    }
                };

                requestAnimationFrame(step);
            });
        },
        { rootMargin: '0px 0px -8% 0px' },
    );

    elements.forEach((element) => observer.observe(element));
}

/**
 * [data-draw] figures: each .route-draw path learns its length, then draws once the figure is in view.
 */
function initRouteDrawing() {
    const figures = document.querySelectorAll('[data-draw]');

    figures.forEach((figure) => {
        figure.querySelectorAll('.route-draw').forEach((path) => {
            path.style.setProperty('--len', Math.ceil(path.getTotalLength()));
        });
    });

    const observer = observe(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-drawn');
                    observer.unobserve(entry.target);

                    // Travellers set off once their route has been drawn.
                    timers.push(window.setTimeout(() => entry.target.querySelectorAll('animateMotion').forEach((motion) => motion.beginElement?.()), 2400));
                }
            });
        },
        { rootMargin: '0px 0px -15% 0px' },
    );

    figures.forEach((figure) => observer.observe(figure));
}

/**
 * [data-slideshow]: cross-fades its [data-slide] children every few seconds while it is on screen and the tab
 * is visible.
 */
function initSlideshows() {
    document.querySelectorAll('[data-slideshow]').forEach((slideshow) => {
        const slides = [...slideshow.querySelectorAll('[data-slide]')];
        const interval = Number(slideshow.dataset.slideshow) || 6500;
        let index = Math.max(0, slides.findIndex((slide) => slide.hasAttribute('data-active')));
        let visible = true;

        if (slides.length < 2) {
            return;
        }

        const timer = window.setInterval(() => {
            if (!visible || document.hidden) {
                return;
            }

            slides[index].removeAttribute('data-active');
            index = (index + 1) % slides.length;
            slides[index].setAttribute('data-active', '');
            slideshow.dispatchEvent(new CustomEvent('slide', { detail: { index } }));
        }, interval);

        timers.push(timer);

        observe((entries) => {
            visible = entries[0].isIntersecting;
        }).observe(slideshow);
    });
}

/**
 * [data-pause-offscreen]: continuous animations inside (marquees, slow zooms) stop while off screen.
 */
function initOffscreenPausing() {
    const elements = document.querySelectorAll('[data-pause-offscreen]');

    const observer = observe((entries) => {
        entries.forEach((entry) => entry.target.classList.toggle('is-offscreen', !entry.isIntersecting));
    });

    elements.forEach((element) => observer.observe(element));
}

export function startMotion() {
    document.documentElement.classList.add('motion-ready');
    initReveals();
    initCounters();
    initRouteDrawing();
    initSlideshows();
    initOffscreenPausing();
}

/**
 * Stops everything at once (the visitor switched to reduced motion): pending reveals show immediately.
 */
export function stopMotion() {
    observers.forEach((observer) => observer.disconnect());
    observers = [];
    timers.forEach((timer) => window.clearInterval(timer));
    timers = [];
    document.querySelectorAll('animateMotion').forEach((motion) => motion.endElement?.());
    document.documentElement.classList.remove('motion-ready');
    document.querySelectorAll('.reveal-pending').forEach((element) => element.classList.remove('reveal-pending'));
}
