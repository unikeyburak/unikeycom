@extends('layouts.app')

@section('title', $settings['home_meta_title'] ?? ($settings['site_name'] ?? config('app.name')))
@section('meta_description', $settings['home_meta_description'] ?? ($settings['site_description'] ?? ''))

@php
    $heroSlides = $settings['hero_slides'] ?? [];
    if (!is_array($heroSlides)) { $heroSlides = []; }
    $heroSlides = array_values(array_filter($heroSlides, fn($s) => !isset($s['is_active']) || $s['is_active']));

    if (empty($heroSlides)) {
        $heroSlides = [
            [
                'image'       => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=2000&q=80',
                'title'       => __('Tarımın Geleceğini Şekillendiriyoruz'),
                'subtitle'    => __('Yenilikçi Çözümler'),
                'description' => __('Sürdürülebilir tarım için bilim temelli ürünler ve uzman desteği'),
                'primary_label'   => __('Ürün Kataloğu'),
                'primary_url'     => lroute('products.index'),
                'secondary_label' => __('Bizimle İletişime Geçin'),
                'secondary_url'   => lroute('contact'),
                'text_x'     => 8,
                'text_y'     => 50,
                'text_align' => 'left',
                'text_width' => 'min(90vw, 600px)',
            ],
        ];
    }

    $heroAutoplay = isset($settings['hero_slider_autoplay']) ? (int) $settings['hero_slider_autoplay'] : 7000;

    $firstHeroImage = $heroSlides[0]['image'] ?? null;
    $firstHeroImageUrl = $firstHeroImage;
    if (!empty($firstHeroImage) && !str_starts_with($firstHeroImage, 'http')) {
        $firstHeroImageUrl = Storage::url($firstHeroImage);
    }

    // Şirket değerleri
    $values = [
        [
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.075m.75-.075a4.5 4.5 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.075m-1.5 0c.501.023 1.004.05 1.5.075M4.875 18.75a.75.75 0 011.085-.634l3.155 1.576a4.5 4.5 0 004.77 0l3.155-1.576a.75.75 0 011.085.634v3a.75.75 0 01-.75.75H5.625a.75.75 0 01-.75-.75v-3z"/></svg>',
            'title' => __('Bilim Temelli'),
            'desc'  => __('Her ürünümüz kapsamlı Ar-Ge çalışmalarının ve saha testlerinin sonucudur.'),
        ],
        [
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>',
            'title' => __('Sürdürülebilirlik'),
            'desc'  => __('Toprağı, suyu ve biyoçeşitliliği koruyan çevre dostu formülasyonlar.'),
        ],
        [
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>',
            'title' => __('Uzman Destek'),
            'desc'  => __('Tarım mühendisleri ve teknik ekibimiz her adımda yanınızda.'),
        ],
    ];

    // Kategori ikon haritası
    $categoryIconMap = [
        'bakir-sulfat'                      => 'bakir-sulfat.png',
        'demir-sulfat'                      => 'demir-sulfat.png',
        'magnezyum-sulfat'                  => 'magnezyum-sulfat.png',
        'mangan-sulfat'                     => 'mangan-sulfat.png',
        'cinko-sulfat'                      => 'cinko-sulfat.png',
        'granul-gubreler'                   => 'granul-gubreler.png',
        'mikro-granul-gubreler'             => 'mikro-granul-gubreler.png',
        'mikro-element-gubreler'            => 'mikro-element-gubreler.png',
        'npk-gubreler'                      => 'npk-gubreler.png',
        'organik-sivi-gubreler'             => 'organik-sivi-gubreler.png',
        'sivi-gubreler'                     => 'sivi-gubreler.png',
        'suda-cozunebilir-gubreler'         => 'suda-cozunebilir-gubreler.png',
        'suspansiyon-damlama-gubreleri'     => 'suspansiyon-damlama-gubreleri.png',
        'saf-gubreler'                      => 'saf-gubreler.png',
        'saf-gubreler-npk-gubreler'         => 'saf-gubreler-npk-gubreler.png',
        'sivi-mikro-element-gubreler'       => 'sivi-mikro-element-gubreler.png',
        'toz-mikro-element-gubreler'        => 'toz-mikro-element-gubreler.png',
        'suspansiyon-mikro-element-gubreler'=> 'suspansiyon-mikro-element-gubreler.png',
        'klasik-gubreler'                   => 'klasik-gubreler.png',
        'yavas-salinimli-gubreler'          => 'yavas-salinimli-gubreler.png',
        'organomineral-gubreler'            => 'organomineral-gubreler.png',
        'topraksiz-tarim-gubreleri'         => 'topraksiz-tarim-gubreleri.png',
    ];

    // Anasayfada gösterilecek max kategori sayısı
    $displayCategories = $categories->take(8);
@endphp

@push('styles')
@if(!empty($firstHeroImageUrl))
<link rel="preload" as="image" href="{{ $firstHeroImageUrl }}">
@endif
<style>
/* ===== HERO ===== */
.home-hero { position:relative; height:100svh; min-height:560px; max-height:900px; }
.home-hero__slide { position:absolute; inset:0; }
.home-hero__content {
    position:absolute; bottom:0; left:0; right:0;
    padding: 0 max(1.5rem, env(safe-area-inset-left)) 3.5rem max(1.5rem, env(safe-area-inset-left));
}
@media(min-width:768px){ .home-hero__content{ padding-bottom:5rem; } }

/* Typewriter cursor */
.home-hero__kicker::after{ content:''; display:inline-block; width:2px; height:1em; background:currentColor; margin-left:3px; vertical-align:middle; animation:blink .8s step-end infinite; }
@keyframes blink{ 0%,100%{opacity:1} 50%{opacity:0} }

/* ===== VALUE PILLS ===== */
.value-card { transition: transform .25s ease, box-shadow .25s ease; }
.value-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.1); }

/* ===== CATEGORY MOSAIC ===== */
.cat-mosaic { display:grid; gap:1rem; grid-template-columns:repeat(2,1fr); }
@media(min-width:640px){ .cat-mosaic{ grid-template-columns:repeat(3,1fr); } }
@media(min-width:1024px){ .cat-mosaic{ grid-template-columns:repeat(4,1fr); } }

.cat-tile { position:relative; border-radius:1rem; overflow:hidden; aspect-ratio:3/4; }
.cat-tile--wide { aspect-ratio:16/9; }
@media(min-width:640px){ .cat-tile--wide{ grid-column:span 2; } }
@media(min-width:1024px){ .cat-tile--wide{ grid-column:span 2; aspect-ratio:auto; } }

.cat-tile__img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform .6s ease; }
.cat-tile:hover .cat-tile__img { transform:scale(1.06); }
.cat-tile__overlay { position:absolute; inset:0; background: linear-gradient(to top, rgba(0,0,0,.72) 0%, rgba(0,0,0,.15) 55%, transparent 100%); }
.cat-tile__body { position:absolute; inset-x-0; bottom:0; padding:1.25rem; }
.cat-tile__arrow { display:inline-flex; align-items:center; gap:.375rem; margin-top:.375rem; opacity:0; transform:translateX(-6px); transition:opacity .25s, transform .25s; }
.cat-tile:hover .cat-tile__arrow { opacity:1; transform:translateX(0); }

/* ===== SPLIT ABOUT ===== */
.about-image-wrap { position:relative; }
.about-image-wrap::after {
    content:'';
    position:absolute;
    bottom:-1.25rem; left:-1.25rem;
    width:70%; height:70%;
    background:#083344;
    border-radius:.75rem;
    z-index:-1;
}

/* ===== STAT COUNTER ===== */
.stat-item + .stat-item { border-left:1px solid rgba(255,255,255,.12); }

/* ===== BLOG ===== */
.blog-card { display:flex; flex-direction:column; border-radius:1rem; overflow:hidden; background:#fff; transition:transform .25s ease, box-shadow .25s ease; }
.blog-card:hover { transform:translateY(-4px); box-shadow:0 16px 36px rgba(0,0,0,.1); }
.blog-card__img { aspect-ratio:16/9; overflow:hidden; }
.blog-card__img img { width:100%; height:100%; object-fit:cover; transition:transform .5s ease; }
.blog-card:hover .blog-card__img img { transform:scale(1.05); }

/* ===== PARTNER CTA ===== */
.partner-cta { background: linear-gradient(135deg, #083344 0%, #0a4a60 50%, #0f6b8a 100%); }

/* ===== SCROLL REVEAL ===== */
.reveal { opacity:0; transform:translateY(28px); transition:opacity .6s ease, transform .6s ease; }
.reveal.visible { opacity:1; transform:none; }
.reveal-delay-1 { transition-delay:.1s; }
.reveal-delay-2 { transition-delay:.2s; }
.reveal-delay-3 { transition-delay:.3s; }
</style>
@endpush

@section('content')

{{-- =========================================================
     1. HERO — Vanipren tarzı, oval alt kenarlı, single hero
     ========================================================= --}}
@php
    $heroSlide = $heroSlides[0] ?? [];
    $heroImg = $heroSlide['image'] ?? null;
    if (!empty($heroImg) && !str_starts_with($heroImg, 'http')) {
        $heroImg = Storage::url($heroImg);
    }
@endphp

@include('partials.page-header', [
    'title'    => $heroSlide['title']       ?? __('Tarımın Geleceğini Şekillendiriyoruz'),
    'subtitle' => $heroSlide['description'] ?? __('Sürdürülebilir tarım için bilim temelli ürünler ve uzman desteği'),
    'image'    => $heroImg,
    'ctaText'  => $heroSlide['primary_label'] ?? __('Ürün Kataloğu'),
    'ctaUrl'   => $heroSlide['primary_url']   ?? lroute('products.index'),
    'videoUrl' => $settings['hero_video_url'] ?? null,
    'size'     => 'large',
    'overlay'  => true,
])

{{-- =========================================================
     2. DEĞER ÖNERİLERİ — 3 sütunlu, ikonik
     ========================================================= --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-gray-100 rounded-2xl overflow-hidden shadow-sm">
            @foreach($values as $i => $val)
            <div class="value-card bg-white p-8 lg:p-10 reveal reveal-delay-{{ $i+1 }}">
                <div class="w-12 h-12 text-cyan-600 mb-5">
                    {!! $val['icon'] !!}
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $val['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $val['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================
     3. ÇÖZÜM ALANLARI — Editorial mozaik kategori görünümü
     ========================================================= --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        {{-- Başlık --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12 reveal">
            <div>
                <span class="text-xs font-bold tracking-widest uppercase text-cyan-600 block mb-3">{{ __('Ürün Grupları') }}</span>
                <h2 class="text-3xl lg:text-4xl font-black text-gray-900 leading-tight">
                    {{ __('Tarımda Her İhtiyaca') }}<br>
                    <span style="color:#083344;">{{ __('Doğru Çözüm') }}</span>
                </h2>
            </div>
            <a href="{{ lroute('products.index') }}"
               class="flex-shrink-0 inline-flex items-center gap-2 text-sm font-semibold text-cyan-600 hover:text-cyan-700 transition-colors border-b-2 border-cyan-200 hover:border-cyan-600 pb-0.5">
                {{ __('Tüm Ürün Kataloğu') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Mozaik grid --}}
        <div class="cat-mosaic">
            @foreach($displayCategories as $i => $category)
            @php
                $iconFile  = $categoryIconMap[$category->slug] ?? 'default.svg';
                $iconUrl   = asset('assets/icons/categories/' . $iconFile);
                $imgSrc    = $category->icon_image_url ?? $iconUrl;
                $isWide    = $i === 0; // ilk tile geniş
            @endphp
            <a href="{{ lroute('products.category', $category->slug) }}"
               class="cat-tile {{ $isWide ? 'cat-tile--wide' : '' }} reveal reveal-delay-{{ min($i % 3 + 1, 3) }}"
               aria-label="{{ $category->translate('name') }}">

                {{-- Görsel --}}
                <img src="{{ $imgSrc }}"
                     alt="{{ $category->translate('name') }}"
                     class="cat-tile__img"
                     loading="lazy" decoding="async">

                {{-- Koyu overlay --}}
                <div class="cat-tile__overlay"></div>

                {{-- İçerik --}}
                <div class="cat-tile__body">
                    @if($category->products_count > 0)
                    <span class="text-[10px] font-bold tracking-widest uppercase text-cyan-300 block mb-1">
                        {{ $category->products_count }} {{ __('ürün') }}
                    </span>
                    @endif
                    <h3 class="font-bold text-white text-sm sm:text-base leading-snug">
                        {{ $category->translate('name') }}
                    </h3>
                    <span class="cat-tile__arrow text-xs text-cyan-300 font-semibold">
                        {{ __('İncele') }}
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================
     4. HAKKIMIZDA — Split layout, hikaye odaklı
     ========================================================= --}}
<section class="py-24 bg-white overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Sol: görsel --}}
            <div class="about-image-wrap reveal">
                <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=900&q=80"
                     alt="{{ __('Tarım alanında çalışma') }}"
                     class="w-full h-80 lg:h-[480px] object-cover rounded-2xl"
                     loading="lazy" decoding="async">
                {{-- Floating badge --}}
                <div class="absolute -top-4 -right-4 bg-cyan-500 text-white rounded-2xl px-5 py-4 text-center shadow-xl shadow-cyan-900/30 hidden sm:block">
                    <span class="block text-3xl font-black">25+</span>
                    <span class="text-xs font-semibold tracking-wide">{{ __('Yıllık Deneyim') }}</span>
                </div>
            </div>

            {{-- Sağ: metin --}}
            <div class="reveal reveal-delay-2">
                <span class="text-xs font-bold tracking-widest uppercase text-cyan-600 block mb-4">{{ __('Hakkımızda') }}</span>
                <h2 class="text-3xl lg:text-4xl font-black text-gray-900 leading-tight mb-6">
                    {{ __('Tarımsal Üretimi') }}<br>
                    <span style="color:#083344;">{{ __('Daha Verimli Kılıyoruz') }}</span>
                </h2>
                <p class="text-gray-600 leading-relaxed mb-5">
                    {{ __('Keysol Agro olarak, tarım sektörüne yönelik yenilikçi gübre ve bitki besleme çözümleri sunuyoruz. Bilim temelli yaklaşımımız ve geniş ürün yelpazemizle çiftçilerin ve tarım profesyonellerinin yanında yer alıyoruz.') }}
                </p>
                <p class="text-gray-600 leading-relaxed mb-8">
                    {{ __('Sürdürülebilir tarım anlayışıyla geliştirdiğimiz ürünler, toprak sağlığını korurken verimliliği en üst düzeye çıkarmanızı sağlar.') }}
                </p>

                {{-- Özellikler listesi --}}
                <ul class="space-y-3 mb-10">
                    @foreach([__('250\'den fazla ürün çeşidiyle kapsamlı çözümler'), __('Türkiye genelinde güçlü bayi ağı'), __('Sertifikalı ve kayıtlı ürün portföyü')] as $feature)
                    <li class="flex items-center gap-3 text-gray-700">
                        <span class="flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center" style="background:#083344;">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span class="text-sm font-medium">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>

                <a href="{{ lroute('about') }}"
                   class="inline-flex items-center gap-2 font-semibold px-7 py-3.5 rounded-xl text-white transition-all duration-200 shadow-lg shadow-cyan-900/30 hover:opacity-90"
                   style="background:#083344;">
                    {{ __('Daha Fazla Bilgi') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     5. İSTATİSTİKLER — Koyu banner, etkileyici sayılar
     ========================================================= --}}
<section style="background:#083344;" class="py-16 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-0" id="statsGrid">
            @foreach([
                ['val' => '250+', 'target' => 250, 'suffix' => '+', 'label' => __('Ürün Çeşidi')],
                ['val' => '50+',  'target' => 50,  'suffix' => '+', 'label' => __('Ülkeye İhracat')],
                ['val' => '25+',  'target' => 25,  'suffix' => '+', 'label' => __('Yıllık Deneyim')],
                ['val' => '1000+','target' => 1000,'suffix' => '+', 'label' => __('Mutlu Bayi')],
            ] as $i => $stat)
            <div class="stat-item text-center py-10 px-4 reveal reveal-delay-{{ $i+1 }}">
                <div class="text-4xl sm:text-5xl font-black text-white mb-2 stat-counter"
                     data-target="{{ $stat['target'] }}"
                     data-suffix="{{ $stat['suffix'] }}">
                    {{ $stat['val'] }}
                </div>
                <p class="text-xs font-bold tracking-widest uppercase text-cyan-300">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================
     6. VİDEO SHOWCASE — Marka filmi / sinematik bölüm
     ========================================================= --}}
@php
    $videoUrl       = $settings['brand_video_url']       ?? '';
    $videoThumb     = $settings['brand_video_thumbnail'] ?? '';
    $videoTitle     = $settings['brand_video_title']     ?? __('Tarımın Geleceğine Yolculuk');
    $videoSubtitle  = $settings['brand_video_subtitle']  ?? __('Keysol Agro ile sürdürülebilir tarımın nasıl mümkün olduğunu keşfedin.');

    // YouTube ID ayıkla
    $youtubeId = '';
    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_\-]{11})/', $videoUrl, $ym)) {
        $youtubeId = $ym[1];
    }
    // Thumbnail: önce admin ayarı, sonra YouTube otomatik, sonra Unsplash fallback
    if (empty($videoThumb)) {
        $videoThumb = $youtubeId
            ? "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg"
            : 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&w=1600&q=80';
    } elseif (!str_starts_with($videoThumb, 'http')) {
        $videoThumb = Storage::url($videoThumb);
    }

    // Embed URL
    $embedUrl = $youtubeId
        ? "https://www.youtube.com/embed/{$youtubeId}?autoplay=1&rel=0&modestbranding=1"
        : $videoUrl;

    // Video bölümü aktif mi? URL girilmemişse gösterme
    $showVideoSection = !empty($videoUrl);
@endphp

@if($showVideoSection)
<section class="relative overflow-hidden bg-gray-900"
    x-data="{ videoOpen: false }"
    @keydown.escape.window="videoOpen = false">

    {{-- Arka plan görseli + overlay --}}
    <div class="relative">
        <img src="{{ $videoThumb }}"
             alt="{{ $videoTitle }}"
             class="w-full object-cover"
             style="height: clamp(320px, 56vw, 680px);"
             loading="lazy" decoding="async">

        {{-- Koyu sinematik overlay --}}
        <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(4,30,40,.82) 0%, rgba(4,30,40,.45) 50%, rgba(4,30,40,.75) 100%);"></div>

        {{-- Paralaks dekoratif çizgiler --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <div class="absolute top-0 left-1/4 w-px h-full opacity-10" style="background: linear-gradient(to bottom, transparent, #22d3ee, transparent);"></div>
            <div class="absolute top-0 right-1/3 w-px h-full opacity-10" style="background: linear-gradient(to bottom, transparent, #22d3ee, transparent);"></div>
        </div>

        {{-- İçerik --}}
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center px-4 reveal">

                {{-- Etiket --}}
                <span class="inline-flex items-center gap-2 mb-6">
                    <span class="h-px w-8 bg-cyan-400"></span>
                    <span class="text-cyan-300 text-xs font-bold tracking-widest uppercase">{{ __('Marka Filmi') }}</span>
                    <span class="h-px w-8 bg-cyan-400"></span>
                </span>

                {{-- Başlık --}}
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-4 leading-tight max-w-3xl mx-auto">
                    {{ $videoTitle }}
                </h2>
                <p class="text-cyan-100/80 text-base sm:text-lg mb-10 max-w-xl mx-auto leading-relaxed">
                    {{ $videoSubtitle }}
                </p>

                {{-- Play butonu --}}
                <button @click="videoOpen = true"
                        class="group relative inline-flex items-center justify-center"
                        aria-label="{{ __('Videoyu oynat') }}">

                    {{-- Pulse halkalar --}}
                    <span class="absolute inline-flex h-24 w-24 rounded-full bg-cyan-400/20 animate-ping" style="animation-duration:2s;"></span>
                    <span class="absolute inline-flex h-20 w-20 rounded-full bg-cyan-400/30"></span>

                    {{-- Ana daire --}}
                    <span class="relative flex items-center justify-center w-20 h-20 rounded-full bg-white shadow-2xl shadow-black/40 group-hover:scale-110 transition-transform duration-300">
                        {{-- Play üçgeni --}}
                        <svg class="w-7 h-7 text-cyan-700 ml-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </span>
                </button>

                {{-- Alt metin --}}
                <p class="mt-6 text-white/40 text-xs tracking-widest uppercase">{{ __('İzlemek için tıklayın') }}</p>
            </div>
        </div>
    </div>

    {{-- Video Modal --}}
    <div x-show="videoOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-8"
         style="background: rgba(0,0,0,0.92);"
         @click.self="videoOpen = false">

        <div class="relative w-full max-w-5xl"
             x-show="videoOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            {{-- Kapat butonu --}}
            <button @click="videoOpen = false"
                    class="absolute -top-12 right-0 text-white/60 hover:text-white transition-colors flex items-center gap-2 text-sm"
                    aria-label="{{ __('Kapat') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ __('Kapat') }}
            </button>

            {{-- 16:9 iframe wrapper --}}
            <div class="relative rounded-2xl overflow-hidden shadow-2xl" style="padding-bottom: 56.25%;">
                @if($youtubeId)
                    {{-- Modal açıkken iframe yükle (performans için) --}}
                    <iframe x-show="videoOpen"
                            src="{{ $embedUrl }}"
                            class="absolute inset-0 w-full h-full"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            loading="lazy"
                            title="{{ $videoTitle }}">
                    </iframe>
                @else
                    <video x-show="videoOpen"
                           class="absolute inset-0 w-full h-full object-cover"
                           controls autoplay
                           :src="videoOpen ? '{{ $videoUrl }}' : ''">
                    </video>
                @endif
            </div>
        </div>
    </div>
</section>
@endif {{-- /showVideoSection --}}

{{-- =========================================================
     7. BLOG / İÇGÖRÜLER — Editorial, 3 kart
     ========================================================= --}}
@if($latestPosts->count() > 0)
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">

        {{-- Başlık --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12 reveal">
            <div>
                <span class="text-xs font-bold tracking-widest uppercase text-cyan-600 block mb-3">{{ __('Haberler & Makaleler') }}</span>
                <h2 class="text-3xl lg:text-4xl font-black text-gray-900">
                    {{ __('Tarım Dünyasından') }}<br>
                    <span style="color:#083344;">{{ __('Güncel Bilgiler') }}</span>
                </h2>
            </div>
            <a href="{{ lroute('blog.index') }}"
               class="flex-shrink-0 inline-flex items-center gap-2 text-sm font-semibold text-cyan-600 hover:text-cyan-700 border-b-2 border-cyan-200 hover:border-cyan-600 pb-0.5 transition-colors">
                {{ __('Tüm Yazılar') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Kartlar — ilk büyük, diğerleri küçük --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- Büyük kart --}}
            @php $firstPost = $latestPosts->first(); @endphp
            <a href="{{ route('blog.show', $firstPost->slug) }}" class="blog-card lg:col-span-3 reveal">
                <div class="blog-card__img" style="aspect-ratio:16/9;">
                    @if($firstPost->featured_image)
                    <img src="{{ $firstPost->featured_image_url }}" alt="{{ $firstPost->title }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-cyan-50">
                        <svg class="w-20 h-20 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9"/></svg>
                    </div>
                    @endif
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    @if($firstPost->category)
                    <span class="text-xs font-bold uppercase tracking-wider text-cyan-600 mb-3">{{ $firstPost->category->name }}</span>
                    @endif
                    <h3 class="text-xl font-bold text-gray-900 mb-3 leading-snug line-clamp-2 group-hover:text-cyan-600">{{ $firstPost->title }}</h3>
                    @if($firstPost->excerpt)
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2 flex-1 mb-4">{{ Str::limit(strip_tags($firstPost->excerpt), 130) }}</p>
                    @endif
                    <div class="flex items-center gap-4 text-xs text-gray-400 mt-auto">
                        <span>{{ $firstPost->published_at?->format('d M Y') ?? $firstPost->created_at->format('d M Y') }}</span>
                        @if($firstPost->reading_time)
                        <span>{{ $firstPost->reading_time }} {{ __('dk okuma') }}</span>
                        @endif
                    </div>
                </div>
            </a>

            {{-- Sağ: 2 küçük kart --}}
            <div class="lg:col-span-2 flex flex-col gap-6">
                @foreach($latestPosts->skip(1)->take(2) as $i => $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="blog-card flex-1 reveal reveal-delay-{{ $i+1 }}">
                    <div class="flex h-full">
                        {{-- Küçük görsel --}}
                        <div class="w-28 sm:w-36 flex-shrink-0 overflow-hidden" style="aspect-ratio:1;">
                            @if($post->featured_image)
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-cyan-50">
                                <svg class="w-10 h-10 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9"/></svg>
                            </div>
                            @endif
                        </div>
                        {{-- Metin --}}
                        <div class="p-4 flex flex-col justify-between">
                            @if($post->category)
                            <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-600 block mb-1">{{ $post->category->name }}</span>
                            @endif
                            <h3 class="text-sm font-bold text-gray-900 leading-snug line-clamp-3 mb-2">{{ $post->title }}</h3>
                            <span class="text-xs text-gray-400">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- =========================================================
     8. BAYİ ORTAKLIK — Premium tam genişlik CTA
     ========================================================= --}}
<section class="partner-cta py-24 relative overflow-hidden">
    {{-- Dekoratif daireler --}}
    <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full opacity-10" style="background:radial-gradient(circle, #22d3ee, transparent);"></div>
    <div class="absolute -bottom-24 -left-24 w-72 h-72 rounded-full opacity-10" style="background:radial-gradient(circle, #0ea5e9, transparent);"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="reveal">
                <span class="text-xs font-bold tracking-widest uppercase text-cyan-400 block mb-4">{{ __('Bayi Programı') }}</span>
                <h2 class="text-3xl lg:text-4xl font-black text-white leading-tight mb-5">
                    {{ __('Güçlü Bayi Ağımıza') }}<br>
                    {{ __('Katılın') }}
                </h2>
                <p class="text-cyan-100/80 leading-relaxed max-w-lg">
                    {{ __("Türkiye'nin her köşesinde büyüyen bayi ağımızda yerinizi alın. Özel fiyatlandırma, teknik destek ve pazarlama materyalleriyle işinizi büyütün.") }}
                </p>
            </div>

            <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row gap-4 lg:justify-end reveal reveal-delay-2">
                {{-- Birincil CTA --}}
                <a href="{{ route('dealer.register') }}"
                   class="inline-flex items-center justify-center gap-2 bg-cyan-400 hover:bg-cyan-300 text-gray-900 font-bold px-8 py-4 rounded-2xl transition-all duration-200 shadow-lg shadow-black/20 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    {{ __('Bayi Başvurusu Yap') }}
                </a>

                {{-- İkincil CTA --}}
                <a href="{{ lroute('contact') }}"
                   class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-8 py-4 rounded-2xl border border-white/20 transition-all duration-200 text-sm backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    {{ __('Bilgi Alın') }}
                </a>
            </div>
        </div>

        {{-- Avantaj listesi --}}
        <div class="mt-14 pt-10 border-t border-white/10 grid grid-cols-2 sm:grid-cols-4 gap-6">
            @foreach([
                ['ico'=>'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'txt'=>__('Özel Fiyatlar')],
                ['ico'=>'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'txt'=>__('Teknik Destek')],
                ['ico'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'txt'=>__('Katalog & Materyaller')],
                ['ico'=>'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'txt'=>__('Büyüme Fırsatı')],
            ] as $benefit)
            <div class="flex items-center gap-3 reveal">
                <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-cyan-400/15 flex items-center justify-center">
                    <svg class="w-4 h-4 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $benefit['ico'] }}"/></svg>
                </span>
                <span class="text-sm text-white font-medium">{{ $benefit['txt'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Bitki Besleme Programları (mevcut component) --}}
@include('components.plant-programs-grid')

{{-- Bitki Arama Widget'ı (mevcut component) --}}
@include('components.plant-search-widget')

@endsection

@push('scripts')
<script>
(function(){
    // ── Scroll Reveal ──────────────────────────────────────────
    var revealIO = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){ e.target.classList.add('visible'); revealIO.unobserve(e.target); }
        });
    },{ threshold: 0.12 });
    document.querySelectorAll('.reveal').forEach(function(el){ revealIO.observe(el); });

    // ── Sayaç animasyonu ───────────────────────────────────────
    var counters = document.querySelectorAll('.stat-counter');
    if(counters.length === 0) return;

    var counterIO = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(!e.isIntersecting) return;
            var el     = e.target;
            var target = parseInt(el.dataset.target, 10);
            var suffix = el.dataset.suffix || '';
            var start  = 0;
            var step   = target / 45;
            var timer  = setInterval(function(){
                start = Math.min(start + step, target);
                el.textContent = Math.round(start) + suffix;
                if(start >= target){ clearInterval(timer); el.textContent = target + suffix; }
            }, 30);
            counterIO.unobserve(el);
        });
    },{ threshold: 0.5 });

    counters.forEach(function(el){ counterIO.observe(el); });
})();
</script>
@endpush
