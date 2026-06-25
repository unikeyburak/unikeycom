@extends('layouts.app')

@section('title', $settings['home_meta_title'] ?? ($settings['site_name'] ?? config('app.name')))
@section('meta_description', $settings['home_meta_description'] ?? ($settings['site_description'] ?? ''))

@php
    // Atom çekirdeği: her zaman sabit yaprak görseli (site logosu header'da gösterilir, atomda değil)
    $atomLogo = asset('images/leaf.png');
    $brandName = $settings['site_name'] ?? config('app.name');

    // Öne çıkan ürün (vitrin) — varsa ilkini al
    $spotlight = $featuredProducts->first();
    $spotlightImage = ($spotlight && is_array($spotlight->images) && count($spotlight->images))
        ? $spotlight->images[0] : null;

    // Editoryal sütun görselleri (admin görseli yoksa nötr fallback)
    $pillarImages = [
        'https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1500651230702-0e2d8a49d4ad?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=900&q=80',
    ];
@endphp

@section('content')

{{-- =========================================================
     1. HERO — yeşil "earth" bant (header'la birleşik), oval alt kenar
     ========================================================= --}}
<div class="hero-band -mt-px bg-earth-600">
    <div class="mx-auto max-w-6xl px-5 pb-20 pt-6 lg:pb-28 lg:pt-10">
        <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-12">
            <div>
                <span class="sr in text-sm font-bold uppercase tracking-[0.12em] text-leaf-300">{{ __('Üreticiden Üreticiye') }}</span>
                @php
                    // Her satır tek bir çevrilebilir ifade; kelimelere render anında bölünür
                    // (animasyon için .hw + artan --i). Böylece her dil kendi kelime sırasıyla çevrilebilir.
                    $heroLines = [__('Sağlıklı toprak,'), __('güçlü mahsul,'), __('daha iyi hasat.')];
                    $hwIndex = 0;
                @endphp
                <h1 class="mt-3 text-[clamp(2.4rem,5vw,3.9rem)] font-medium leading-[1.05] tracking-tight text-white">
                    @foreach($heroLines as $li => $line)
                        @foreach(preg_split('/\s+/', trim($line)) as $word)<span class="hw" style="--i:{{ $hwIndex++ }}">{{ $word }}</span> @endforeach
                        @if($li < count($heroLines) - 1)<br>@endif
                    @endforeach
                </h1>
                <p class="sr mt-5 max-w-md text-[17px] leading-relaxed text-white/85" style="transition-delay:.16s">
                    {{ __('Unikeyterra; biyostimülantlar, sıvı gübreler ve mikro element çözümleriyle bitkinin tüm gelişim dönemlerinde yanınızda. Proaktif bitki besleme ile verimi ve kaliteyi birlikte yükseltin.') }}
                </p>
                <div class="sr mt-8 flex flex-col gap-3 sm:flex-row" style="transition-delay:.24s">
                    <a href="{{ lroute('products.index') }}" class="inline-flex items-center justify-center gap-2 rounded bg-white px-6 py-3.5 text-base font-extrabold text-leaf-700 transition hover:bg-leaf-50">
                        {{ __('Ürünleri Keşfet') }}
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="{{ lroute('contact') }}" class="inline-flex items-center justify-center gap-2 rounded border-2 border-white/40 bg-white/10 px-6 py-3.5 text-base font-extrabold text-white backdrop-blur transition hover:bg-white/20">
                        {{ __('İletişime Geç') }}
                    </a>
                </div>
            </div>
            <div class="sr-r relative flex items-center justify-center py-6 lg:py-0" style="transition-delay:.12s">
                <div class="atom" role="img" aria-label="{{ __('N, P ve K besinlerinin çekirdek etrafında döndüğü animasyonlu görsel') }}">
                    <span class="atom__nucleus"><img src="{{ $atomLogo }}" alt="{{ $brandName }}"></span>
                    <div class="orbit" style="--t:0deg; --f:.42; --d:7s"><span class="orbit__ring"></span><div class="orbit__flat"><div class="orbit__spin"><div class="orbit__e"><div class="orbit__despin"><div class="orbit__deflat"><div class="orbit__chip" style="background:#2f6a2c">N</div></div></div></div></div></div></div>
                    <div class="orbit" style="--t:60deg; --f:.42; --d:9s"><span class="orbit__ring"></span><div class="orbit__flat"><div class="orbit__spin"><div class="orbit__e"><div class="orbit__despin"><div class="orbit__deflat"><div class="orbit__chip" style="background:#0e7490">P</div></div></div></div></div></div></div>
                    <div class="orbit" style="--t:-60deg; --f:.42; --d:11s"><span class="orbit__ring"></span><div class="orbit__flat"><div class="orbit__spin"><div class="orbit__e"><div class="orbit__despin"><div class="orbit__deflat"><div class="orbit__chip" style="background:#84cc16">K</div></div></div></div></div></div></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =========================================================
     2. MANİFESTO
     ========================================================= --}}
<section class="mx-auto max-w-5xl px-5 py-20 text-center lg:py-28">
    <span class="sr text-sm font-bold uppercase tracking-[0.14em] text-leaf-600">{{ __('Neden Unikeyterra') }}</span>
    <p class="sr mt-5 text-[clamp(1.55rem,3.3vw,2.5rem)] font-medium leading-[1.32] tracking-tight text-ink" style="text-wrap:balance;transition-delay:.08s">
        {{ __('Toprağın ve bitkinin doğal potansiyelini açığa çıkararak, üreticinin') }}
        <span class="text-leaf-600">{{ __('daha az girdiyle daha çok hasat') }}</span> {{ __('almasını sağlıyoruz.') }}
    </p>
</section>

{{-- =========================================================
     3. YAKLAŞIM — editoryal sütunlar
     ========================================================= --}}
<section class="mx-auto max-w-6xl px-5">
    {{-- 01 --}}
    <div class="grid grid-cols-1 items-center gap-10 border-t border-hair py-14 lg:grid-cols-2 lg:gap-16 lg:py-20">
        <div class="sr-l overflow-hidden rounded-3xl" data-plx="0.07">
            <img src="{{ $pillarImages[0] }}" alt="{{ __('Biyostimülasyon') }}" class="aspect-[4/3] w-full object-cover" loading="lazy" decoding="async">
        </div>
        <div class="sr-r">
            <span class="text-sm font-extrabold uppercase tracking-[0.14em] text-leaf-600">01 — {{ __('Biyostimülasyon') }}</span>
            <h3 class="mt-3 text-3xl font-extrabold tracking-tight text-ink lg:text-4xl">{{ __('Bitkinin kendi gücünü açığa çıkarın') }}</h3>
            <p class="mt-4 max-w-md text-[16px] leading-relaxed text-ink-soft">{{ __('Aminoasit, deniz yosunu ve hümik bazlı biyostimülantlarımız bitkinin stres direncini ve besin alımını artırır; verimi ve kaliteyi birlikte yükseltir.') }}</p>
            <a href="{{ lroute('products.index') }}" class="mt-6 inline-flex items-center gap-2 text-[15px] font-bold text-leaf-700 transition-all hover:gap-3">{{ __('Çözümleri gör') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
    </div>

    {{-- Gübre akışı bandı: EDDHA Demir --}}
    <div class="pour-band my-14 rounded-3xl bg-gradient-to-b from-[#3a1a10] via-[#2a1108] to-[#180a06]" style="min-height:22rem">
        <div data-pour class="pointer-events-none absolute inset-0" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -top-10 right-[14%] h-28 w-40 rounded-full blur-2xl" style="background:radial-gradient(circle,rgba(181,72,31,.5),transparent 70%)" aria-hidden="true"></div>
        <div class="relative z-10 grid grid-cols-1 items-center gap-8 p-8 lg:grid-cols-2 lg:p-14">
            <div class="sr-l">
                <span class="text-sm font-extrabold uppercase tracking-[0.14em] text-[#f0a878]">{{ __('Mikro Element') }}</span>
                <h3 class="mt-3 text-3xl font-extrabold tracking-tight text-white lg:text-4xl">{{ __('EDDHA Demir') }}</h3>
                <p class="mt-4 max-w-md text-[16px] leading-relaxed text-white/75">{{ __('Yüksek pH\'lı ve kireçli topraklarda demir noksanlığını (kloroz) hızla giderir. EDDHA şelatı demiri en zorlu koşullarda bile bitkiye erişilebilir tutar; yapraklar yeniden canlı yeşile kavuşur.') }}</p>
                <a href="{{ lroute('products.index') }}" class="mt-6 inline-flex items-center gap-2 text-[15px] font-bold text-[#f0a878] transition-all hover:gap-3">{{ __('Ürünü gör') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
            </div>
            <div></div>
        </div>
    </div>

    {{-- 02 (ters) --}}
    <div class="grid grid-cols-1 items-center gap-10 border-t border-hair py-14 lg:grid-cols-2 lg:gap-16 lg:py-20">
        <div class="sr-r overflow-hidden rounded-3xl lg:order-2" data-plx="0.06">
            <img src="{{ $pillarImages[1] }}" alt="{{ __('Hassas Besleme') }}" class="aspect-[4/3] w-full object-cover" loading="lazy" decoding="async">
        </div>
        <div class="sr-l lg:order-1">
            <span class="text-sm font-extrabold uppercase tracking-[0.14em] text-leaf-600">02 — {{ __('Hassas Besleme') }}</span>
            <h3 class="mt-3 text-3xl font-extrabold tracking-tight text-ink lg:text-4xl">{{ __('Doğru element, doğru dönem') }}</h3>
            <p class="mt-4 max-w-md text-[16px] leading-relaxed text-ink-soft">{{ __('Fertigasyon ve yapraktan uygulamaya uygun sıvı gübre ve mikro element çözümleriyle bitkinin her gelişim döneminde tam ihtiyacını karşılayın.') }}</p>
            <a href="{{ lroute('products.index') }}" class="mt-6 inline-flex items-center gap-2 text-[15px] font-bold text-leaf-700 transition-all hover:gap-3">{{ __('Çözümleri gör') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
    </div>

    {{-- 03 --}}
    <div class="grid grid-cols-1 items-center gap-10 border-t border-hair py-14 lg:grid-cols-2 lg:gap-16 lg:py-20">
        <div class="sr-l overflow-hidden rounded-3xl" data-plx="0.07">
            <img src="{{ $pillarImages[2] }}" alt="{{ __('Toprak Sağlığı') }}" class="aspect-[4/3] w-full object-cover" loading="lazy" decoding="async">
        </div>
        <div class="sr-r">
            <span class="text-sm font-extrabold uppercase tracking-[0.14em] text-leaf-600">03 — {{ __('Toprak Sağlığı') }}</span>
            <h3 class="mt-3 text-3xl font-extrabold tracking-tight text-ink lg:text-4xl">{{ __('Kalıcı verimliliğin temeli') }}</h3>
            <p class="mt-4 max-w-md text-[16px] leading-relaxed text-ink-soft">{{ __('pH, tuzluluk ve organik madde dengesini koruyan toprak düzenleyicilerimizle bugünün hasadını korurken yarının toprağını da güçlendirin.') }}</p>
            <a href="{{ lroute('products.index') }}" class="mt-6 inline-flex items-center gap-2 text-[15px] font-bold text-leaf-700 transition-all hover:gap-3">{{ __('Çözümleri gör') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
    </div>
</section>

{{-- =========================================================
     4. BLOG — son yazılar (Agronomi Günlüğü)
     ========================================================= --}}
@if(isset($latestPosts) && $latestPosts->count() > 0)
<section class="bg-leaf-500/5 py-20 lg:py-28">
    <div class="mx-auto max-w-6xl px-5">
        <div class="mb-10 flex flex-wrap items-end justify-between gap-4">
            <div class="sr">
                <span class="text-sm font-bold uppercase tracking-[0.14em] text-leaf-600">{{ __('Agronomi Günlüğü') }}</span>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink lg:text-4xl">{{ __('Tarım Dünyasından') }}</h2>
            </div>
            <a href="{{ lroute('blog.index') }}" class="inline-flex shrink-0 items-center gap-1.5 text-[15px] font-bold text-leaf-700 transition-all hover:gap-2.5">
                {{ __('Tüm Yazılar') }}
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($latestPosts as $post)
                <a href="{{ lroute('blog.show', $post->slug) }}" class="sr group flex flex-col overflow-hidden rounded-2xl bg-white ring-1 ring-hair transition-all hover:-translate-y-1 hover:ring-leaf-400">
                    <div class="aspect-[16/10] overflow-hidden bg-leaf-50">
                        @if($post->featured_image)
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy" decoding="async">
                        @else
                            <div class="grid h-full w-full place-items-center text-leaf-300">
                                <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-5">
                        @if($post->category)
                            <span class="mb-2 text-xs font-bold uppercase tracking-wide text-leaf-600">{{ $post->category->name }}</span>
                        @endif
                        <h3 class="line-clamp-2 font-extrabold leading-snug text-ink transition group-hover:text-leaf-700">{{ $post->title }}</h3>
                        @if($post->excerpt)
                            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-ink-soft">{{ Str::limit(strip_tags($post->excerpt), 90) }}</p>
                        @endif
                        <div class="mt-4 flex items-center gap-3 text-xs text-ink-soft">
                            <span>{{ optional($post->published_at)->format('d.m.Y') ?? $post->created_at->format('d.m.Y') }}</span>
                            @if($post->reading_time)
                                <span aria-hidden="true">·</span><span>{{ $post->reading_time }} {{ __('dk okuma') }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- =========================================================
     5. AGRONOMİ — yeşil bant, süzülen yapraklar
     ========================================================= --}}
<section class="relative overflow-hidden bg-earth-600">
    <div class="leaves pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        @foreach([['7%','12s','-3s',24],['21%','15s','-9s',18],['38%','11s','-6s',28],['57%','14s','-1s',20],['74%','13s','-7s',26],['90%','16s','-4s',19]] as $lf)
            <span style="left:{{ $lf[0] }};--d:{{ $lf[1] }};--delay:{{ $lf[2] }}"><svg width="{{ $lf[3] }}" height="{{ $lf[3] }}" viewBox="0 0 24 24" fill="currentColor"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/></svg></span>
        @endforeach
    </div>
    <div class="pointer-events-none absolute left-1/2 top-6 -translate-x-1/2 text-center lg:top-8">
        <span class="font-script text-3xl text-white/90 lg:text-4xl">{{ __('Agronomi Bilgisi') }}</span>
        <svg class="mx-auto mt-1 h-8 w-8 text-white/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 4v14M6 12l6 6 6-6"/></svg>
    </div>
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-8 px-5 pb-14 pt-28 lg:grid-cols-2 lg:gap-14 lg:pb-20 lg:pt-32">
        <div class="sr-l overflow-hidden rounded-md lg:max-w-md">
            <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?auto=format&fit=crop&w=900&q=80" alt="{{ __('Agronomi') }}" class="aspect-[4/3] w-full object-cover" loading="lazy" decoding="async">
        </div>
        <div class="sr-r">
            <h2 class="text-3xl font-bold text-white lg:text-4xl">{{ __('Bilime dayalı bitki besleme') }}</h2>
            <p class="mt-4 max-w-md text-[15px] leading-relaxed text-white/80">{{ __('Her ürünümüz, etki mekanizması saha denemeleriyle doğrulanmış formülasyonlardan oluşur. Toprak analizinden uygulama programına kadar agronomi ekibimiz yanınızda; doğru ürünü, doğru dozda, doğru zamanda kullanın.') }}</p>
            <a href="{{ lroute('about') }}" class="mt-6 inline-flex items-center gap-2 text-[15px] font-bold text-white underline underline-offset-4 transition hover:text-white/80">{{ __('Yaklaşımımızı keşfedin') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
    </div>
</section>

{{-- =========================================================
     6. RAKAMLARLA — sayaç animasyonu
     ========================================================= --}}
<section class="mx-auto max-w-6xl px-5 py-16 lg:py-20">
    <div class="grid grid-cols-2 gap-8 text-center lg:grid-cols-4">
        @foreach([
            ['count' => 25, 'suffix' => '+', 'label' => __('Yıllık tarımsal deneyim')],
            ['count' => 120, 'suffix' => '+', 'label' => __('Ürün çeşidi')],
            ['count' => 30, 'suffix' => '', 'label' => __('İhracat ülkesi')],
            ['count' => 40000, 'suffix' => ' t', 'label' => __('Yıllık üretim kapasitesi')],
        ] as $i => $stat)
            <div class="sr" style="transition-delay:{{ $i * 0.1 }}s">
                <div class="text-4xl font-extrabold tracking-tight text-leaf-600 lg:text-5xl" data-count="{{ $stat['count'] }}" data-suffix="{{ $stat['suffix'] }}">0</div>
                <div class="mt-2 text-sm font-semibold text-ink-soft">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>
</section>

{{-- =========================================================
     7. SAHADA — akan şeritler (marquee)
     ========================================================= --}}
<section class="overflow-hidden py-16 lg:py-24">
    <div class="mx-auto mb-10 max-w-6xl px-5 text-center">
        <span class="sr text-sm font-bold uppercase tracking-[0.12em] text-leaf-600">{{ __('Sahada') }}</span>
        <h2 class="sr mt-2 text-3xl font-extrabold tracking-tight text-ink lg:text-4xl" style="transition-delay:.08s">{{ __('Her kültürde, her bölgede') }}</h2>
    </div>

    @php
        // Her kültürün adı çeviriye tabidir (__()); ikon yerel SVG (public/images/crops).
        $crops = [
            ['name' => 'Domates',         'icon' => 'tomato'],
            ['name' => 'Biber',           'icon' => 'pepper'],
            ['name' => 'Patlıcan',        'icon' => 'eggplant'],
            ['name' => 'Bağ & Üzüm',      'icon' => 'grape'],
            ['name' => 'Turunçgil',       'icon' => 'citrus'],
            ['name' => 'Limon',           'icon' => 'lemon'],
            ['name' => 'Çilek',           'icon' => 'strawberry'],
            ['name' => 'Yaban Mersini',   'icon' => 'blueberry'],
            ['name' => 'Elma',            'icon' => 'apple'],
            ['name' => 'Armut',           'icon' => 'pear'],
            ['name' => 'Şeftali',         'icon' => 'peach'],
            ['name' => 'Kiraz',           'icon' => 'cherry'],
            ['name' => 'Muz',             'icon' => 'banana'],
            ['name' => 'Karpuz',          'icon' => 'watermelon'],
            ['name' => 'Kavun',           'icon' => 'melon'],
            ['name' => 'Ananas',          'icon' => 'pineapple'],
            ['name' => 'Mango',           'icon' => 'mango'],
            ['name' => 'Avokado',         'icon' => 'avocado'],
            ['name' => 'Kivi',            'icon' => 'kiwi'],
            ['name' => 'Hindistan Cevizi','icon' => 'coconut'],
            ['name' => 'Sera Sebzeleri',  'icon' => 'greens'],
            ['name' => 'Salatalık',       'icon' => 'cucumber'],
            ['name' => 'Dolmalık Biber',  'icon' => 'bellpepper'],
            ['name' => 'Brokoli',         'icon' => 'broccoli'],
            ['name' => 'Havuç',           'icon' => 'carrot'],
            ['name' => 'Soğan',           'icon' => 'onion'],
            ['name' => 'Sarımsak',        'icon' => 'garlic'],
            ['name' => 'Patates',         'icon' => 'potato'],
            ['name' => 'Tatlı Patates',   'icon' => 'sweetpotato'],
            ['name' => 'Mantar',          'icon' => 'mushroom'],
            ['name' => 'Mısır',           'icon' => 'corn'],
            ['name' => 'Buğday',          'icon' => 'wheat'],
            ['name' => 'Çeltik',          'icon' => 'rice'],
            ['name' => 'Ayçiçeği',        'icon' => 'sunflower'],
            ['name' => 'Fasulye',         'icon' => 'beans'],
            ['name' => 'Yonca',           'icon' => 'clover'],
            ['name' => 'Zeytin',          'icon' => 'olive'],
            ['name' => 'Antep Fıstığı',   'icon' => 'pistachio'],
            ['name' => 'Fındık',          'icon' => 'chestnut'],
            ['name' => 'Çay',             'icon' => 'tea'],
            ['name' => 'Kahve',           'icon' => 'coffee'],
            ['name' => 'Aromatik Bitkiler','icon' => 'herb'],
            ['name' => 'Gül',             'icon' => 'rose'],
            ['name' => 'Lale',            'icon' => 'tulip'],
        ];
        // İsimler her dilde İngilizce kalır; bayraklar yerel SVG (public/images/flags) — her yerde renkli.
        // Bölgesel sıra: Avrupa → Amerika → Asya → Afrika.
        $countries = [
            // ── Avrupa
            ['name' => 'Turkey',         'code' => 'tr'],
            ['name' => 'Spain',          'code' => 'es'],
            ['name' => 'Italy',          'code' => 'it'],
            ['name' => 'Greece',         'code' => 'gr'],
            ['name' => 'Netherlands',    'code' => 'nl'],
            ['name' => 'Romania',        'code' => 'ro'],
            ['name' => 'Ukraine',        'code' => 'ua'],
            // ── Amerika
            ['name' => 'United States',  'code' => 'us'],
            ['name' => 'Mexico',         'code' => 'mx'],
            ['name' => 'Colombia',       'code' => 'co'],
            ['name' => 'Brazil',         'code' => 'br'],
            ['name' => 'Argentina',      'code' => 'ar'],
            // ── Asya
            ['name' => 'Azerbaijan',     'code' => 'az'],
            ['name' => 'Georgia',        'code' => 'ge'],
            ['name' => 'Lebanon',        'code' => 'lb'],
            ['name' => 'Jordan',         'code' => 'jo'],
            ['name' => 'Iraq',           'code' => 'iq'],
            ['name' => 'Iran',           'code' => 'ir'],
            ['name' => 'Saudi Arabia',   'code' => 'sa'],
            ['name' => 'Kuwait',         'code' => 'kw'],
            ['name' => 'Qatar',          'code' => 'qa'],
            ['name' => 'UAE',            'code' => 'ae'],
            ['name' => 'Uzbekistan',     'code' => 'uz'],
            ['name' => 'Kazakhstan',     'code' => 'kz'],
            ['name' => 'Turkmenistan',   'code' => 'tm'],
            ['name' => 'Kyrgyzstan',     'code' => 'kg'],
            ['name' => 'Tajikistan',     'code' => 'tj'],
            ['name' => 'Pakistan',       'code' => 'pk'],
            ['name' => 'India',          'code' => 'in'],
            // ── Afrika
            ['name' => 'Morocco',        'code' => 'ma'],
            ['name' => 'Algeria',        'code' => 'dz'],
            ['name' => 'Tunisia',        'code' => 'tn'],
            ['name' => 'Libya',          'code' => 'ly'],
            ['name' => 'Egypt',          'code' => 'eg'],
            ['name' => 'Sudan',          'code' => 'sd'],
            ['name' => 'Ghana',          'code' => 'gh'],
            ['name' => 'Ivory Coast',    'code' => 'ci'],
            ['name' => 'Nigeria',        'code' => 'ng'],
            ['name' => 'Kenya',          'code' => 'ke'],
            ['name' => 'Ethiopia',       'code' => 'et'],
            ['name' => 'Tanzania',       'code' => 'tz'],
            ['name' => 'South Africa',   'code' => 'za'],
        ];
    @endphp

    <div class="marquee relative" style="-webkit-mask-image:linear-gradient(90deg,transparent,#000 7%,#000 93%,transparent);mask-image:linear-gradient(90deg,transparent,#000 7%,#000 93%,transparent)">
        {{-- Süre öğe sayısıyla orantılı: 44 öğe → ~125s; ülke şeridiyle aynı çizgisel hız --}}
        <div class="marquee-track flex gap-5" style="animation-duration:125s">
            @foreach(array_merge($crops, $crops) as $crop)
                <span class="inline-flex items-center gap-2 whitespace-nowrap rounded-full bg-white px-5 py-3 text-[15px] font-bold text-ink ring-1 ring-hair"><img src="{{ asset('images/crops/' . $crop['icon'] . '.svg') }}" alt="" width="28" height="28" class="h-7 w-7 shrink-0" aria-hidden="true">{{ __($crop['name']) }}</span>
            @endforeach
        </div>
    </div>
    <div class="marquee relative mt-6 lg:mt-8" style="-webkit-mask-image:linear-gradient(90deg,transparent,#000 7%,#000 93%,transparent);mask-image:linear-gradient(90deg,transparent,#000 7%,#000 93%,transparent)">
        {{-- Süre öğe sayısıyla orantılı: ürün şeridi (12 öğe) 34s → ülke şeridi (42 öğe) ~119s; aynı çizgisel hız --}}
        <div class="marquee-track marquee-track--rev flex gap-5" style="animation-duration:119s">
            @foreach(array_merge($countries, $countries) as $country)
                <span class="inline-flex items-center gap-2 whitespace-nowrap rounded-full bg-leaf-500/10 px-5 py-3 text-[15px] font-bold text-leaf-700"><img src="{{ asset('images/flags/' . $country['code'] . '.svg') }}" alt="{{ $country['name'] }}" width="32" height="20" class="h-5 w-8 shrink-0 rounded-sm object-cover shadow-sm ring-1 ring-black/5"><span>{{ $country['name'] }}</span></span>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================
     8. BÜLTEN / CTA bandı
     ========================================================= --}}
<section class="relative overflow-hidden bg-earth-700">
    <div class="leaves pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        @foreach([['12%','13s','-5s',22],['33%','16s','-11s',17],['52%','12s','-2s',25],['69%','15s','-8s',19],['86%','14s','-6s',23]] as $lf)
            <span style="left:{{ $lf[0] }};--d:{{ $lf[1] }};--delay:{{ $lf[2] }}"><svg width="{{ $lf[3] }}" height="{{ $lf[3] }}" viewBox="0 0 24 24" fill="currentColor"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/></svg></span>
        @endforeach
    </div>
    <div class="mx-auto flex max-w-6xl flex-col items-center gap-8 px-5 py-14 text-center lg:flex-row lg:justify-between lg:py-16 lg:text-left">
        <div class="max-w-xl">
            <h2 class="text-2xl font-extrabold text-white lg:text-3xl">{{ __('Sezon önerilerini e-postanıza alın') }}</h2>
            <p class="mt-3 text-base leading-relaxed text-white/80">{{ __('Kültür bazlı uygulama takvimleri, yeni ürünler ve agronomi ipuçları — ayda bir, spam yok.') }}</p>
        </div>
        {{-- Bu sayfa "stateless" grupta (session/CSRF yok); bülten AJAX/JSON ile gönderilir --}}
        <form action="{{ lroute('newsletter.submit') }}" method="POST" class="w-full max-w-md"
              x-data="{ sent: false, sending: false, err: '' }"
              @submit.prevent="
                sending = true; err = '';
                fetch($el.action, { method: 'POST', body: new FormData($el), headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.ok ? r.json() : Promise.reject(r))
                    .then(() => { sent = true; })
                    .catch(() => { err = '{{ __('Kayıt yapılamadı. Lütfen e-posta ve onay kutusunu kontrol edin.') }}'; })
                    .finally(() => { sending = false; });
              ">
            <input type="hidden" name="form_type" value="newsletter">
            <input type="hidden" name="name" value="{{ __('Bülten Aboneliği') }}">

            <template x-if="sent">
                <p class="rounded bg-white/15 px-4 py-3 text-sm font-semibold text-white">{{ __('Teşekkürler! Kaydınız alındı.') }}</p>
            </template>

            <div x-show="!sent">
                <p x-show="err" x-cloak x-text="err" class="mb-2 text-sm font-semibold text-leaf-300"></p>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <label class="sr-only" for="nl-email">{{ __('E-posta') }}</label>
                    <input id="nl-email" type="email" name="email" required placeholder="{{ __('E-posta adresiniz') }}" class="w-full rounded bg-white px-4 py-3.5 text-base text-ink outline-none ring-2 ring-transparent focus:ring-leaf-300">
                    <button type="submit" :disabled="sending" class="inline-flex shrink-0 items-center justify-center gap-2 rounded bg-leaf-500 px-6 py-3.5 text-base font-extrabold text-white transition hover:bg-leaf-600 disabled:opacity-60">
                        <span x-show="!sending">{{ __('Kayıt Ol') }}</span>
                        <span x-show="sending" x-cloak>{{ __('Gönderiliyor...') }}</span>
                    </button>
                </div>
                <label class="mt-3 flex items-start gap-2 text-left text-xs leading-relaxed text-white/70">
                    <input type="checkbox" name="accept_contact" value="1" required class="mt-0.5 h-4 w-4 shrink-0 rounded border-white/40 bg-white/10 text-leaf-500 focus:ring-leaf-300">
                    <span>{{ __('Kişisel verilerimin bülten amacıyla işlenmesini kabul ediyorum.') }} <a href="{{ lroute('privacy') }}" class="underline hover:text-white">{{ __('Gizlilik Politikası') }}</a></span>
                </label>
            </div>
        </form>
    </div>
</section>

@endsection
