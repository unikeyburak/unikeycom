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

// Tam ekran mega kategori paneli (Claude Design görünümü)
const initMegaOverlay = () => {
    const mega = document.getElementById('mega');
    const btn = document.querySelector('[data-mega-btn]');
    if (!mega || !btn) {
        return;
    }

    const chev = btn.querySelector('[data-mega-chev]');
    const catBtns = Array.from(mega.querySelectorAll('[data-mega-cat]'));
    const panels = Array.from(mega.querySelectorAll('[data-mega-panel]'));
    const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const activeOn = ['active', 'bg-leaf-600', 'text-white'];
    const activeOff = ['text-ink', 'hover:bg-leaf-500/10'];

    const activate = (key, animate) => {
        catBtns.forEach((b) => {
            const on = b.dataset.megaCat === key;
            b.classList.toggle('active', on);
            b.classList.toggle('bg-leaf-600', on);
            b.classList.toggle('text-white', on);
            b.classList.toggle('text-ink', !on);
            b.classList.toggle('hover:bg-leaf-500/10', !on);
            b.setAttribute('aria-selected', on ? 'true' : 'false');
        });

        panels.forEach((p) => {
            const on = p.dataset.megaPanel === key;
            p.hidden = !on;
            if (on && animate && !reduce) {
                const items = p.querySelectorAll('.reveal-item');
                items.forEach((it) => {
                    it.style.transition = 'none';
                    it.style.opacity = '0';
                    it.style.transform = 'translateX(-44px)';
                });
                void p.offsetWidth; // reflow
                items.forEach((it, i) => {
                    it.style.transition = 'opacity .42s ease, transform .42s cubic-bezier(.2,.7,.2,1)';
                    it.style.transitionDelay = (i * 70) + 'ms';
                    it.style.opacity = '1';
                    it.style.transform = 'none';
                });
            } else if (on) {
                p.querySelectorAll('.reveal-item').forEach((it) => { it.style.opacity = '1'; it.style.transform = 'none'; });
            }
        });
    };

    const firstKey = catBtns[0]?.dataset.megaCat;
    let activeKey = firstKey;

    const openMega = () => {
        mega.classList.add('open');
        mega.setAttribute('aria-hidden', 'false');
        btn.setAttribute('aria-expanded', 'true');
        if (chev) chev.style.transform = 'rotate(180deg)';
        document.body.style.overflow = 'hidden';
        activate(activeKey, true);
    };
    const closeMega = () => {
        mega.classList.remove('open');
        mega.setAttribute('aria-hidden', 'true');
        btn.setAttribute('aria-expanded', 'false');
        if (chev) chev.style.transform = '';
        document.body.style.overflow = '';
    };

    btn.addEventListener('click', (e) => {
        e.preventDefault();
        mega.classList.contains('open') ? closeMega() : openMega();
    });
    catBtns.forEach((b) => {
        const key = b.dataset.megaCat;
        const set = () => { activeKey = key; activate(key, true); };
        b.addEventListener('mouseenter', set);
        b.addEventListener('click', set);
        b.addEventListener('focus', set);
    });
    mega.querySelectorAll('[data-mega-close]').forEach((el) => el.addEventListener('click', closeMega));
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mega.classList.contains('open')) closeMega();
    });

    if (activeKey) activate(activeKey, false);
};

// Scroll-reveal (.sr/.sr-l/.sr-r) + sayaç animasyonu ([data-count])
const initScrollReveal = () => {
    const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const fmt = (n) => n.toLocaleString('tr-TR');
    let reveal = Array.from(document.querySelectorAll('.sr, .sr-l, .sr-r'));
    let stats = Array.from(document.querySelectorAll('[data-count]'));

    if (reveal.length === 0 && stats.length === 0) {
        return;
    }

    if (reduce) {
        reveal.forEach((el) => el.classList.add('in'));
        stats.forEach((el) => { el.textContent = fmt(parseFloat(el.getAttribute('data-count'))) + (el.getAttribute('data-suffix') || ''); });
        return;
    }

    const inView = (el, margin) => {
        const r = el.getBoundingClientRect();
        const h = window.innerHeight || document.documentElement.clientHeight;
        return r.top < h - (margin || 0) && r.bottom > 0;
    };

    const runCount = (el) => {
        if (el.__counted) return;
        el.__counted = true;
        const target = parseFloat(el.getAttribute('data-count'));
        const suffix = el.getAttribute('data-suffix') || '';
        const steps = 45;
        let i = 0;
        const iv = setInterval(() => {
            i++;
            const p = i / steps, eased = 1 - Math.pow(1 - p, 3);
            el.textContent = fmt(Math.round(target * eased)) + suffix;
            if (i >= steps) { clearInterval(iv); el.textContent = fmt(target) + suffix; }
        }, 32);
    };

    let ticking = false;
    const check = () => {
        ticking = false;
        reveal = reveal.filter((el) => { if (inView(el, 60)) { el.classList.add('in'); return false; } return true; });
        stats = stats.filter((el) => { if (inView(el, 40)) { runCount(el); return false; } return true; });
    };
    const onScroll = () => { if (!ticking) { ticking = true; requestAnimationFrame(check); } };

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
    window.addEventListener('load', check);
    check();
    setTimeout(check, 250);
};

// Hafif paralaks ([data-plx])
const initParallax = () => {
    const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const plx = Array.from(document.querySelectorAll('[data-plx]'));
    if (reduce || plx.length === 0) {
        return;
    }
    let ticking = false;
    const pcheck = () => {
        ticking = false;
        const vh = window.innerHeight || document.documentElement.clientHeight;
        plx.forEach((el) => {
            const r = el.getBoundingClientRect();
            if (r.bottom < -100 || r.top > vh + 100) return;
            const f = parseFloat(el.getAttribute('data-plx')) || 0.06;
            let off = ((r.top + r.height / 2) - vh / 2) * f;
            off = Math.max(-30, Math.min(30, off));
            el.style.transform = 'translateY(' + (-off).toFixed(1) + 'px)';
        });
    };
    window.addEventListener('scroll', () => { if (!ticking) { ticking = true; requestAnimationFrame(pcheck); } }, { passive: true });
    pcheck();
};

// Gübre akışı granülleri ([data-pour])
const initPour = () => {
    const palette = ['#8a2a17', '#a33b1e', '#6b1f12', '#b5481f', '#5a160c', '#c2561f'];
    document.querySelectorAll('[data-pour]').forEach((pour) => {
        const N = 48;
        let html = '';
        for (let i = 0; i < N; i++) {
            const left = (46 + Math.random() * 52).toFixed(1);
            const size = (4 + Math.random() * 6).toFixed(1);
            const c = palette[i % palette.length];
            const d = (2.2 + Math.random() * 2).toFixed(2);
            const delay = (-Math.random() * 4.2).toFixed(2);
            const fall = (330 + Math.random() * 130).toFixed(0);
            html += '<span class="granule" style="left:' + left + '%;width:' + size + 'px;height:' + size + 'px;background:' + c + ';--d:' + d + 's;--delay:' + delay + 's;--fall:' + fall + 'px;box-shadow:0 1px 3px rgba(0,0,0,.4)"></span>';
        }
        pour.innerHTML = html;
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initHeroSlider();
    initMegaOverlay();
    initScrollReveal();
    initParallax();
    initPour();
});
