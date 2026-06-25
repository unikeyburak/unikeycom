<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ request()->attributes->get('direction', 'ltr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $settings['site_name'] ?? config('app.name'))</title>

    @include('partials.seo-meta', [
        'meta' => $meta ?? [
            'title'       => $settings['site_name'] ?? config('app.name'),
            'description' => $settings['site_description'] ?? '',
            'keywords'    => $settings['site_keywords'] ?? '',
            'image'       => !empty($settings['site_og_image']) ? Storage::url($settings['site_og_image']) : asset('images/og-default.jpg'),
            'image_width'  => 1200,
            'image_height' => 630,
            'type'        => 'website',
            'url'         => request()->url(),
            'canonical'   => request()->url(),
        ],
        'schema' => $schema ?? null
    ])

    @if($settings['site_favicon'])
    <link rel="icon" type="image/x-icon" href="{{ Storage::url($settings['site_favicon']) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <link rel="preload" as="style"
          href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&family=Caveat:wght@600&display=swap"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&family=Caveat:wght@600&display=swap"></noscript>

    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" crossorigin="anonymous">
        {{-- JS tamamen kapalıysa: reveal-animasyonlu içerik gizli kalmasın --}}
        <style>.sr,.sr-l,.sr-r{opacity:1!important;transform:none!important}</style>
    </noscript>
</head>
<body class="bg-white font-sans text-ink antialiased @yield('body_class')"
      x-data="{ searchOpen: false, mobileMenuOpen: false }"
      @keydown.escape.window="searchOpen = false; mobileMenuOpen = false">

    @php
        $navHome     = request()->routeIs('home');
        $navProducts = request()->routeIs('*products.*');
        $navAbout    = request()->routeIs('*about') || request()->routeIs('*pages.*');
        $navContact  = request()->routeIs('*contact*');
    @endphp

    {{-- ARAMA OVERLAY (mockup arama butonu bunu açar) --}}
    <div x-cloak x-show="searchOpen"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-start justify-center px-4 pt-24" style="background:rgba(0,0,0,0.6);" @click.self="searchOpen = false">
        <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
            <form action="{{ lroute('products.search') }}" method="GET">
                <div class="flex items-center gap-3 px-5 py-4">
                    <svg class="h-6 w-6 flex-shrink-0 text-ink-soft" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" placeholder="{{ __('Ürün ara...') }}" class="flex-1 text-lg text-ink outline-none placeholder:text-ink-soft/70" x-ref="searchInput" x-init="$watch('searchOpen', v => v && $nextTick(() => $refs.searchInput.focus()))">
                    <button type="button" @click="searchOpen = false" class="text-ink-soft transition hover:text-ink"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="flex items-center justify-between border-t border-hair bg-leaf-50/40 px-5 py-3">
                    <span class="text-sm text-ink-soft">{{ __('Aramak için Enter\'a basın') }}</span>
                    <button type="submit" class="rounded-lg bg-leaf-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-leaf-700">{{ __('Ara') }}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- HEADER — Claude Design (harfiyen)                            --}}
    {{-- ============================================================ --}}
    <header class="bg-earth-600 text-white">
        {{-- üst yardımcı bar --}}
        <div class="bg-earth-700">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-2.5 text-[13px] font-semibold text-white/85">
                <span class="flex items-center gap-6">
                    <a href="{{ lroute('about') }}" class="inline-flex items-center gap-1 transition hover:text-white">{{ __('Kurumsal') }}</a>
                    <a href="{{ lroute('contact') }}" class="inline-flex items-center gap-1 transition hover:text-white">{{ __('İletişim') }}</a>
                </span>
                <span class="flex items-center gap-5">
                    @php
                        $socials = collect($settings['social_media'] ?? [])->filter(fn ($s) => is_array($s) && !empty($s['url']));
                        $igUrl = optional($socials->firstWhere('platform', 'instagram'))['url'] ?? null;
                    @endphp
                    @if($socials->isNotEmpty())
                    <span class="flex items-center gap-3">
                        @if($igUrl)
                            <a href="{{ $igUrl }}" target="_blank" rel="noopener" class="story-ring" aria-label="Instagram" title="Instagram"><span class="story-ring__avatar"><img src="{{ asset('images/leaf.png') }}" alt=""></span></a>
                        @endif
                        @foreach($socials as $s)
                            @continue(($s['platform'] ?? '') === 'instagram')
                            @php
                                $icon = match($s['platform'] ?? '') {
                                    'facebook'  => 'fa-facebook-f', 'twitter' => 'fa-x-twitter', 'x' => 'fa-x-twitter',
                                    'linkedin'  => 'fa-linkedin-in', 'youtube' => 'fa-youtube', 'whatsapp' => 'fa-whatsapp',
                                    'tiktok'    => 'fa-tiktok', 'telegram' => 'fa-telegram', default => 'fa-link',
                                };
                            @endphp
                            <a href="{{ $s['url'] }}" target="_blank" rel="noopener" class="transition hover:text-white" aria-label="{{ ucfirst($s['platform'] ?? 'social') }}"><i class="fa-brands {{ $icon }} text-[15px]"></i></a>
                        @endforeach
                    </span>
                    @endif
                    @php
                        $hdrLanguages = \Illuminate\Support\Facades\Cache::remember('active_languages', 3600, fn () => \App\Models\Language::getActive());
                        $hdrCurrent   = $hdrLanguages->firstWhere('code', app()->getLocale());
                    @endphp
                    @if($hdrLanguages->count() > 1)
                        <span class="relative" x-data="{ langOpen: false }">
                            <button @click="langOpen = !langOpen" @click.away="langOpen = false"
                                    class="inline-flex items-center gap-1.5 transition hover:text-white" aria-label="{{ __('Dil') }}">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20"/></svg>
                                <span>{{ $hdrCurrent->native_name ?? strtoupper(app()->getLocale()) }}</span>
                                <svg class="h-3 w-3 transition-transform" :class="langOpen && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <div x-show="langOpen" x-cloak x-transition
                                 class="absolute z-50 mt-2 w-44 overflow-hidden rounded-md bg-white py-1 text-ink shadow-lg @if($hdrCurrent && $hdrCurrent->isRtl()) left-0 @else right-0 @endif">
                                @foreach($hdrLanguages as $language)
                                    @php
                                        $targetUrl = lroute_for_locale($language->code);
                                        $switchUrl = route('change.language', ['language' => $language->code, 'to' => $targetUrl]);
                                    @endphp
                                    <a href="{{ $switchUrl }}"
                                       class="flex items-center gap-2.5 px-4 py-2 text-[13px] transition hover:bg-leaf-50 @if($language->code === app()->getLocale()) bg-leaf-50 font-bold text-leaf-700 @endif">
                                        <span class="text-base">{{ $language->flag }}</span>
                                        <span>{{ $language->native_name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20"/></svg> {{ strtoupper(app()->getLocale()) }}</span>
                    @endif
                </span>
            </div>
        </div>

        {{-- ana nav --}}
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-5">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5" aria-label="{{ $settings['site_name'] ?? 'Unikeyterra' }}">
                @if(!empty($settings['site_logo']))
                    <img src="{{ Storage::url($settings['site_logo']) }}" alt="{{ $settings['site_name'] ?? 'Unikeyterra' }}" class="h-11 w-auto" loading="eager" decoding="async">
                @else
                    <span class="grid h-10 w-10 place-items-center rounded-lg bg-white"><svg class="h-6 w-6 text-leaf-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6"/></svg></span>
                    <span class="text-2xl font-extrabold leading-none tracking-tight text-white">{{ $settings['site_name'] ?? 'Unikeyterra' }}</span>
                @endif
            </a>
            <nav class="hidden items-center gap-5 text-[15px] font-bold text-white lg:flex">
                <a href="{{ route('home') }}" class="{{ $navHome ? 'text-leaf-300' : '' }} transition hover:text-white/70">{{ __('Ana Sayfa') }}</a>
                <span class="text-white/25" aria-hidden="true">|</span>
                <a href="{{ lroute('products.index') }}" class="{{ $navProducts ? 'text-leaf-300' : '' }} transition hover:text-white/70">{{ __('Ürünler') }}</a>
                <span class="text-white/25" aria-hidden="true">|</span>
                <a href="{{ lroute('about') }}" class="{{ $navAbout ? 'text-leaf-300' : '' }} transition hover:text-white/70">{{ __('Hakkımızda') }}</a>
                <span class="text-white/25" aria-hidden="true">|</span>
                <a href="{{ lroute('contact') }}" class="{{ $navContact ? 'text-leaf-300' : '' }} transition hover:text-white/70">{{ __('İletişim') }}</a>
            </nav>
            <div class="flex items-center gap-3">
                <button @click="searchOpen = true" aria-label="{{ __('Ara') }}" class="grid h-10 w-12 place-items-center rounded bg-white text-earth-700 transition hover:bg-white/90">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                </button>
                <a href="{{ route('dealer.login') }}" class="hidden items-center gap-2 whitespace-nowrap rounded bg-white px-4 py-2.5 text-sm font-extrabold text-leaf-600 transition hover:bg-white/90 sm:inline-flex">
                    Unikey Connect
                    <span class="grid h-5 w-5 place-items-center rounded-full bg-leaf-600 text-white"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="M5 12h14M12 5v14"/></svg></span>
                </a>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="grid h-10 w-10 place-items-center rounded text-white lg:hidden" :aria-expanded="mobileMenuOpen.toString()" aria-label="{{ __('Menü') }}">
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- mobil menü --}}
        <div x-cloak x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white text-ink lg:hidden">
            <nav class="mx-auto max-w-6xl space-y-0.5 px-4 py-4">
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="block rounded-lg px-3 py-3 text-sm font-semibold text-ink transition hover:bg-leaf-50 hover:text-leaf-700">{{ __('Ana Sayfa') }}</a>
                <a href="{{ lroute('products.index') }}" @click="mobileMenuOpen = false" class="block rounded-lg px-3 py-3 text-sm font-semibold text-ink transition hover:bg-leaf-50 hover:text-leaf-700">{{ __('Ürünler') }}</a>
                <a href="{{ lroute('about') }}" @click="mobileMenuOpen = false" class="block rounded-lg px-3 py-3 text-sm font-semibold text-ink transition hover:bg-leaf-50 hover:text-leaf-700">{{ __('Hakkımızda') }}</a>
                <a href="{{ lroute('contact') }}" @click="mobileMenuOpen = false" class="block rounded-lg px-3 py-3 text-sm font-semibold text-ink transition hover:bg-leaf-50 hover:text-leaf-700">{{ __('İletişim') }}</a>
                <a href="{{ route('dealer.login') }}" @click="mobileMenuOpen = false" class="mt-2 block rounded-lg bg-leaf-600 px-3 py-3 text-center text-sm font-bold text-white transition hover:bg-leaf-700">Unikey Connect</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- ============================================================ --}}
    {{-- FOOTER — Claude Design (harfiyen)                            --}}
    {{-- ============================================================ --}}
    <footer class="soil pb-10 pt-14">
        <div class="mx-auto max-w-6xl px-5">
            <div class="grid grid-cols-2 gap-8 border-b border-white/10 pb-10 md:grid-cols-4">
                <div class="col-span-2 md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5" aria-label="{{ $settings['site_name'] ?? 'Unikeyterra' }}">
                        @if(!empty($settings['site_logo']))
                            <img src="{{ Storage::url($settings['site_logo']) }}" alt="{{ $settings['site_name'] ?? 'Unikeyterra' }}" class="h-11 w-auto" loading="lazy">
                        @else
                            <span class="grid h-10 w-10 place-items-center rounded-lg bg-white"><svg class="h-6 w-6 text-leaf-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6"/></svg></span>
                            <span class="text-xl font-extrabold tracking-tight text-white">{{ $settings['site_name'] ?? 'Unikeyterra' }}</span>
                        @endif
                    </a>
                    <p class="mt-4 max-w-xs text-sm leading-relaxed text-white/60">Üreticiden üreticiye; bilime dayalı bitki besleme ve biyostimülant çözümleri.</p>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold uppercase tracking-wide text-white">Ürünler</h3>
                    <ul class="mt-4 space-y-2.5 text-sm text-white/65">
                        <li><a href="{{ lroute('products.index') }}" class="transition hover:text-white">Biyostimülantlar</a></li>
                        <li><a href="{{ lroute('products.index') }}" class="transition hover:text-white">Sıvı Gübreler</a></li>
                        <li><a href="{{ lroute('products.index') }}" class="transition hover:text-white">Mikro Elementler</a></li>
                        <li><a href="{{ lroute('products.index') }}" class="transition hover:text-white">Toprak Düzenleyiciler</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold uppercase tracking-wide text-white">Kurumsal</h3>
                    <ul class="mt-4 space-y-2.5 text-sm text-white/65">
                        <li><a href="{{ lroute('about') }}" class="transition hover:text-white">Hakkımızda</a></li>
                        <li><a href="{{ lroute('about') }}#surdurulebilirlik" class="transition hover:text-white">Sürdürülebilirlik</a></li>
                        <li><a href="{{ lroute('contact') }}" class="transition hover:text-white">İletişim</a></li>
                        <li><a href="{{ route('dealer.login') }}" class="transition hover:text-white">Bayilik</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold uppercase tracking-wide text-white">İletişim</h3>
                    <ul class="mt-4 space-y-2.5 text-sm text-white/65">
                        <li>{{ $settings['contact_address'] ?: 'İzmir, Türkiye' }}@if($settings['contact_city'] ?? null) · {{ $settings['contact_city'] }}@endif</li>
                        <li><a href="tel:{{ preg_replace('/[^0-9+]/', '', ($settings['contact_phone'] ?? '') ?: '+902320000000') }}" class="transition hover:text-white">{{ $settings['contact_phone'] ?: '+90 232 000 00 00' }}</a></li>
                        <li><a href="mailto:{{ $settings['contact_email'] ?: 'info@unikeyterra.com.tr' }}" class="transition hover:text-white">{{ $settings['contact_email'] ?: 'info@unikeyterra.com.tr' }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-3 pt-6 text-[13px] text-white/60">
                <span>© 2026 Unikeyterra · Tüm hakları saklıdır.</span>
                <span class="flex gap-4">
                    <a href="{{ lroute('terms') }}" class="transition hover:text-white">Kullanım Koşulları</a>
                    <a href="{{ lroute('privacy') }}" class="transition hover:text-white">Gizlilik</a>
                </span>
            </div>
        </div>
    </footer>

    @stack('scripts')
    @include('partials.cookie-consent')

    {{-- Failsafe: reveal-animasyonu JS'i (app.js) herhangi bir sebeple çalışmazsa
         (eski tarayıcı cache'i, modül yükleme hatası, JS istisnası, eklenti müdahalesi)
         .sr/.sr-l/.sr-r içeriği opacity:0'da takılı KALMASIN diye açığa çıkarır.
         First-party + inline → adblock engellemez, ana paketten bağımsız çalışır.
         Yalnızca HİÇBİR öğe reveal olmadıysa devreye girer; çalışan animasyonu bozmaz. --}}
    <script>
    (function () {
        function failsafe() {
            var els = document.querySelectorAll('.sr, .sr-l, .sr-r');
            if (!els.length) return;
            for (var i = 0; i < els.length; i++) {
                if (els[i].classList.contains('in')) return; // reveal JS çalışıyor
            }
            for (var j = 0; j < els.length; j++) {
                els[j].classList.add('in');
                els[j].style.opacity = '1';
                els[j].style.transform = 'none';
            }
        }
        window.addEventListener('load', function () { setTimeout(failsafe, 1800); });
    })();
    </script>
</body>
</html>
