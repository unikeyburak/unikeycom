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
                    <span class="flex items-center gap-3">
                        <a href="https://www.instagram.com/stories/unikeyterrachemical/" target="_blank" rel="noopener" class="story-ring" aria-label="Instagram hikayelerimizi izle" title="{{ __('Hikayemizi izle') }}"><span class="story-ring__avatar"><img src="{{ asset('images/leaf.png') }}" alt=""></span></a>
                        <a href="https://www.instagram.com/unikeyterrachemical/" target="_blank" rel="noopener" aria-label="Instagram" class="transition hover:text-white"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.7 3.7 0 0 1-1.38-.9 3.7 3.7 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.42 2.17 8.8 2.16 12 2.16Z"/></svg></a>
                        <a href="#" aria-label="Facebook" class="transition hover:text-white"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3V5h-3c-2.2 0-4 1.8-4 4v2H7v4h3v6h4v-6h3l1-4h-4V9c0-.6.4-1 1-1Z"/></svg></a>
                        <a href="#" aria-label="LinkedIn" class="transition hover:text-white"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.94 5a1.94 1.94 0 1 1-3.88 0 1.94 1.94 0 0 1 3.88 0ZM3.4 8.4h3.1V21H3.4V8.4Zm5.06 0h2.97v1.72h.04c.41-.78 1.42-1.6 2.93-1.6 3.13 0 3.71 2.06 3.71 4.74V21h-3.1v-5.6c0-1.34-.02-3.06-1.86-3.06-1.87 0-2.15 1.46-2.15 2.96V21H8.46V8.4Z"/></svg></a>
                    </span>
                    <span class="inline-flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20"/></svg> TR</span>
                </span>
            </div>
        </div>

        {{-- ana nav --}}
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-5">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5" aria-label="KeysolAgro ana sayfa">
                <span class="grid h-10 w-10 place-items-center rounded-lg bg-white"><svg class="h-6 w-6 text-leaf-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6"/></svg></span>
                <span class="text-2xl font-extrabold leading-none tracking-tight text-white">Keysol<span class="text-leaf-300">Agro</span></span>
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
                    Keysol Connect
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
                <a href="{{ route('dealer.login') }}" @click="mobileMenuOpen = false" class="mt-2 block rounded-lg bg-leaf-600 px-3 py-3 text-center text-sm font-bold text-white transition hover:bg-leaf-700">Keysol Connect</a>
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
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5" aria-label="KeysolAgro ana sayfa">
                        <span class="grid h-10 w-10 place-items-center rounded-lg bg-white"><svg class="h-6 w-6 text-leaf-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6"/></svg></span>
                        <span class="text-xl font-extrabold tracking-tight text-white">Keysol<span class="text-leaf-300">Agro</span></span>
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
                        <li>Antalya Organize Sanayi Bölgesi</li>
                        <li><a href="tel:+902420000000" class="transition hover:text-white">+90 242 000 00 00</a></li>
                        <li><a href="mailto:info@keysolagro.com" class="transition hover:text-white">info@keysolagro.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-3 pt-6 text-[13px] text-white/60">
                <span>© 2026 Keysol Agro · Tüm hakları saklıdır.</span>
                <span class="flex gap-4">
                    <a href="{{ lroute('terms') }}" class="transition hover:text-white">Kullanım Koşulları</a>
                    <a href="{{ lroute('privacy') }}" class="transition hover:text-white">Gizlilik</a>
                </span>
            </div>
        </div>
    </footer>

    @stack('scripts')
    @include('partials.cookie-consent')
</body>
</html>
