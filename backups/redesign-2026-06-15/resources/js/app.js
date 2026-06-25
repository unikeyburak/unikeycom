import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Blog slider - anasayfa kayan yazilar
window.blogSlider = function () {
    return {
        currentSlide: 0,
        slideWidth: 100,
        maxSlide: 0,
        init() {
            this.calcSlides();
            window.addEventListener('resize', () => this.calcSlides());
        },
        calcSlides() {
            const w = window.innerWidth;
            let perView = 1;
            if (w >= 1024) perView = 4;
            else if (w >= 640) perView = 2;
            const totalItems = this.$el.querySelectorAll('.flex-shrink-0').length;
            this.slideWidth = 100 / perView;
            this.maxSlide = Math.max(0, totalItems - perView);
            if (this.currentSlide > this.maxSlide) this.currentSlide = this.maxSlide;
        },
        next() {
            if (this.currentSlide < this.maxSlide) this.currentSlide++;
        },
        prev() {
            if (this.currentSlide > 0) this.currentSlide--;
        }
    };
};

Alpine.start();

const initHeroSlider = () => {
    const slider = document.querySelector('[data-hero-slider]');
    if (!slider) {
        return;
    }

    slider.classList.add('hero-slider--ready');
    const slides = Array.from(slider.querySelectorAll('[data-hero-slide]'));
    if (slides.length === 0) {
        return;
    }

    const dots = Array.from(slider.querySelectorAll('[data-hero-dot]'));
    const prevButton = slider.querySelector('[data-hero-prev]');
    const nextButton = slider.querySelector('[data-hero-next]');
    const navItems = Array.from(slider.querySelectorAll('[data-hero-nav]'));
    const autoplayMs = Number.parseInt(slider.dataset.autoplay ?? '0', 10);
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let currentIndex = 0;
    let timerId = null;

    const resetLayers = (slide) => {
        const layers = Array.from(slide.querySelectorAll('[data-hero-layer]'));
        layers.forEach((layer) => {
            const target = layer.querySelector('[data-hero-layer-content]') ?? layer;
            target.style.animation = 'none';
            target.style.opacity = '0';
        });
    };

    const animateLayers = (slide) => {
        const layers = Array.from(slide.querySelectorAll('[data-hero-layer]'));

        layers.forEach((layer) => {
            const animation = layer.dataset.heroAnim ?? 'fade';
            const delay = Number.parseInt(layer.dataset.heroDelay ?? '0', 10);
            const duration = Number.parseInt(layer.dataset.heroDuration ?? '700', 10);
            const target = layer.querySelector('[data-hero-layer-content]') ?? layer;

            target.style.animation = 'none';
            target.style.opacity = '0';

            if (prefersReducedMotion || animation === 'none') {
                target.style.opacity = '1';
                return;
            }

            const animationName = `hero-${animation}`;
            void target.offsetWidth;
            target.style.animation = `${animationName} ${duration}ms ease ${delay}ms both`;
        });
    };

    const setActiveSlide = (nextIndex) => {
        currentIndex = (nextIndex + slides.length) % slides.length;

        slides.forEach((slide, index) => {
            const isActive = index === currentIndex;
            slide.classList.toggle('opacity-100', isActive);
            slide.classList.toggle('opacity-0', !isActive);
            slide.classList.toggle('pointer-events-none', !isActive);
            slide.classList.toggle('z-10', isActive);
            slide.classList.toggle('z-0', !isActive);
        });

        dots.forEach((dot, index) => {
            const isActive = index === currentIndex;
            dot.classList.toggle('bg-white', isActive);
            dot.classList.toggle('bg-white/40', !isActive);
            dot.setAttribute('aria-current', isActive ? 'true' : 'false');
        });

        slides.forEach(resetLayers);
        animateLayers(slides[currentIndex]);
    };

    const stopAutoplay = () => {
        if (timerId) {
            window.clearInterval(timerId);
            timerId = null;
        }
    };

    const startAutoplay = () => {
        if (prefersReducedMotion || autoplayMs <= 0 || slides.length <= 1) {
            return;
        }

        stopAutoplay();
        timerId = window.setInterval(() => {
            setActiveSlide(currentIndex + 1);
        }, autoplayMs);
    };

    prevButton?.addEventListener('click', () => {
        stopAutoplay();
        setActiveSlide(currentIndex - 1);
        startAutoplay();
    });

    nextButton?.addEventListener('click', () => {
        stopAutoplay();
        setActiveSlide(currentIndex + 1);
        startAutoplay();
    });

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            const index = Number.parseInt(dot.dataset.heroDot ?? '0', 10);
            stopAutoplay();
            setActiveSlide(index);
            startAutoplay();
        });
    });

    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);

    if (slides.length <= 1) {
        navItems.forEach((item) => item.classList.add('hidden'));
    }

    setActiveSlide(0);
    startAutoplay();
};

const initMegaMenu = () => {
    const menu = document.querySelector('[data-mega-menu]');
    if (!menu) {
        return;
    }

    const triggers = Array.from(menu.querySelectorAll('[data-mega-trigger]'));
    const panels = Array.from(menu.querySelectorAll('[data-mega-panel]'));
    const promos = Array.from(menu.querySelectorAll('[data-mega-promos]'));

    if (triggers.length === 0 || panels.length === 0) {
        return;
    }

    const setActive = (categoryId) => {
        triggers.forEach((trigger) => {
            const isActive = trigger.dataset.categoryId === categoryId;
            trigger.classList.toggle('text-green-700', isActive);
            trigger.classList.toggle('bg-green-50', isActive);
            trigger.setAttribute('aria-current', isActive ? 'true' : 'false');
        });

        panels.forEach((panel) => {
            panel.classList.toggle('hidden', panel.dataset.categoryId !== categoryId);
        });

        promos.forEach((panel) => {
            panel.classList.toggle('hidden', panel.dataset.categoryId !== categoryId);
        });
    };

    const defaultTrigger = triggers[0];
    if (defaultTrigger?.dataset.categoryId) {
        setActive(defaultTrigger.dataset.categoryId);
    }

    triggers.forEach((trigger) => {
        const categoryId = trigger.dataset.categoryId;
        if (!categoryId) {
            return;
        }

        trigger.addEventListener('mouseenter', () => setActive(categoryId));
        trigger.addEventListener('focus', () => setActive(categoryId));
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initHeroSlider();
    initMegaMenu();
});
