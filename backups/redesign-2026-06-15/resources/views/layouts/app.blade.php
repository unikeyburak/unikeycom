<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ request()->attributes->get('direction', 'ltr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', $settings['site_name'] ?? config('app.name'))</title>

    {{-- SEO Meta Tags --}}
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
    
    <!-- Fonts -->
    @if($settings['site_favicon'])
    <link rel="icon" type="image/x-icon" href="{{ Storage::url($settings['site_favicon']) }}">
    @endif
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <!-- Google Fonts & Font Awesome - asenkron yükle (render blocking değil) -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"></noscript>

    <!-- Font Awesome - solid + brands (sosyal medya ikonları için) -->
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/solid.min.css" onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/solid.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" crossorigin="anonymous">
    </noscript>
</head>
<body class="bg-white text-gray-900 antialiased @yield('body_class')"
      x-data="{ searchOpen: false, mobileMenuOpen: false, metaBarHidden: false }"
      @scroll.window.debounce.50ms="metaBarHidden = window.scrollY > 80"
      @keydown.escape.window="searchOpen = false; mobileMenuOpen = false">

    <!-- Search Overlay -->
    <div x-cloak x-show="searchOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-start justify-center pt-24 px-4"
         style="background:rgba(0,0,0,0.6);"
         @click.self="searchOpen = false">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden">
            <form action="{{ lroute('products.search') }}" method="GET">
                <div class="flex items-center px-5 py-4 gap-3">
                    <svg class="w-6 h-6 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text"
                           name="q"
                           placeholder="{{ __('Ürün ara...') }}"
                           class="flex-1 text-lg outline-none text-gray-800 placeholder-gray-400"
                           x-ref="searchInput"
                           x-init="$watch('searchOpen', v => v && $nextTick(() => $refs.searchInput.focus()))">
                    <button type="button" @click="searchOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="border-t border-gray-100 px-5 py-3 flex justify-between items-center bg-gray-50">
                    <span class="text-sm text-gray-400">{{ __('Aramak için Enter\'a basın') }}</span>
                    <button type="submit" class="bg-cyan-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-cyan-700 transition-colors">
                        {{ __('Ara') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @php
        // Meta-bar için içerik var mı? Yoksa üst şeridi hiç gösterme.
        $hasMetaBarContent = !empty($settings['header_tagline'])
            || !empty($settings['social_media'])
            || !empty($settings['meta_menu'])
            || (!empty($settings['header_meta_cta_text']) && !empty($settings['header_meta_cta_url']));
    @endphp

    <!-- ============================================================ -->
    <!-- HEADER — Vanipren Tarzı (Logo sol, 2 satır nav sağda)       -->
    <!-- ============================================================ -->
    <header class="site-header">
        <div class="site-header__inner">

            {{-- ── SOL: LOGO (dikey olarak header'ın tamamını kaplar) ─────── --}}
            <div class="site-header__brand">
                <a href="{{ route('home') }}" class="site-header__brand-link" aria-label="{{ $settings['site_name'] ?? '' }}">
                    @if($settings['site_logo'])
                        <img src="{{ Storage::url($settings['site_logo']) }}" alt="{{ $settings['site_name'] }}" loading="eager" decoding="async">
                    @else
                        <div class="site-header__brand-text">
                            <span class="site-header__brand-main">{{ $settings['site_name'] ?? 'KEYSOL' }}</span>
                            <span class="site-header__brand-sub">AGRO</span>
                        </div>
                    @endif
                </a>
            </div>

            {{-- ── SAĞ: İki satırlı nav grubu ─────────────────────────────── --}}
            <div class="site-header__right">

                {{-- ═══ ÜST SATIR: meta-nav + sosyal + dil + küçük CTA ═══ --}}
                <div class="site-header__row site-header__row--meta">

                    {{-- Sol: slogan (opsiyonel) --}}
                    @if(!empty($settings['header_tagline']))
                        <span class="site-header__tagline">{{ $settings['header_tagline'] }}</span>
                    @else
                        <span class="site-header__tagline-spacer"></span>
                    @endif

                    {{-- Sağ meta grubu --}}
                    <div class="site-header__meta-group">
                        @if(!empty($settings['meta_menu']))
                            <nav class="site-header__meta-nav" aria-label="{{ __('Meta menü') }}">
                                @foreach($settings['meta_menu'] as $metaItem)
                                    <a href="{{ $metaItem['url'] }}"
                                       @if($metaItem['is_external'] ?? false) target="_blank" rel="noopener" @endif>
                                        {{ __($metaItem['title']) }}
                                    </a>
                                @endforeach
                            </nav>
                        @endif

                        @if(!empty($settings['social_media']))
                            <div class="site-header__socials">
                                @foreach($settings['social_media'] as $social)
                                    @php
                                        $icon = match($social['platform'] ?? '') {
                                            'facebook'  => 'fa-facebook-f',
                                            'twitter'   => 'fa-x-twitter',
                                            'instagram' => 'fa-instagram',
                                            'linkedin'  => 'fa-linkedin-in',
                                            'youtube'   => 'fa-youtube',
                                            'whatsapp'  => 'fa-whatsapp',
                                            default     => 'fa-link',
                                        };
                                    @endphp
                                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener"
                                       aria-label="{{ ucfirst($social['platform'] ?? 'social') }}">
                                        <i class="fa-brands {{ $icon }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="site-header__lang">
                            @include('partials.language-switcher')
                        </div>

                        @if(!empty($settings['header_meta_cta_text']) && !empty($settings['header_meta_cta_url']))
                            <a href="{{ $settings['header_meta_cta_url'] }}" class="site-header__meta-cta">
                                {{ $settings['header_meta_cta_text'] }}
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Ayraç çizgisi --}}
                <div class="site-header__divider"></div>

                {{-- ═══ ALT SATIR: ana nav + CTA + arama ═══ --}}
                <div class="site-header__row site-header__row--main">

                    {{-- Ana menü --}}
                    <nav class="site-header__primary-nav" aria-label="{{ __('Ana menü') }}">
                        @if(!empty($settings['header_menu']))
                            @foreach($settings['header_menu'] as $item)
                                @if(in_array($item['title'], ['Ürünler', 'Products', 'Urunler']))
                                    @include('partials.mega-menu', [
                                        'menuLabel' => __($item['title']),
                                        'menuUrl' => $item['url'] ?? lroute('products.index'),
                                        'menuIsExternal' => $item['is_external'] ?? false,
                                        'navCategories' => $navCategories,
                                    ])
                                @else
                                    <a href="{{ $item['url'] }}" class="site-header__primary-link" @if($item['is_external'] ?? false) target="_blank" @endif>
                                        {{ __($item['title']) }}
                                    </a>
                                @endif
                            @endforeach
                        @else
                            @include('partials.mega-menu', [
                                'menuLabel' => __('Ürünler'),
                                'menuUrl' => lroute('products.index'),
                                'menuIsExternal' => false,
                                'navCategories' => $navCategories,
                            ])
                            <a href="{{ lroute('catalogs.index') }}" class="site-header__primary-link">{{ __('Katalog') }}</a>
                            <a href="{{ lroute('blog.index') }}" class="site-header__primary-link">{{ __('Blog') }}</a>
                            <a href="{{ lroute('about') }}" class="site-header__primary-link">{{ __('Hakkımızda') }}</a>
                            <a href="{{ lroute('contact') }}" class="site-header__primary-link">{{ __('İletişim') }}</a>
                        @endif
                    </nav>

                    {{-- Sağ action grubu --}}
                    <div class="site-header__actions">
                        @if($settings['header_cta_text'] && $settings['header_cta_url'])
                            <a href="{{ $settings['header_cta_url'] }}" class="site-header__primary-cta">
                                {{ $settings['header_cta_text'] }}
                            </a>
                        @else
                            <a href="{{ route('dealer.login') }}" class="site-header__primary-cta">
                                {{ __('Bayi Girişi') }}
                            </a>
                        @endif

                        <button @click="searchOpen = true" class="site-header__search-btn" aria-label="{{ __('Ara') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── MOBİL: Hamburger (md altında görünür, logo yanında) ──── --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="site-header__hamburger"
                    :aria-expanded="mobileMenuOpen.toString()"
                    aria-label="{{ __('Menü') }}">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- ============================================================ -->
        <!-- MOBİL MENÜ — sadece md altında gösterilir (lg altında)       -->
            <!-- ============================================================ -->
            <div x-cloak
                 x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-1"
                 class="md:hidden border-t border-gray-100 pb-4 max-h-[80vh] overflow-y-auto">

                <nav class="pt-3 space-y-0.5">

                    @if(!empty($settings['header_menu']))
                        {{-- Admin-configured menu --}}
                        @foreach($settings['header_menu'] as $menuItem)
                            @if(in_array($menuItem['title'], ['Ürünler', 'Products', 'Urunler']))
                                {{-- Ürünler — açılır accordion --}}
                                <div x-data="{ open: false }">
                                    <button @click="open = !open"
                                            class="flex items-center justify-between w-full px-3 py-3 text-sm font-medium text-gray-700 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                                        <span>{{ __($menuItem['title']) }}</span>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                             :class="{ 'rotate-180': open }"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                         x-transition:enter="transition ease-out duration-150"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         class="pl-3 pb-1 space-y-0.5">
                                        <a href="{{ $menuItem['url'] ?? lroute('products.index') }}"
                                           @click="mobileMenuOpen = false"
                                           class="block px-3 py-2 text-sm font-medium text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                                            {{ __('Tüm Ürünler') }}
                                        </a>
                                        @foreach($navCategories as $cat)
                                            <a href="{{ lroute('products.category', $cat->slug) }}"
                                               @click="mobileMenuOpen = false"
                                               class="block px-3 py-2 text-sm text-gray-600 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                                                {{ $cat->translate('name') }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $menuItem['url'] }}"
                                   @click="mobileMenuOpen = false"
                                   class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors"
                                   @if($menuItem['is_external'] ?? false) target="_blank" rel="noopener" @endif>
                                    {{ __($menuItem['title']) }}
                                </a>
                            @endif
                        @endforeach
                    @else
                        {{-- Default menu — if no settings configured --}}
                        <div x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center justify-between w-full px-3 py-3 text-sm font-medium text-gray-700 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                                <span>{{ __('Ürünler') }}</span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                     :class="{ 'rotate-180': open }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 class="pl-3 pb-1 space-y-0.5">
                                <a href="{{ lroute('products.index') }}"
                                   @click="mobileMenuOpen = false"
                                   class="block px-3 py-2 text-sm font-medium text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                                    {{ __('Tüm Ürünler') }}
                                </a>
                                @foreach($navCategories as $cat)
                                    <a href="{{ lroute('products.category', $cat->slug) }}"
                                       @click="mobileMenuOpen = false"
                                       class="block px-3 py-2 text-sm text-gray-600 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                                        {{ $cat->translate('name') }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <a href="{{ lroute('catalogs.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                            {{ __('Katalog') }}
                        </a>
                        <a href="{{ lroute('blog.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                            {{ __('Blog') }}
                        </a>
                        <a href="{{ lroute('about') }}" @click="mobileMenuOpen = false"
                           class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                            {{ __('Hakkımızda') }}
                        </a>
                        <a href="{{ lroute('contact') }}" @click="mobileMenuOpen = false"
                           class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                            {{ __('İletişim') }}
                        </a>
                    @endif

                </nav>

                {{-- Meta menü öğeleri (mobilde buraya düşer, meta-bar gizli olduğu için) --}}
                @if(!empty($settings['meta_menu']))
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <p class="px-3 text-xs uppercase tracking-wide text-gray-400 mb-1">{{ __('Kurumsal') }}</p>
                        @foreach($settings['meta_menu'] as $metaItem)
                            <a href="{{ $metaItem['url'] }}"
                               @click="mobileMenuOpen = false"
                               class="flex items-center px-3 py-2.5 text-sm text-gray-700 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors"
                               @if($metaItem['is_external'] ?? false) target="_blank" rel="noopener" @endif>
                                {{ __($metaItem['title']) }}
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Sosyal medya (mobilde) --}}
                @if(!empty($settings['social_media']))
                    <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-4 px-3">
                        @foreach($settings['social_media'] as $social)
                            @php
                                $icon = match($social['platform'] ?? '') {
                                    'facebook'  => 'fa-facebook-f',
                                    'twitter'   => 'fa-x-twitter',
                                    'instagram' => 'fa-instagram',
                                    'linkedin'  => 'fa-linkedin-in',
                                    'youtube'   => 'fa-youtube',
                                    'whatsapp'  => 'fa-whatsapp',
                                    default     => 'fa-link',
                                };
                            @endphp
                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener"
                               class="text-gray-500 hover:text-cyan-600 transition-colors"
                               aria-label="{{ ucfirst($social['platform'] ?? 'social') }}">
                                <i class="fa-brands {{ $icon }} text-lg"></i>
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Ayraç + Dil seçici + Bayi girişi -->
                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between px-3">
                    @include('partials.language-switcher')

                    @if($settings['header_cta_text'] && $settings['header_cta_url'])
                        <a href="{{ $settings['header_cta_url'] }}"
                           @click="mobileMenuOpen = false"
                           class="bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 transition-colors font-medium text-sm">
                            {{ $settings['header_cta_text'] }}
                        </a>
                    @else
                        <a href="{{ route('dealer.login') }}"
                           @click="mobileMenuOpen = false"
                           class="bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 transition-colors font-medium text-sm">
                            {{ __('Bayi Girişi') }}
                        </a>
                    @endif
                </div>

            </div>
            <!-- / MOBİL MENÜ -->

    </header>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="text-white" style="background:#083344;">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">{{ $settings['site_name'] ?? '' }}</h3>
                    <div class="text-gray-400 text-sm">
                        {!! $settings['footer_about'] ?? 'Your trusted partner for modern agricultural solutions. Premium fertilizers, crop nutrition, and farming products.' !!}
                    </div>
                </div>
                
                @if(!empty($settings['footer_columns']))
                    @foreach($settings['footer_columns'] as $column)
                        <div>
                            <h3 class="text-lg font-semibold mb-4">{{ $column['column_title'] }}</h3>
                            <ul class="space-y-2">
                                @foreach($column['links'] ?? [] as $link)
                                    <li>
                                        <a href="{{ $link['url'] }}" class="text-gray-400 hover:text-white text-sm transition-colors" @if($link['is_external'] ?? false) target="_blank" @endif>
                                            {{ $link['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @else
                    <!-- Default footer columns if no settings -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ __('Hızlı Linkler') }}</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ lroute('products.index') }}" class="text-gray-400 hover:text-white text-sm transition-colors">{{ __('Ürünler') }}</a></li>
                            <li><a href="{{ lroute('catalogs.index') }}" class="text-gray-400 hover:text-white text-sm transition-colors">{{ __('Katalog') }}</a></li>
                            <li><a href="{{ lroute('blog.index') }}" class="text-gray-400 hover:text-white text-sm transition-colors">{{ __('Blog') }}</a></li>
                            <li><a href="{{ lroute('about') }}" class="text-gray-400 hover:text-white text-sm transition-colors">{{ __('Hakkımızda') }}</a></li>
                            <li><a href="{{ lroute('contact') }}" class="text-gray-400 hover:text-white text-sm transition-colors">{{ __('İletişim') }}</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ __('Kategoriler') }}</h3>
                        <ul class="space-y-2">
                            @foreach($navCategories as $category)
                            <li>
                                <a href="{{ lroute('products.category', $category->slug) }}"
                                   class="text-gray-400 hover:text-white text-sm transition-colors">
                                    {{ $category->translate('name') }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ __('İletişim') }}</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        @if($settings['contact_phone'])
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $settings['contact_phone'] }}
                        </li>
                        @endif
                        @if($settings['contact_email'])
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $settings['contact_email'] }}
                        </li>
                        @endif
                        @if($settings['contact_address'])
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $settings['contact_address'] }}<br>
                            @if($settings['contact_city'] || $settings['contact_postcode'])
                                {{ $settings['contact_city'] }} {{ $settings['contact_postcode'] }}
                            @endif
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="mt-8 pt-8 border-t border-cyan-900">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        {{ $settings['footer_copyright'] ?? '' }}
                    </p>
                    
                    @if(!empty($settings['social_media']))
                    <div class="mt-4 md:mt-0 flex items-center space-x-4">
                        @foreach($settings['social_media'] as $social)
                            <a href="{{ $social['url'] }}" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                                @switch($social['platform'])
                                    @case('facebook')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                        @break
                                    @case('twitter')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                        @break
                                    @case('instagram')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                                        </svg>
                                        @break
                                    @case('linkedin')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                        @break
                                    @case('youtube')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                        @break
                                    @case('whatsapp')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                        @break
                                    @default
                                        <span class="text-xs">{{ $social['platform'] }}</span>
                                @endswitch
                            </a>
                        @endforeach
                    </div>
                    @endif
                    
                    <div class="mt-4 md:mt-0 flex space-x-6">
                        <a href="{{ lroute('privacy') }}" class="text-gray-400 hover:text-white text-sm transition-colors">
                            {{ __('Gizlilik Politikası') }}
                        </a>
                        <a href="{{ lroute('terms') }}" class="text-gray-400 hover:text-white text-sm transition-colors">
                            {{ __('Kullanım Şartları') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    @stack('scripts')

    @include('partials.cookie-consent')
</body>
</html>
