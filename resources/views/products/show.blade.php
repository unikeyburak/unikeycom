@php
    /* ── Görsel hazırlık ─────────────────────────────────── */
    $rawImages = $product->images;
    if (is_string($rawImages)) {
        $rawImages = json_decode($rawImages, true) ?: [];
    }
    $allImages = is_array($rawImages) ? array_values(array_filter($rawImages, 'is_string')) : [];

    // Diskte var olan görselleri filtrele, uzak URL'leri doğrudan kabul et
    $storageDisk = \Illuminate\Support\Facades\Storage::disk('public');
    $images = [];
    $imageUrls = [];
    foreach ($allImages as $img) {
        if (str_starts_with($img, 'http')) {
            $images[] = $img;
            $imageUrls[] = $img;
        } elseif ($storageDisk->exists($img)) {
            $images[] = $img;
            $imageUrls[] = $storageDisk->url($img);
        }
    }
    $firstImage = $imageUrls[0] ?? null;

    /* ── JSON alanları ───────────────────────────────────── */
    // Nested/import içerik (highlights, application_types, certifications vb.) ana kolondan okunur — çeviri kapsamı dışında.
    $techInfo    = is_array($product->technical_info)
        ? $product->technical_info
        : (json_decode($product->technical_info  ?? '{}', true) ?: []);

    // Çevrilebilir dizi alanları: mevcut dile göre; çeviri yoksa TR'ye düşer.
    $techTrans   = $product->translateArray('technical_info');
    $dosageItems = $product->translateArray('dosage_items');
    $appInfo     = $product->translateArray('application_info');
    $warningInfo = $product->translateArray('warning_info');
    $mixingInfo  = $product->translateArray('mixing_info');

    $highlights  = $techInfo['highlights'] ?? $techInfo['features'] ?? $techInfo['characteristics'] ?? [];
    $appTypes    = $techInfo['application_types'] ?? $techInfo['application'] ?? [];
    $composition = $techInfo['composition'] ?? $techInfo['content'] ?? $techInfo['contents'] ?? null;
    $packages    = is_array($product->packaging_sizes) ? $product->packaging_sizes : [];
    $productColors = is_array($product->product_colors) ? $product->product_colors : [];
    $cropApproaches = $techInfo['crop_approaches'] ?? $techInfo['agronomical_targets'] ?? $techInfo['agronomical_target'] ?? [];
    $cropApproaches = is_string($cropApproaches) ? (json_decode($cropApproaches, true) ?: []) : $cropApproaches;
    $certifications = $techInfo['certifications'] ?? $techInfo['certification'] ?? [];
    $certifications = is_string($certifications) ? (json_decode($certifications, true) ?: []) : $certifications;

    $excludeKeys = [
        'highlights','features','characteristics','application_types','application',
        'dosage','dosage_items','composition','content','contents','packages',
        'compatibility','mixing','more_info','crop_approaches','agronomical_targets',
        'agronomical_target','certifications','certification',
    ];
    $techTableRows = array_filter($techTrans, fn($v, $k) => !in_array($k, $excludeKeys) && !is_array($v) && $v !== null && $v !== '', ARRAY_FILTER_USE_BOTH);

    $hasDosage    = $product->dosage_info || !empty($dosageItems) || !empty($techInfo['dosage']);
    $hasDownloads = $product->brochure_pdf || $product->registration_certificate || $product->label_certificate;
    $hasAppInfo   = !empty($appInfo);
    $hasWarnings  = !empty($warningInfo);
    $hasMixing    = !empty($mixingInfo);
    $hasTechContent = !empty($techTableRows);
    $featuresText   = $product->translate('features_text');
    $hasFeatures    = $featuresText || !empty($highlights);

    $siteName = $settings['site_name'] ?? config('app.name', 'Unikeyterra');
    $pageTitle = ($product->translate('meta_title') ?: $product->translate('name')) . ' — ' . $siteName;
    $metaDesc  = $product->translate('meta_description') ?: $product->translate('short_description');
    $categoryName = $product->category?->translate('name') ?? '';

    // Alpine için açılacak ilk mevcut sekme
    $defaultTab = $hasFeatures ? 'characteristics'
        : ($hasDosage ? 'dosing'
        : ($hasTechContent ? 'technical'
        : ($hasAppInfo ? 'application'
        : ($hasDownloads ? 'downloads'
        : (($hasWarnings || $hasMixing) ? 'more' : 'characteristics')))));

    // Ambalaj birimlerini küçükten büyüğe sırala
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

    $colorMap = [
        'Beyaz'=>'#FFFFFF','Krem'=>'#FFFDD0','Sarı'=>'#FFD700','Açık Sarı'=>'#FFEC8B',
        'Turuncu'=>'#FF8C00','Kırmızı'=>'#DC2626','Pembe'=>'#F472B6','Mor'=>'#7C3AED',
        'Leylak'=>'#C084FC','Mavi'=>'#2563EB','Lacivert'=>'#1E3A5F','Açık Mavi'=>'#7DD3FC',
        'Turkuaz'=>'#06B6D4','Yeşil'=>'#16A34A','Açık Yeşil'=>'#86EFAC','Koyu Yeşil'=>'#166534',
        'Kahverengi'=>'#92400E','Bej'=>'#D2B48C','Gri'=>'#9CA3AF','Siyah'=>'#1F2937',
    ];
@endphp
@extends('layouts.app')

@section('title', $pageTitle)

@push('styles')
    @if($firstImage)
    <meta property="og:image" content="{{ $firstImage }}">
    @endif
    <meta property="og:title" content="{{ $product->translate('name') }}">
    <meta property="og:type" content="product">
@endpush

@section('content')
<article itemscope itemtype="https://schema.org/Product"
         x-data="{ tab: '{{ $defaultTab }}' }">

    {{-- ═══════════════════════════════════════════════════════════════
       1. YEŞİL BAŞLIK BANDI — kategori + ürün adı (tek H1)
       ═══════════════════════════════════════════════════════════════ --}}
    <div class="hero-band bg-earth-600">
        <div class="mx-auto max-w-6xl px-5">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                <div class="hidden lg:col-span-5 lg:block" aria-hidden="true"></div>
                <div class="pt-4 pb-28 lg:col-span-7 lg:pt-8 lg:pb-40">
                    @if($categoryName)
                        <span class="text-sm font-bold uppercase tracking-[0.12em] text-white/90">{{ $categoryName }}</span>
                    @endif
                    <h1 class="mt-3 text-[clamp(2.2rem,5.5vw,4rem)] font-medium leading-[1.05] tracking-tight text-white" itemprop="name">
                        {{ $product->translate('name') }}
                        @if(!empty($product->subtitle) || !empty($product->formula))
                            <span class="mt-2 block text-lg font-semibold text-leaf-300">{{ $product->subtitle ?? $product->formula }}</span>
                        @endif
                    </h1>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
       2. BEYAZ İÇERİK — sol (görsel + sertifika) / sağ (açıklama + madde)
       ═══════════════════════════════════════════════════════════════ --}}
    <main class="bg-white">
        <div class="mx-auto max-w-6xl px-5">
            <div class="grid grid-cols-1 gap-x-12 lg:grid-cols-12">

                {{-- SOL KOLON --}}
                <div class="lg:col-span-5">
                    {{-- Ürün görseli — yeşil banttan taşar --}}
                    <div class="relative -mt-40 lg:-mt-60">
                        <div class="mx-auto w-[291px] overflow-hidden rounded-[10px] bg-gradient-to-br from-leaf-50 to-leaf-100/60 p-5 shadow-xl lg:w-[374px]">
                            @if($firstImage)
                                <img src="{{ $firstImage }}" alt="{{ $product->translate('name') }}" itemprop="image"
                                     class="h-[416px] w-full object-contain lg:h-[546px]" loading="eager" decoding="async">
                            @else
                                <div class="grid h-[416px] w-full place-items-center bg-leaf-50 text-leaf-300 lg:h-[546px]">
                                    <svg class="h-24 w-24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Uygulama şekilleri --}}
                    @if(!empty($appTypes))
                        <div class="mt-7">
                            <h2 class="text-[15px] font-extrabold text-ink">{{ __('Uygulama') }}</h2>
                            <ul class="mt-3 flex flex-wrap gap-2">
                                @foreach($appTypes as $app)
                                    @php $appLabel = is_array($app) ? ($app['name'] ?? $app['label'] ?? '') : (string) $app; @endphp
                                    @if($appLabel)
                                        <li class="inline-flex items-center gap-2 rounded-full bg-leaf-100 px-3 py-1.5 text-sm font-semibold text-leaf-700">{{ $appLabel }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Agronomik hedef --}}
                    @if(!empty($cropApproaches))
                        <div class="mt-5">
                            <h2 class="text-[15px] font-extrabold text-ink">{{ __('Agronomik Hedef') }}</h2>
                            <ul class="mt-3 flex flex-wrap gap-2">
                                @foreach($cropApproaches as $ca)
                                    @php $caLabel = is_array($ca) ? ($ca['name'] ?? $ca['label'] ?? '') : (string) $ca; @endphp
                                    @if($caLabel)
                                        <li class="inline-flex items-center gap-2 rounded-full border border-hair px-3 py-1.5 text-sm font-semibold text-ink">{{ $caLabel }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Sertifikalar --}}
                    @if(!empty($certifications))
                        <div class="mt-7">
                            <h2 class="text-[15px] font-extrabold text-ink">{{ __('Sertifikalar') }}</h2>
                            <div class="mt-4 flex flex-wrap items-center gap-x-6 gap-y-4">
                                @foreach($certifications as $cert)
                                    @php
                                        $cLabel = is_array($cert) ? ($cert['name'] ?? $cert['label'] ?? '') : (string) $cert;
                                        $cIcon  = is_array($cert) ? ($cert['icon'] ?? $cert['icon_url'] ?? null) : null;
                                    @endphp
                                    @if($cIcon)
                                        <img src="{{ $cIcon }}" alt="{{ $cLabel }}" width="64" height="64" class="h-16 w-auto object-contain" loading="lazy">
                                    @elseif($cLabel)
                                        <div class="grid h-16 min-w-16 place-items-center rounded-full border-2 border-ink/70 px-3 text-center">
                                            <span class="text-[10px] font-extrabold uppercase leading-tight text-ink">{{ $cLabel }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                {{-- /SOL KOLON --}}

                {{-- SAĞ KOLON --}}
                <div class="pt-10 lg:col-span-7 lg:pt-12">
                    @if($product->translate('short_description'))
                        <div class="max-w-2xl text-[15px] leading-relaxed text-ink" itemprop="description">{!! nl2br(e($product->translate('short_description'))) !!}</div>
                    @endif

                    @if(!empty($highlights) && is_array($highlights))
                        <ul class="mt-6 max-w-2xl space-y-3">
                            @foreach($highlights as $h)
                                @php $hText = is_array($h) ? ($h['text'] ?? $h['label'] ?? $h['name'] ?? '') : (string) $h; @endphp
                                @if($hText)
                                    <li class="flex gap-3 text-[15px] text-ink"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-leaf-600" aria-hidden="true"></span>{{ $hText }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                    @if($sortedPackages->isNotEmpty() || !empty($productColors))
                        <div class="mt-10 space-y-6 border-t border-hair pt-7">
                            {{-- Renk --}}
                            @if(!empty($productColors))
                                <div class="grid grid-cols-[80px_1fr] items-start gap-x-4">
                                    <h2 class="pt-1 text-[11px] font-extrabold uppercase tracking-wide text-ink-soft">{{ __('Renk') }}</h2>
                                    <div class="flex flex-wrap gap-x-5 gap-y-3">
                                        @foreach($productColors as $color)
                                            @php
                                                $clr = is_array($color) ? ($color['name'] ?? $color['label'] ?? '') : (string) $color;
                                                $hex = $colorMap[$clr] ?? (is_array($color) ? ($color['hex'] ?? '#ccc') : '#ccc');
                                            @endphp
                                            @if($clr)
                                                <div class="flex w-9 flex-col items-center gap-1.5">
                                                    <span class="h-8 w-8 rounded-full ring-1 ring-black/10" style="background:{{ $hex }}" aria-hidden="true"></span>
                                                    <span class="text-[10px] font-semibold text-ink-soft">{{ __($clr) }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            {{-- Ambalaj --}}
                            @if($sortedPackages->isNotEmpty())
                                <div class="grid grid-cols-[80px_1fr] items-start gap-x-4">
                                    <h2 class="pt-1 text-[11px] font-extrabold uppercase tracking-wide text-ink-soft">{{ __('Ambalaj') }}</h2>
                                    <div class="flex flex-wrap gap-x-5 gap-y-3 text-leaf-600">
                                        @foreach($sortedPackages as $pLabel)
                                            <div class="flex flex-col items-center gap-1.5">
                                                <span class="flex h-12 items-end"><svg class="h-9 w-auto" viewBox="0 0 28 38" aria-hidden="true"><path d="M9 7 V5 a1.5 1.5 0 0 1 1.5 -1.5 h3 a1.5 1.5 0 0 1 1.5 1.5 V7" fill="none" stroke="currentColor" stroke-width="2"/><rect x="17" y="2" width="5" height="3.5" rx="1" fill="currentColor"/><rect x="3" y="7" width="22" height="29" rx="3.5" fill="currentColor"/><rect x="7" y="14" width="14" height="11" rx="1.5" fill="#ffffff" fill-opacity="0.85"/></svg></span>
                                                <span class="whitespace-nowrap text-[10px] font-bold text-ink">{{ __($pLabel) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- CTA --}}
                    <div class="mt-8">
                        <a href="{{ lroute('contact') }}" class="inline-flex items-center gap-2 rounded bg-leaf-600 px-6 py-3.5 text-base font-extrabold text-white transition hover:bg-leaf-700">
                            {{ __('Teklif Al / İletişime Geç') }}
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                    </div>
                </div>
                {{-- /SAĞ KOLON --}}
            </div>

            {{-- ═══════════════════════════════════════════════════════════════
               3. SEKMELER — yeşil butonlar (desktop) + akordeon (mobil), Alpine
               ═══════════════════════════════════════════════════════════════ --}}
            @php
                $tabs = collect([
                    ['id' => 'characteristics', 'label' => __('Özellikler'), 'show' => $hasFeatures],
                    ['id' => 'dosing',          'label' => __('Dozaj'), 'show' => $hasDosage],
                    ['id' => 'technical',       'label' => __('Teknik Bilgiler'), 'show' => $hasTechContent],
                    ['id' => 'application',     'label' => __('Uygulama Bilgisi'), 'show' => $hasAppInfo],
                    ['id' => 'downloads',       'label' => __('İndirmeler'), 'show' => $hasDownloads],
                    ['id' => 'more',            'label' => __('Uyarı / Karışım'), 'show' => $hasWarnings || $hasMixing],
                ])->where('show', true)->values();
            @endphp

            @if($tabs->isNotEmpty())
            <section class="py-12 lg:py-14">
                {{-- Desktop sekme şeridi --}}
                <div class="hidden flex-wrap items-center gap-2.5 lg:flex" role="tablist" aria-label="{{ __('Ürün detayları') }}">
                    @foreach($tabs as $t)
                        <button type="button" role="tab" @click="tab = '{{ $t['id'] }}'"
                                :aria-selected="tab === '{{ $t['id'] }}' ? 'true' : 'false'"
                                class="inline-flex items-center gap-2 rounded px-5 py-3 text-sm font-bold text-white transition-colors"
                                :class="tab === '{{ $t['id'] }}' ? 'bg-leaf-700' : 'bg-leaf-600 hover:bg-leaf-700'">
                            {{ $t['label'] }}
                        </button>
                    @endforeach
                    <a href="{{ lroute('contact') }}" class="inline-flex shrink-0 items-center gap-2 whitespace-nowrap rounded border-2 border-leaf-600 bg-white px-5 py-3 text-sm font-extrabold text-leaf-700 transition hover:bg-leaf-50">
                        {{ __('İletişim') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>

                {{-- Panel: ÖZELLİKLER --}}
                @if($hasFeatures)
                    <section class="border-b border-hair lg:border-0">
                        <button @click="tab = (tab === 'characteristics' ? '' : 'characteristics')" class="mt-3 flex w-full items-center justify-between rounded bg-leaf-600 px-5 py-3.5 text-left text-sm font-bold text-white lg:hidden">
                            {{ __('Özellikler') }}<svg class="h-5 w-5 transition-transform" :class="tab === 'characteristics' && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="tab === 'characteristics'" x-cloak x-transition class="pt-6 lg:pt-8">
                            @if(!empty($highlights))
                                <div class="grid grid-cols-1 gap-x-16 gap-y-3 sm:grid-cols-2">
                                    @foreach($highlights as $h)
                                        @php $hText = is_array($h) ? ($h['text'] ?? $h['label'] ?? $h['name'] ?? '') : (string) $h; @endphp
                                        @if($hText)
                                            <div class="flex gap-3 text-[15px] text-ink"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-leaf-600" aria-hidden="true"></span>{{ $hText }}</div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            @if($featuresText)
                                <div class="prose mt-6 max-w-none text-[15px] leading-relaxed text-ink-soft">{!! $featuresText !!}</div>
                            @endif
                        </div>
                    </section>
                @endif

                {{-- Panel: DOZAJ --}}
                @if($hasDosage)
                    <section class="border-b border-hair lg:border-0">
                        <button @click="tab = (tab === 'dosing' ? '' : 'dosing')" class="mt-3 flex w-full items-center justify-between rounded bg-leaf-600 px-5 py-3.5 text-left text-sm font-bold text-white lg:hidden">
                            {{ __('Dozaj') }}<svg class="h-5 w-5 transition-transform" :class="tab === 'dosing' && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="tab === 'dosing'" x-cloak x-transition class="pt-6 lg:pt-8">
                            @if(!empty($dosageItems))
                                <div class="overflow-x-auto rounded-lg ring-1 ring-hair">
                                    <table class="w-full min-w-[640px] border-collapse text-[15px]">
                                        <thead><tr class="bg-leaf-600 text-left text-white">
                                            <th class="px-5 py-3 font-bold">{{ __('Ürün') }}</th>
                                            <th class="px-5 py-3 font-bold">{{ __('Sulama') }}</th>
                                            <th class="px-5 py-3 font-bold">{{ __('Yapraktan') }}</th>
                                            <th class="px-5 py-3 font-bold">{{ __('Topraktan') }}</th>
                                            <th class="px-5 py-3 font-bold">{{ __('Uygulama Dönemi') }}</th>
                                        </tr></thead>
                                        <tbody>
                                            @foreach($dosageItems as $i => $di)
                                                <tr class="border-b border-hair {{ $i % 2 ? 'bg-leaf-500/5' : '' }}">
                                                    <td class="px-5 py-3 font-bold text-ink">{{ $di['crop'] ?? '—' }}</td>
                                                    <td class="px-5 py-3 text-ink-soft">{{ $di['sulama_dosage'] ?? '—' }}</td>
                                                    <td class="px-5 py-3 text-ink-soft">{{ $di['yapraktan_dosage'] ?? '—' }}</td>
                                                    <td class="px-5 py-3 text-ink-soft">{{ $di['topraktan_dosage'] ?? '—' }}</td>
                                                    <td class="px-5 py-3 text-ink-soft">{{ $di['application_period'] ?? ($di['notes'] ?? '—') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <p class="mt-3 text-sm text-ink-soft">* {{ __('Dozajlar genel öneridir; toprak analizi ve agronomik danışmanlık doğrultusunda ayarlanmalıdır.') }}</p>
                            @endif
                            @if($product->dosage_info)
                                <div class="prose mt-4 max-w-none text-[15px] text-ink-soft">{!! $product->dosage_info !!}</div>
                            @endif
                        </div>
                    </section>
                @endif

                {{-- Panel: TEKNİK BİLGİLER --}}
                @if($hasTechContent)
                    <section class="border-b border-hair lg:border-0">
                        <button @click="tab = (tab === 'technical' ? '' : 'technical')" class="mt-3 flex w-full items-center justify-between rounded bg-leaf-600 px-5 py-3.5 text-left text-sm font-bold text-white lg:hidden">
                            {{ __('Teknik Bilgiler') }}<svg class="h-5 w-5 transition-transform" :class="tab === 'technical' && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="tab === 'technical'" x-cloak x-transition class="pt-6 lg:pt-8">
                            <div class="overflow-hidden rounded-lg ring-1 ring-hair">
                                <table class="w-full border-collapse text-[15px]">
                                    <tbody>
                                        @foreach($techTableRows as $key => $val)
                                            <tr class="border-b border-hair last:border-0">
                                                <th class="bg-leaf-500/5 px-5 py-3 text-left font-bold text-ink">{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                                <td class="px-5 py-3 text-ink-soft">{{ $val }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Panel: UYGULAMA BİLGİSİ --}}
                @if($hasAppInfo)
                    <section class="border-b border-hair lg:border-0">
                        <button @click="tab = (tab === 'application' ? '' : 'application')" class="mt-3 flex w-full items-center justify-between rounded bg-leaf-600 px-5 py-3.5 text-left text-sm font-bold text-white lg:hidden">
                            {{ __('Uygulama Bilgisi') }}<svg class="h-5 w-5 transition-transform" :class="tab === 'application' && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="tab === 'application'" x-cloak x-transition class="grid grid-cols-1 gap-6 pt-6 sm:grid-cols-2 lg:pt-8">
                            @foreach($appInfo as $ai)
                                <div class="rounded-2xl bg-white p-5 ring-1 ring-hair">
                                    @if(!empty($ai['title']))<h4 class="font-extrabold text-ink">{{ $ai['title'] }}</h4>@endif
                                    @if(!empty($ai['description']))<p class="mt-2 text-[15px] leading-relaxed text-ink-soft">{{ $ai['description'] }}</p>@endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Panel: İNDİRMELER --}}
                @if($hasDownloads)
                    <section class="border-b border-hair lg:border-0">
                        <button @click="tab = (tab === 'downloads' ? '' : 'downloads')" class="mt-3 flex w-full items-center justify-between rounded bg-leaf-600 px-5 py-3.5 text-left text-sm font-bold text-white lg:hidden">
                            {{ __('İndirmeler') }}<svg class="h-5 w-5 transition-transform" :class="tab === 'downloads' && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="tab === 'downloads'" x-cloak x-transition class="pt-6 lg:pt-8">
                            <ul class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                @foreach([
                                    ['file' => $product->brochure_pdf, 'label' => __('Ürün Broşürü')],
                                    ['file' => $product->registration_certificate, 'label' => __('Tescil Belgesi')],
                                    ['file' => $product->label_certificate, 'label' => __('Etiket Belgesi')],
                                ] as $dl)
                                    @if($dl['file'])
                                        <li><a href="{{ asset('storage/' . ltrim($dl['file'], '/')) }}" target="_blank" rel="noopener" class="group flex items-center gap-3 rounded-lg p-4 ring-1 ring-hair transition hover:bg-leaf-500/5 hover:ring-leaf-500">
                                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded bg-leaf-500/10 text-leaf-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg></span>
                                            <span class="block font-bold text-ink">{{ $dl['label'] }}</span>
                                        </a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </section>
                @endif

                {{-- Panel: UYARI / KARIŞIM --}}
                @if($hasWarnings || $hasMixing)
                    <section>
                        <button @click="tab = (tab === 'more' ? '' : 'more')" class="mt-3 flex w-full items-center justify-between rounded bg-leaf-600 px-5 py-3.5 text-left text-sm font-bold text-white lg:hidden">
                            {{ __('Uyarı / Karışım') }}<svg class="h-5 w-5 transition-transform" :class="tab === 'more' && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="tab === 'more'" x-cloak x-transition class="grid grid-cols-1 gap-x-16 gap-y-6 pt-6 sm:grid-cols-2 lg:pt-8">
                            @if($hasMixing)
                                <div>
                                    <h3 class="mb-2 font-extrabold text-ink">{{ __('Karışım Bilgisi') }}</h3>
                                    <ul class="space-y-2 text-[15px] leading-relaxed text-ink-soft">
                                        @foreach($mixingInfo as $mi)
                                            @php
                                                $miTitle = is_array($mi) ? ($mi['title'] ?? $mi['product_name'] ?? null) : null;
                                                $miDesc  = is_array($mi) ? ($mi['description'] ?? $mi['notes'] ?? '') : (string) $mi;
                                            @endphp
                                            @if($miTitle || $miDesc !== '')
                                                <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-leaf-600" aria-hidden="true"></span><span>@if($miTitle)<strong class="text-ink">{{ $miTitle }}:</strong> @endif{{ $miDesc }}</span></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if($hasWarnings)
                                <div>
                                    <h3 class="mb-2 font-extrabold text-ink">{{ __('Uyarı & Saklama') }}</h3>
                                    <ul class="space-y-2 text-[15px] leading-relaxed text-ink-soft">
                                        @foreach($warningInfo as $wi)
                                            @php
                                                $wiTitle = is_array($wi) ? ($wi['title'] ?? null) : null;
                                                $wiDesc  = is_array($wi) ? ($wi['description'] ?? $wi['warning'] ?? '') : (string) $wi;
                                            @endphp
                                            @if($wiTitle || $wiDesc !== '')
                                                <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-amber-500" aria-hidden="true"></span><span>@if($wiTitle)<strong class="text-ink">{{ $wiTitle }}:</strong> @endif{{ $wiDesc }}</span></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </section>
                @endif
            </section>
            @endif
        </div>
    </main>

    {{-- ═══════════════════════════════════════════════════════════════
       4. AGRONOMİ (MOA) — yeşil bant
       ═══════════════════════════════════════════════════════════════ --}}
    <section class="relative bg-earth-600">
        <div class="pointer-events-none absolute left-1/2 top-6 -translate-x-1/2 text-center lg:top-8">
            <span class="font-script text-3xl text-white/90 lg:text-4xl">{{ __('Agronomi Bilgisi') }}</span>
            <svg class="mx-auto mt-1 h-8 w-8 text-white/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 4v14M6 12l6 6 6-6"/></svg>
        </div>
        <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-8 px-5 pb-14 pt-28 lg:grid-cols-2 lg:gap-14 lg:pb-20 lg:pt-32">
            <div class="overflow-hidden rounded-md lg:max-w-md">
                <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?auto=format&fit=crop&w=900&q=80" alt="{{ __('Agronomi') }}" class="aspect-[4/3] w-full object-cover" loading="lazy" decoding="async">
            </div>
            <div>
                <h2 class="text-3xl font-bold text-white lg:text-4xl">{{ __('Bilime dayalı bitki besleme') }}</h2>
                <p class="mt-4 max-w-md text-[15px] leading-relaxed text-white/80">{{ __('Ürünlerimizin etki mekanizması saha denemeleriyle doğrulanmıştır. Doğru ürünü, doğru dozda ve doğru dönemde kullanmak için agronomi ekibimiz yanınızda.') }}</p>
                <a href="{{ lroute('about') }}" class="mt-6 inline-flex items-center gap-2 text-[15px] font-bold text-white underline underline-offset-4 transition hover:text-white/80">{{ __('Yaklaşımımızı keşfedin') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════
       5. İLGİLİ ÜRÜNLER
       ═══════════════════════════════════════════════════════════════ --}}
    @if(isset($relatedProducts) && $relatedProducts && count($relatedProducts) > 0)
    <section class="bg-leaf-500/5 py-14 lg:py-20">
        <div class="mx-auto max-w-6xl px-5">
            <div class="mb-10 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <span class="text-sm font-bold uppercase tracking-[0.12em] text-leaf-600">{{ __('Daha Fazla Ürün') }}</span>
                    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink lg:text-4xl">{{ __('İlgili Ürünler') }}</h2>
                </div>
                <a href="{{ lroute('products.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-leaf-700 transition-all hover:gap-2.5">{{ __('Tüm Ürünleri Gör') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
            </div>
            <div class="grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4">
                @foreach($relatedProducts as $related)
                    @php
                        $rImgs = is_array($related->images) ? $related->images : (json_decode($related->images ?? '[]', true) ?: []);
                        $rFirst = collect($rImgs)->first(fn($i) => is_string($i));
                        $rUrl = $rFirst ? (str_starts_with($rFirst, 'http') ? $rFirst : asset('storage/' . $rFirst)) : null;
                    @endphp
                    <a href="{{ lroute('products.show', $related->slug) }}" class="group block overflow-hidden rounded-2xl bg-white ring-1 ring-hair transition-all hover:-translate-y-1 hover:ring-leaf-400">
                        <div class="flex aspect-square items-center justify-center overflow-hidden bg-leaf-50/40 p-4">
                            @if($rUrl)
                                <img src="{{ $rUrl }}" alt="{{ $related->translate('name') }}" class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-105" loading="lazy">
                            @else
                                <svg class="h-16 w-16 text-leaf-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/></svg>
                            @endif
                        </div>
                        <div class="p-4">
                            @if($related->category)
                                <span class="text-xs font-semibold uppercase tracking-wider text-leaf-600">{{ $related->category?->translate('name') }}</span>
                            @endif
                            <h3 class="mt-1 line-clamp-2 font-extrabold text-ink transition group-hover:text-leaf-700">{{ $related->translate('name') }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════
       6. CTA BANDI — Teklif Al
       ═══════════════════════════════════════════════════════════════ --}}
    <section class="bg-gradient-to-br from-earth-900 to-earth-700 py-16 lg:py-20">
        <div class="mx-auto max-w-3xl px-5 text-center">
            <h2 class="text-3xl font-extrabold text-white lg:text-4xl">{{ __('Bu ürün hakkında bilgi mi istiyorsunuz?') }}</h2>
            <p class="mt-4 text-lg text-white/80">{{ __('Uzman ekibimiz size detaylı teknik bilgi, fiyat teklifi ve uygulama desteği sunmak için hazır.') }}</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ lroute('contact') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-8 py-4 font-extrabold text-leaf-700 shadow-lg transition hover:bg-leaf-50">
                    {{ __('Teklif Al') }} <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
                @if($settings['contact_phone'] ?? null)
                    <a href="tel:{{ preg_replace('/[^+0-9]/', '', $settings['contact_phone']) }}" class="inline-flex items-center gap-2 rounded-xl border-2 border-white/30 bg-white/10 px-8 py-4 font-bold text-white backdrop-blur transition hover:bg-white/20">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $settings['contact_phone'] }}
                    </a>
                @endif
            </div>
        </div>
    </section>

</article>
@endsection
