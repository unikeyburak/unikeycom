@php
    /* ── Görsel hazırlık ─────────────────────────────────── */
    $rawImages = $product->images;
    if (is_string($rawImages)) {
        $rawImages = json_decode($rawImages, true) ?: [];
    }
    $allImages = is_array($rawImages) ? array_values(array_filter($rawImages, 'is_string')) : [];
    $storageDisk = \Illuminate\Support\Facades\Storage::disk('public');
    $imageUrls = [];
    foreach ($allImages as $img) {
        if (str_starts_with($img, 'http')) { $imageUrls[] = $img; }
        elseif ($storageDisk->exists($img)) { $imageUrls[] = $storageDisk->url($img); }
    }
    $firstImage = $imageUrls[0] ?? null;

    /* ── JSON alanları (çeviri-farkında) ─────────────────── */
    $techInfo    = is_array($product->technical_info)
        ? $product->technical_info
        : (json_decode($product->technical_info ?? '{}', true) ?: []);
    $techTrans   = $product->translateArray('technical_info');
    $dosageItems = $product->translateArray('dosage_items');
    $warningInfo = $product->translateArray('warning_info');
    $mixingInfo  = $product->translateArray('mixing_info');
    $packages    = is_array($product->packaging_sizes) ? $product->packaging_sizes : [];
    $productColors = is_array($product->product_colors) ? $product->product_colors : [];

    $excludeKeys = [
        'highlights','features','characteristics','application_types','application',
        'dosage','dosage_items','composition','content','contents','packages',
        'compatibility','mixing','more_info','crop_approaches','agronomical_targets',
        'agronomical_target','certifications','certification',
    ];
    $techTableRows = array_filter($techTrans, fn($v, $k) => !in_array($k, $excludeKeys) && !is_array($v) && $v !== null && $v !== '', ARRAY_FILTER_USE_BOTH);

    /* ── Metin/başlık ────────────────────────────────────── */
    $pName        = $product->translate('name');
    $shortDesc    = trim(strip_tags($product->translate('short_description') ?? ''));
    if ($shortDesc !== '' && $pName) {
        $shortDesc = trim(\Illuminate\Support\Str::of($shortDesc)->replaceFirst($pName, ''));
        $shortDesc = trim(\Illuminate\Support\Str::of($shortDesc)->replaceFirst(\Illuminate\Support\Str::upper($pName), ''));
    }
    $featuresText = $product->translate('features_text');
    $categoryName = $product->category?->translate('name') ?? '';
    $siteName     = $settings['site_name'] ?? config('app.name', 'Unikeyterra');
    $pageTitle    = ($product->translate('meta_title') ?: $pName) . ' — ' . $siteName;
    $metaDesc     = $product->translate('meta_description') ?: $product->translate('short_description');

    /* ── Ambalaj sıralama (küçükten büyüğe) ──────────────── */
    $unitPriority = function ($label) {
        $l = mb_strtolower($label);
        if (preg_match('/\bml\b|\bcc\b/', $l)) return 0;
        if (preg_match('/\bgr\b|\bg\b(?!a)/', $l)) return 1;
        if (preg_match('/\bkg\b/', $l)) return 2;
        if (preg_match('/\blt\b|\bl\b(?!a)/', $l)) return 3;
        return 4;
    };
    $sortedPackages = collect($packages)
        ->map(fn($pkg) => is_array($pkg) ? ($pkg['size'] ?? $pkg['label'] ?? $pkg['name'] ?? '') : (string) $pkg)
        ->filter()
        ->sortBy(fn($label) => [$unitPriority($label), (int) preg_replace('/[^0-9]/', '', $label) ?: 0])
        ->values();

    /* Ambalaj formatı — boyut+tipe göre 6 silüet:
       katı: sachet (gr poşet) | sack (kg torba) | bigbag (1000kg FIBC)
       sıvı: bottle (cc şişe) | jerrican (L bidon) | ibc (1000L tank) */
    $pkgFormat = function ($label) {
        $l = mb_strtolower(trim($label));
        $isLiquid = (bool) preg_match('/\bcc\b|\bml\b|\bl\b|\blt\b|litre|ibc/', $l);
        if ($isLiquid) {
            if (str_contains($l, '1000')) return 'ibc';
            if (preg_match('/\bcc\b|\bml\b/', $l)) return 'bottle';
            return 'jerrican';
        }
        if (str_contains($l, '1000')) return 'bigbag';
        if (preg_match('/\bgr?\b/', $l) && !str_contains($l, 'kg')) return 'sachet';
        return 'sack';
    };
    $pkgFormatLabel = ['sachet'=>'Poşet','sack'=>'Torba','bigbag'=>'Big Bag','bottle'=>'Şişe','jerrican'=>'Bidon','ibc'=>'IBC Tank'];
    /* küçük paket → küçük ikon, büyük paket → büyük ikon (görsel boyut hissi).
       Inline style: Tailwind JIT'e bağımlı olmaz (PHP string'inden sınıf taranmıyor). */
    $pkgIconSize = [
        'sachet'=>'width:1.9rem;height:1.9rem','bottle'=>'width:1.9rem;height:1.9rem',
        'sack'=>'width:2.5rem;height:2.5rem','jerrican'=>'width:2.5rem;height:2.5rem',
        'bigbag'=>'width:3rem;height:3rem','ibc'=>'width:3rem;height:3rem',
    ];

    $colorMap = [
        'Beyaz'=>'#FFFFFF','Krem'=>'#FFFDD0','Sarı'=>'#FFD700','Açık Sarı'=>'#FFEC8B',
        'Turuncu'=>'#FF8C00','Kırmızı'=>'#DC2626','Pembe'=>'#F472B6','Mor'=>'#7C3AED',
        'Leylak'=>'#C084FC','Mavi'=>'#2563EB','Lacivert'=>'#1E3A5F','Açık Mavi'=>'#7DD3FC',
        'Turkuaz'=>'#06B6D4','Yeşil'=>'#16A34A','Açık Yeşil'=>'#86EFAC','Koyu Yeşil'=>'#166534',
        'Kahverengi'=>'#92400E','Bej'=>'#D2B48C','Gri'=>'#9CA3AF','Siyah'=>'#1F2937',
    ];
    $hasCerts = $product->brochure_pdf || $product->registration_certificate || $product->label_certificate;
@endphp
@extends('layouts.app')

@section('title', $pageTitle)

{{-- Not: og:title/og:image/og:description + <title> zaten partials/seo-meta.blade.php
     tarafından $meta (getSeoMeta) üzerinden basılıyor; burada tekrar basmıyoruz. --}}

@section('content')
<article itemscope itemtype="https://schema.org/Product">
{{-- ══ ÜRÜN DETAY — solda sticky görsel, sağda kayan detay (tab yok) ══ --}}
<div class="bg-gradient-to-b from-leaf-50 to-white" style="background-size: 100% 420px; background-repeat: no-repeat;">
    <div class="mx-auto max-w-6xl px-5 pb-16 pt-6 lg:pb-20">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="flex flex-wrap items-center gap-2 pb-6 pt-2 text-sm text-ink-soft">
            <a href="{{ route('home') }}" class="transition hover:text-ink">{{ __('Ana Sayfa') }}</a>
            <span aria-hidden="true">/</span>
            <a href="{{ lroute('products.index') }}" class="transition hover:text-ink">{{ __('Ürünler') }}</a>
            @if($product->category)
                <span aria-hidden="true">/</span>
                <a href="{{ lroute('products.category', $product->category->slug) }}" class="transition hover:text-ink">{{ $categoryName }}</a>
            @endif
            <span aria-hidden="true">/</span>
            <span class="font-bold text-ink">{{ $pName }}</span>
        </nav>

        <div class="grid items-start gap-10 lg:grid-cols-12 lg:gap-14">

            {{-- ── SOL: sticky ürün görseli ─────────────────────── --}}
            <div class="lg:sticky lg:top-6 lg:col-span-5 lg:self-start">
                <div class="relative rounded-3xl bg-gradient-to-b from-white to-leaf-50 p-8 text-center ring-1 ring-hair lg:p-10">
                    @if($categoryName)
                        <span class="absolute left-4 top-4 rounded-full bg-leaf-100 px-3 py-1.5 text-xs font-extrabold uppercase tracking-wide text-leaf-700">{{ $categoryName }}</span>
                    @endif
                    <div class="mx-auto flex aspect-[3/4] max-w-[340px] items-center justify-center pt-4">
                        @if($firstImage)
                            <img src="{{ $firstImage }}" alt="{{ $pName }}" itemprop="image"
                                 class="max-h-full max-w-full object-contain drop-shadow-[0_24px_32px_rgba(20,51,32,0.18)]" loading="eager" decoding="async">
                        @else
                            <svg class="h-24 w-24 text-leaf-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/></svg>
                        @endif
                    </div>
                    @if($product->active_ingredient)
                        <div class="mt-5 flex items-center justify-center gap-2 text-[13px] font-bold text-ink-soft">
                            <svg class="h-4 w-4 text-leaf-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/></svg>
                            {{ $product->active_ingredient }}
                        </div>
                    @endif
                </div>
                <div class="mt-4 flex flex-wrap gap-2.5">
                    <a href="{{ lroute('contact') }}?product={{ $product->slug }}" class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-leaf-600 px-5 py-3.5 text-[15px] font-extrabold text-white transition hover:bg-leaf-700">{{ __('Teklif Al') }}</a>
                    @if($product->brochure_pdf)
                        <a href="{{ asset('storage/' . ltrim($product->brochure_pdf, '/')) }}" target="_blank" rel="noopener" class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-white px-5 py-3.5 text-[15px] font-extrabold text-leaf-700 ring-2 ring-inset ring-leaf-200 transition hover:bg-leaf-50">{{ __('Broşür (PDF)') }}</a>
                    @endif
                </div>
                @if($product->registration_certificate || $product->label_certificate)
                    <div class="mt-2.5 flex flex-wrap gap-x-5 gap-y-2 text-sm">
                        @if($product->registration_certificate)
                            <a href="{{ asset('storage/' . ltrim($product->registration_certificate, '/')) }}" target="_blank" rel="noopener" class="font-semibold text-leaf-700 underline underline-offset-2 transition hover:text-leaf-600">{{ __('Tescil Belgesi') }}</a>
                        @endif
                        @if($product->label_certificate)
                            <a href="{{ asset('storage/' . ltrim($product->label_certificate, '/')) }}" target="_blank" rel="noopener" class="font-semibold text-leaf-700 underline underline-offset-2 transition hover:text-leaf-600">{{ __('Etiket Belgesi') }}</a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- ── SAĞ: kayan detay bölümleri ───────────────────── --}}
            <div class="flex flex-col gap-10 lg:col-span-7">

                {{-- Başlık + açıklama --}}
                <div data-sr>
                    @if($categoryName)
                        <span class="text-sm font-extrabold uppercase tracking-[0.12em] text-leaf-600">{{ $categoryName }}</span>
                    @endif
                    <h1 class="mt-2.5 text-[clamp(2rem,3.6vw,2.9rem)] font-extrabold leading-[1.1] tracking-tight text-ink" itemprop="name">{{ $pName }}</h1>
                    @if(!empty($product->formulation))
                        <p class="mt-2 text-lg font-bold text-leaf-600">{{ $product->formulation }}</p>
                    @endif
                    @if($shortDesc)
                        <p class="mt-4 text-base leading-relaxed text-ink-soft" itemprop="description">{!! nl2br(e($shortDesc)) !!}</p>
                    @endif
                    @if($featuresText)
                        <div class="prose mt-4 max-w-none text-[15px] leading-relaxed text-ink-soft">{!! $featuresText !!}</div>
                    @endif
                </div>

                {{-- Renk --}}
                @if(!empty($productColors))
                    <div data-sr>
                        <h2 class="mb-3.5 flex items-center gap-2.5 text-xl font-extrabold text-ink"><span class="h-2.5 w-2.5 rounded bg-leaf-400"></span>{{ __('Renk') }}</h2>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach($productColors as $color)
                                @php
                                    $clr = is_array($color) ? ($color['name'] ?? $color['label'] ?? '') : (string) $color;
                                    $hex = $colorMap[$clr] ?? (is_array($color) ? ($color['hex'] ?? '#ccc') : '#ccc');
                                @endphp
                                @if($clr)
                                    <span class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-bold text-ink ring-1 ring-hair">
                                        <span class="h-3.5 w-3.5 rounded-full ring-1 ring-inset ring-black/10" style="background: {{ $hex }}"></span>{{ __($clr) }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Ambalaj — her seçili boyut kendi format ikonuyla (torba / Big Bag / bidon / IBC) --}}
                @if($sortedPackages->isNotEmpty())
                    <div data-sr>
                        <h2 class="mb-3.5 flex items-center gap-2.5 text-xl font-extrabold text-ink"><span class="h-2.5 w-2.5 rounded bg-leaf-400"></span>{{ __('Ambalaj') }}</h2>
                        <div class="grid grid-cols-3 gap-2.5 sm:grid-cols-4 md:grid-cols-5">
                            @foreach($sortedPackages as $pLabel)
                                @php $fmt = $pkgFormat($pLabel); @endphp
                                <div class="flex flex-col items-center gap-1.5 rounded-xl bg-white p-3 text-center ring-1 ring-hair transition hover:-translate-y-0.5 hover:shadow-md hover:ring-leaf-400">
                                    <span class="flex h-12 w-12 items-end justify-center text-leaf-600">
                                        <span class="flex items-end justify-center" style="{{ $pkgIconSize[$fmt] ?? 'width:2.5rem;height:2.5rem' }}">@include('products.partials.pkg-icon', ['type' => $fmt])</span>
                                    </span>
                                    <span class="text-sm font-extrabold leading-none text-leaf-700">{{ __($pLabel) }}</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wide text-ink-soft">{{ __($pkgFormatLabel[$fmt]) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Dozaj — kültür bazlı akordeon (ilk açık) --}}
                @if(!empty($dosageItems))
                    <div data-sr>
                        <h2 class="mb-3.5 flex items-center gap-2.5 text-xl font-extrabold text-ink"><span class="h-2.5 w-2.5 rounded bg-leaf-400"></span>{{ __('Dozaj') }}</h2>
                        <div x-data="{ open: 0 }" class="border-t border-hair">
                            @foreach($dosageItems as $i => $row)
                                @php
                                    $doses = [];
                                    if (!empty($row['sulama_dosage'])    && $row['sulama_dosage']    !== '–') $doses[] = [__('Sulama'),    $row['sulama_dosage']];
                                    if (!empty($row['yapraktan_dosage'])  && $row['yapraktan_dosage']  !== '–') $doses[] = [__('Yapraktan'), $row['yapraktan_dosage']];
                                    if (!empty($row['topraktan_dosage'])  && $row['topraktan_dosage']  !== '–') $doses[] = [__('Topraktan'), $row['topraktan_dosage']];
                                    $period = $row['application_period'] ?? ($row['notes'] ?? '');
                                @endphp
                                <div class="border-b border-hair">
                                    <button type="button" @click="open = (open === {{ $i }} ? -1 : {{ $i }})" :aria-expanded="open === {{ $i }}"
                                            class="flex w-full items-center justify-between gap-4 py-4 text-left">
                                        <span class="text-base font-extrabold text-ink">{{ $row['crop'] ?? '' }}</span>
                                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full text-white transition-colors" :class="open === {{ $i }} ? 'bg-ink' : 'bg-leaf-400'">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path :d="open === {{ $i }} ? 'M5 12h14' : 'M5 12h14M12 5v14'"/></svg>
                                        </span>
                                    </button>
                                    <div x-show="open === {{ $i }}" x-cloak style="{{ $i === 0 ? '' : 'display:none' }}">
                                        <div class="pb-5">
                                            @if($period)<p class="mb-3 text-sm leading-relaxed text-ink-soft">{{ $period }}</p>@endif
                                            @if(!empty($doses))
                                                <ul class="flex flex-col gap-2.5">
                                                    @foreach($doses as [$dLabel, $dVal])
                                                        <li class="flex items-baseline gap-2.5 text-[15px] text-ink"><span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-leaf-400"></span><span><strong class="font-extrabold">{{ $dLabel }}:</strong> {{ $dVal }}</span></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($product->dosage_info)
                            <div class="prose mt-3 max-w-none text-[13px] leading-relaxed text-ink-soft">{!! $product->dosage_info !!}</div>
                        @endif
                        <p class="mt-2.5 text-[13px] leading-relaxed text-ink-soft">* {{ __('Dozajlar genel öneridir; toprak analizi ve agronomik danışmanlık doğrultusunda ayarlanmalıdır.') }}</p>
                    </div>
                @endif

                {{-- İçerik (kompozisyon) — besin adları çip ızgarası (değer varsa yeşil rozet) --}}
                @if(!empty($techTableRows))
                    <div data-sr>
                        <h2 class="mb-3.5 flex items-center gap-2.5 text-xl font-extrabold text-ink"><span class="h-2.5 w-2.5 rounded bg-leaf-400"></span>{{ __('İçerik') }}</h2>
                        <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-2">
                            @foreach($techTableRows as $label => $value)
                                <span class="flex items-baseline gap-2.5 rounded-xl bg-white px-4 py-3 text-sm font-bold text-ink ring-1 ring-hair">
                                    <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-leaf-400"></span>
                                    <span class="flex-1">{{ ucfirst(str_replace('_', ' ', $label)) }}</span>
                                    @if($value !== null && $value !== '')<span class="shrink-0 font-extrabold text-leaf-700">{{ $value }}</span>@endif
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Karışım + Uyarılar --}}
                @if(!empty($mixingInfo) || !empty($warningInfo))
                    <div data-sr class="grid gap-4 sm:grid-cols-2">
                        @if(!empty($mixingInfo))
                            <div class="rounded-xl bg-leaf-50 p-5">
                                <h3 class="flex items-center gap-2 text-[15px] font-extrabold text-leaf-700">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M8 2h8M12 2v7M5 22h14a2 2 0 0 0 1.84-2.75L15 9H9L3.16 19.25A2 2 0 0 0 5 22Z"/></svg>{{ __('Karışım Bilgileri') }}
                                </h3>
                                <ul class="mt-2.5 space-y-1.5 text-sm leading-relaxed text-ink-soft">
                                    @foreach($mixingInfo as $mi)
                                        @php
                                            $miTitle = is_array($mi) ? ($mi['title'] ?? $mi['product_name'] ?? null) : null;
                                            $miDesc  = is_array($mi) ? ($mi['description'] ?? $mi['notes'] ?? '') : (string) $mi;
                                        @endphp
                                        @if($miTitle || $miDesc !== '')
                                            <li>@if($miTitle)<strong class="text-ink">{{ $miTitle }}:</strong> @endif{{ $miDesc }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(!empty($warningInfo))
                            <div class="rounded-xl bg-orange-50 p-5">
                                <h3 class="flex items-center gap-2 text-[15px] font-extrabold text-orange-800">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.46 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4M12 17h.01"/></svg>{{ __('Uyarılar & Depolama') }}
                                </h3>
                                <ul class="mt-2.5 space-y-1.5 text-sm leading-relaxed text-ink-soft">
                                    @foreach($warningInfo as $wi)
                                        @php
                                            $wiTitle = is_array($wi) ? ($wi['title'] ?? null) : null;
                                            $wiDesc  = is_array($wi) ? ($wi['description'] ?? $wi['warning'] ?? '') : (string) $wi;
                                        @endphp
                                        @if($wiTitle || $wiDesc !== '')
                                            <li>@if($wiTitle)<strong class="text-ink">{{ $wiTitle }}:</strong> @endif{{ $wiDesc }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Benzer ürünler --}}
@if($relatedProducts->isNotEmpty())
<section class="bg-leaf-500/5 py-16">
    <div class="mx-auto max-w-6xl px-5">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div>
                <span class="text-sm font-bold uppercase tracking-[0.14em] text-leaf-600">{{ __('Daha Fazla Ürün') }}</span>
                <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-ink lg:text-3xl">{{ __('Benzer Ürünler') }}</h2>
            </div>
            <a href="{{ lroute('products.index') }}" class="inline-flex shrink-0 items-center gap-1.5 text-[15px] font-bold text-leaf-700 transition hover:text-leaf-600">{{ __('Tüm Ürünler') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
            @foreach($relatedProducts as $rel)
                @include('products.partials.card', ['product' => $rel])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA bandı --}}
<section class="bg-earth-700">
    <div class="mx-auto flex max-w-6xl flex-col items-center gap-8 px-5 py-12 text-center lg:flex-row lg:justify-between lg:py-14 lg:text-left">
        <div class="max-w-2xl">
            <h2 class="text-2xl font-extrabold text-white lg:text-[28px]">{{ __('Bu ürün hakkında bilgi almak ister misiniz?') }}</h2>
            <p class="mt-3 text-base leading-relaxed text-white/80">{{ __('Uzman ekibimiz detaylı teknik bilgi, fiyat teklifi ve uygulama desteği için hazır.') }}</p>
        </div>
        <a href="{{ lroute('contact') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded bg-leaf-500 px-7 py-3.5 text-base font-extrabold text-white transition hover:bg-leaf-600">
            {{ __('Teklif İste') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    </div>
</section>
</article>

@push('scripts')
<script>
// Kayan bölümler için hafif scroll-reveal (Alpine gerekmez; prefers-reduced-motion'a saygılı)
(function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    var els = Array.prototype.slice.call(document.querySelectorAll('[data-sr]'));
    els.forEach(function (el) {
        el.style.transition = 'opacity .7s cubic-bezier(.2,.7,.2,1), transform .7s cubic-bezier(.2,.7,.2,1)';
        el.style.opacity = '0';
        el.style.transform = 'translateY(28px)';
    });
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.style.opacity = '1'; e.target.style.transform = 'none'; io.unobserve(e.target); }
        });
    }, { rootMargin: '0px 0px -60px 0px' });
    els.forEach(function (el) { io.observe(el); });
    setTimeout(function () { els.forEach(function (el) { el.style.opacity = '1'; el.style.transform = 'none'; }); }, 2600);
})();
</script>
@endpush

@endsection
