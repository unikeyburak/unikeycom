@extends('layouts.app')

@php
    $brandName = $settings['site_name'] ?? config('app.name');
    $page = $page ?? null;
    $milestones = [
        ['year' => '2001', 'tag' => __('Kuruluş'),      'title' => __('Antalya\'da yola çıktık'),            'desc' => __('İki kişilik bir ekip ve tek bir depoyla, yapraktan gübre dağıtımıyla başladık.')],
        ['year' => '2004', 'tag' => __('Bayilik Ağı'),  'title' => __('Bölge bayilikleri kuruldu'),          'desc' => __('Ege ve Akdeniz genelinde ilk bayilik ağımızı oluşturduk; sahaya yakınlaştık.')],
        ['year' => '2007', 'tag' => __('İlk İhracat'),   'title' => __('Sınırların ötesine'),                 'desc' => __('Komşu ülkelere ilk ihracatımızı gerçekleştirdik; uluslararası yolculuk başladı.')],
        ['year' => '2009', 'tag' => __('Üretim'),        'title' => __('Kendi üretimimiz'),                   'desc' => __('İlk sıvı gübre üretim hattımızı devreye aldık; dağıtıcıdan üreticiye dönüştük.')],
        ['year' => '2012', 'tag' => __('Kalite'),        'title' => __('ISO 9001 sertifikası'),               'desc' => __('Üretim ve kalite yönetim süreçlerimizi uluslararası standartlara taşıdık.')],
        ['year' => '2015', 'tag' => __('Ar-Ge'),         'title' => __('Biyostimülant Ar-Ge'),                'desc' => __('Aminoasit ve deniz yosunu bazlı ürün ailemizi geliştirdik; saha denemelerine başladık.')],
        ['year' => '2018', 'tag' => __('Yeni Tesis'),    'title' => __('Entegre üretim tesisi'),              'desc' => __('Yüksek kapasiteli yeni üretim tesisimizi açtık; üretimi katladık.')],
        ['year' => '2021', 'tag' => __('Organik'),       'title' => __('Organik girdi sertifikaları'),        'desc' => __('Ürünlerimizin önemli bölümü organik tarımda kullanım onayı aldı.')],
        ['year' => '2026', 'tag' => __('Bugün'),         'title' => __('Geniş ürün ailesiyle sahada'),        'desc' => __('Üç kıtada üreticilerin yanındayız — ve yolculuk devam ediyor.'), 'highlight' => true],
    ];
@endphp

@section('title', __('Hakkımızda') . ' - ' . $brandName)

@push('styles')
<style>
    .tl-item { opacity: 0; transform: translateY(34px); transition: opacity .7s cubic-bezier(.2,.7,.2,1), transform .7s cubic-bezier(.2,.7,.2,1); }
    .tl-item.in { opacity: 1; transform: none; }
    @media (min-width:1024px){ .tl-item--l { transform: translateX(-46px); } .tl-item--r { transform: translateX(46px); } .tl-item.in { transform: none; } }
    .tl-spine { background: linear-gradient(to bottom, #4a9040 var(--p,0%), #e5e7eb var(--p,0%)); }
    .tl-dot { box-shadow: 0 0 0 5px #fff, 0 0 0 6px #e5e7eb; transition: background .4s, box-shadow .4s; }
    .tl-item.in .tl-dot { background: #4a9040; box-shadow: 0 0 0 5px #fff, 0 0 0 6px #4a9040, 0 0 18px rgba(74,144,64,.45); }
    @media (prefers-reduced-motion: reduce){ .tl-item { opacity:1 !important; transform:none !important; } }
</style>
@endpush

@section('content')

{{-- YEŞİL BAŞLIK BANDI --}}
<div class="hero-band bg-earth-600">
    <div class="mx-auto max-w-6xl px-5 pb-16 pt-4 lg:pb-24 lg:pt-8">
        <nav aria-label="breadcrumb" class="mb-5 flex flex-wrap items-center gap-2 text-sm text-white/60">
            <a href="{{ route('home') }}" class="transition hover:text-white">{{ __('Ana Sayfa') }}</a>
            <span aria-hidden="true">/</span>
            <span class="text-white/90">{{ __('Hakkımızda') }}</span>
        </nav>
        <span class="text-sm font-bold uppercase tracking-[0.12em] text-leaf-300">{{ __('Biz Kimiz') }}</span>
        <h1 class="mt-3 max-w-3xl text-[clamp(2.2rem,4.5vw,3.4rem)] font-medium leading-[1.08] tracking-tight text-white">{{ __('Topraktan sofraya, üreticinin yanında') }}</h1>
    </div>
</div>

{{-- HİKAYE --}}
<section class="mx-auto max-w-6xl px-5 py-16 lg:py-20">
    <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-14">
        <div class="overflow-hidden rounded-2xl">
            <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1000&q=80" alt="{{ $brandName }}" class="aspect-[4/3] w-full object-cover" loading="lazy" decoding="async">
        </div>
        <div>
            <span class="text-sm font-bold uppercase tracking-[0.12em] text-leaf-600">{{ __('Hikayemiz') }}</span>
            <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink lg:text-4xl">{{ __('Üreticiden üreticiye') }}</h2>
            @if(!empty($page) && $page->content)
                <div class="prose mt-5 max-w-none text-[16px] leading-relaxed text-ink-soft">{!! $page->content !!}</div>
            @else
                <p class="mt-5 text-[16px] leading-relaxed text-ink-soft">Keysol Agro, 25 yılı aşkın saha deneyimini modern formülasyon bilimiyle birleştiren bir bitki besleme şirketidir. Kurulduğumuz günden bu yana tek bir hedefimiz oldu: üreticinin verimini ve ürün kalitesini, toprağı ve çevreyi koruyarak artırmak.</p>
                <p class="mt-4 text-[16px] leading-relaxed text-ink-soft">Ürünlerimiz Antalya'daki entegre tesisimizde, uluslararası kalite standartlarında üretilir ve 30 ülkeye ihraç edilir. Her formülasyonumuzun arkasında saha denemeleri ve agronomik veri vardır.</p>
            @endif
        </div>
    </div>
</section>

{{-- DEĞERLER --}}
<section class="bg-leaf-500/5 py-16 lg:py-20">
    <div class="mx-auto max-w-6xl px-5">
        <div class="mb-10 text-center">
            <span class="text-sm font-bold uppercase tracking-[0.12em] text-leaf-600">{{ __('Bizi Biz Yapan') }}</span>
            <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink lg:text-4xl">{{ __('Değerlerimiz') }}</h2>
        </div>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            @foreach([
                ['t' => __('Bilimsel Güvenilirlik'), 'd' => __('Her ürünün etki mekanizması saha denemeleriyle doğrulanır; iddialarımızın arkasında veri vardır.'), 'p' => 'M12 2 4 6v6c0 5 3.5 8 8 10 4.5-2 8-5 8-10V6l-8-4Z M9 12l2 2 4-4'],
                ['t' => __('Sürdürülebilirlik'), 'd' => __('Toprak sağlığını ve su kaynaklarını koruyan, düşük tuzluluklu ve çevre dostu formülasyonlar.'), 'p' => 'M12 22c0-6 0-9 4-12-5 0-7 2-8 5-1-4-3-6-6-6 2 4 2 7 2 9 0 3 3 4 6 4Z'],
                ['t' => __('Üretici Odağı'), 'd' => __('Agronomi ekibimiz sahada; ürünü satıp bırakmıyor, sezon boyunca yanınızda yer alıyoruz.'), 'p' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z'],
            ] as $v)
                <div class="rounded-2xl bg-white p-7 ring-1 ring-hair">
                    <span class="grid h-14 w-14 place-items-center rounded-xl bg-leaf-500/10 text-leaf-600"><svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="{{ $v['p'] }}"/></svg></span>
                    <h3 class="mt-5 text-lg font-extrabold text-ink">{{ $v['t'] }}</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-ink-soft">{{ $v['d'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- SÜRDÜRÜLEBİLİRLİK — yeşil bant --}}
<section id="surdurulebilirlik" class="relative bg-earth-600">
    <div class="pointer-events-none absolute left-1/2 top-6 -translate-x-1/2 text-center lg:top-8">
        <span class="font-script text-3xl text-white/90 lg:text-4xl">{{ __('Yeşil Gelecek') }}</span>
        <svg class="mx-auto mt-1 h-8 w-8 text-white/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 4v14M6 12l6 6 6-6"/></svg>
    </div>
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-8 px-5 pb-14 pt-28 lg:grid-cols-2 lg:gap-14 lg:pb-20 lg:pt-32">
        <div>
            <h2 class="text-3xl font-bold text-white lg:text-4xl">{{ __('Sürdürülebilirlik taahhüdümüz') }}</h2>
            <p class="mt-4 max-w-md text-[15px] leading-relaxed text-white/80">{{ __('Daha az girdiyle daha çok hasat — bu sadece bir slogan değil, üretim ve formülasyon felsefemiz. Su kullanım etkinliğini artıran, toprak mikrobiyolojisini koruyan ve karbon ayak izini azaltan çözümler geliştiriyoruz.') }}</p>
            <ul class="mt-6 space-y-3">
                @foreach([__('Geri dönüştürülebilir ambalaj hedefi'), __('Düşük tuzluluk indeksli, klorsuz formülasyonlar'), __('Yenilenebilir enerjiyle üretim')] as $s)
                    <li class="flex items-start gap-3 text-[15px] text-white/90"><svg class="mt-0.5 h-5 w-5 shrink-0 text-leaf-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m20 6-11 11-5-5"/></svg>{{ $s }}</li>
                @endforeach
            </ul>
        </div>
        <div class="overflow-hidden rounded-md lg:max-w-md">
            <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&w=1000&q=80" alt="{{ __('Sürdürülebilir tarım') }}" class="aspect-[4/3] w-full object-cover" loading="lazy" decoding="async">
        </div>
    </div>
</section>

{{-- ZAMAN ÇİZGİSİ --}}
<section class="overflow-hidden bg-leaf-500/5 py-16 lg:py-24">
    <div class="mx-auto max-w-6xl px-5">
        <div class="mb-14 text-center">
            <span class="text-sm font-bold uppercase tracking-[0.12em] text-leaf-600">{{ __('Yolculuğumuz') }}</span>
            <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink lg:text-4xl">{{ __('Kilometre Taşları') }}</h2>
        </div>
        <div id="tl" class="relative">
            <div id="tl-spine" class="tl-spine absolute left-[22px] top-0 bottom-0 w-[3px] rounded-full lg:left-1/2 lg:-translate-x-1/2" aria-hidden="true"></div>
            @foreach($milestones as $i => $m)
                @php $left = $i % 2 === 0; @endphp
                <div class="tl-item {{ $left ? 'tl-item--l' : 'tl-item--r' }} relative block pl-12 {{ $loop->last ? '' : 'pb-14 lg:pb-20' }} lg:grid lg:grid-cols-2 lg:gap-0 lg:pl-0">
                    @if(!$left)<div class="hidden lg:block"></div>@endif
                    <div class="relative {{ $left ? 'lg:pr-14 lg:text-right' : 'lg:pl-14' }}">
                        <span class="tl-dot absolute -left-[33px] top-2 z-10 h-4 w-4 rounded-full bg-hair {{ $left ? 'lg:left-auto lg:-right-2 lg:translate-x-1/2' : 'lg:-left-2 lg:-translate-x-1/2' }}" aria-hidden="true"></span>
                        <div class="relative ml-2 rounded-2xl p-6 lg:ml-0 {{ !empty($m['highlight']) ? 'overflow-hidden bg-earth-700' : 'bg-white ring-1 ring-hair' }}">
                            @if(!empty($m['highlight']))<div class="pointer-events-none absolute -right-10 -top-10 h-36 w-36 rounded-full bg-leaf-400/15 blur-2xl" aria-hidden="true"></div>@endif
                            <span class="inline-flex items-center gap-2 text-sm font-extrabold uppercase tracking-wide {{ !empty($m['highlight']) ? 'text-leaf-300' : 'text-leaf-600' }} {{ $left ? 'lg:flex-row-reverse' : '' }}">{{ $m['year'] }} · {{ $m['tag'] }}</span>
                            <h3 class="mt-2 text-lg font-extrabold {{ !empty($m['highlight']) ? 'text-white' : 'text-ink' }}">{{ $m['title'] }}</h3>
                            <p class="mt-1.5 text-sm leading-relaxed {{ !empty($m['highlight']) ? 'text-white/75' : 'text-ink-soft' }}">{{ $m['desc'] }}</p>
                        </div>
                    </div>
                    @if($left)<div class="hidden lg:block"></div>@endif
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA bandı --}}
<section class="bg-earth-700">
    <div class="mx-auto flex max-w-6xl flex-col items-center gap-8 px-5 py-14 text-center lg:flex-row lg:justify-between lg:py-16 lg:text-left">
        <div class="max-w-2xl">
            <h2 class="text-2xl font-extrabold text-white lg:text-3xl">{{ __('Bizimle çalışmak ister misiniz?') }}</h2>
            <p class="mt-3 text-base leading-relaxed text-white/80">{{ __('Bayilik, ihracat ve iş birliği fırsatları için ekibimizle iletişime geçin.') }}</p>
        </div>
        <a href="{{ lroute('contact') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded bg-leaf-500 px-7 py-3.5 text-base font-extrabold text-white transition hover:bg-leaf-600">{{ __('İletişime Geç') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var items = [].slice.call(document.querySelectorAll('.tl-item'));
    var spine = document.getElementById('tl-spine');
    var tl = document.getElementById('tl');
    if (!items.length) return;
    if (reduce) { items.forEach(function (el) { el.classList.add('in'); }); if (spine) spine.style.setProperty('--p', '100%'); return; }
    function inView(el, m) { var r = el.getBoundingClientRect(); var h = window.innerHeight || document.documentElement.clientHeight; return r.top < h - (m || 0) && r.bottom > 0; }
    var ticking = false;
    function check() {
        ticking = false;
        items = items.filter(function (el) { if (inView(el, 70)) { el.classList.add('in'); return false; } return true; });
        if (spine && tl) {
            var r = tl.getBoundingClientRect();
            var h = window.innerHeight || document.documentElement.clientHeight;
            var p = Math.max(0, Math.min(1, (h * 0.78 - r.top) / r.height));
            spine.style.setProperty('--p', (p * 100).toFixed(1) + '%');
        }
    }
    function onScroll() { if (!ticking) { ticking = true; requestAnimationFrame(check); } }
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
    window.addEventListener('load', check);
    check(); setTimeout(check, 250);
})();
</script>
@endpush
