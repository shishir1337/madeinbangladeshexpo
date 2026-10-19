import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

function isInViewport(element) {
    const rect = element.getBoundingClientRect();

    return rect.top < window.innerHeight && rect.bottom > 0;
}

function initReveals() {
    const elements = gsap.utils.toArray('[data-reveal]').filter((element) => !isInViewport(element));

    elements.forEach((element) => {
        const kind = element.dataset.reveal;
        const from = { opacity: 0, y: kind === 'fade' || kind === 'scale' ? 0 : 22, scale: kind === 'scale' ? 0.97 : 1 };

        gsap.set(element, from);

        ScrollTrigger.create({
            trigger: element,
            start: 'top 88%',
            once: true,
            onEnter: () => {
                gsap.to(element, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.9,
                    ease: 'expo.out',
                    delay: Number(element.dataset.revealDelay ?? 0),
                    clearProps: 'transform',
                });
            },
        });
    });
}

/**
 * Counters keep their server-rendered final value for no-JS and reduced motion; with motion they count
 * up once, formatted in the page language (Bangla digits and lakh grouping on /bn).
 */
function initCounters() {
    const locale = document.documentElement.lang || 'en';

    gsap.utils.toArray('[data-count-to]').forEach((element) => {
        const target = Number(element.dataset.countTo);
        const decimals = Number(element.dataset.countDecimals ?? 0);
        const formatter = new Intl.NumberFormat(locale === 'bn' ? 'bn-BD' : locale, {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals,
        });
        const state = { value: 0 };

        ScrollTrigger.create({
            trigger: element,
            start: 'top 92%',
            once: true,
            onEnter: () => {
                gsap.to(state, {
                    value: target,
                    duration: 1.6,
                    ease: 'power3.out',
                    onUpdate: () => {
                        element.textContent = formatter.format(state.value);
                    },
                });
            },
        });
    });
}

function initSmoothScroll() {
    if (!document.body.hasAttribute('data-smooth')) {
        return;
    }

    const lenis = new Lenis({ lerp: 0.12, wheelMultiplier: 0.9 });

    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => lenis.raf(time * 1000));
    gsap.ticker.lagSmoothing(0);
    window.lenis = lenis;
}

/**
 * Loaded on demand by app.js, only when motion is allowed and the page has something to animate.
 */
export function initMotion() {
    gsap.registerPlugin(ScrollTrigger);
    initSmoothScroll();
    initReveals();
    initCounters();
}
