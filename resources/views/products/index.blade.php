@extends('layouts.app')

@section('title', ($currentCategory ? $currentCategory->translate('name') : __('Ürünler')) . ' - ' . ($settings['site_name'] ?? config('app.name')))
@section('meta_description', $meta['description'] ?? '')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
   1. YEŞİL BAŞLIK BANDI — breadcrumb + başlık (değişmedi)
   ═══════════════════════════════════════════════════════════════ --}}
<div class="hero-band bg-earth-600">
    <div class="mx-auto max-w-6xl px-5 pb-16 pt-4 lg:pb-24 lg:pt-8">
        <nav aria-label="breadcrumb" class="mb-5 flex flex-wrap items-center gap-2 text-sm text-white/60">
            <a href="{{ route('home') }}" class="transition hover:text-white">{{ __('Ana Sayfa') }}</a>
            <span aria-hidden="true">/</span>
            @if($currentCategory)
                <a href="{{ lroute('products.index') }}" class="transition hover:text-white">{{ __('Ürünler') }}</a>
                <span aria-hidden="true">/</span>
                <span class="text-white/90">{{ $currentCategory->translate('name') }}</span>
            @else
                <span class="text-white/90">{{ __('Ürünler') }}</span>
            @endif
        </nav>
        <span class="text-sm font-bold uppercase tracking-[0.12em] text-leaf-300">{{ __('Ürün Kataloğu') }}</span>
        <h1 class="mt-3 max-w-2xl text-[clamp(2.2rem,4.5vw,3.4rem)] font-medium leading-[1.08] tracking-tight text-white">
            {{ $currentCategory ? $currentCategory->translate('name') : __('Bitkinizin her dönemine uygun çözümler') }}
        </h1>
        @if($currentCategory && $currentCategory->translate('description'))
            <div class="mt-4 max-w-2xl text-[15px] leading-relaxed text-white/80">{{ Str::limit(strip_tags($currentCategory->translate('description')), 220) }}</div>
        @endif
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
   2. KATALOG — GRUPLU filtre (30 pill duvarı yerine 5-6 üst grup;
      gruba tıklayınca serileri çip olarak açılır) + grid
      Controller'dan $categoryGroups bekler (README'ye bakın).
   ═══════════════════════════════════════════════════════════════ --}}
<section class="mx-auto max-w-6xl px-5 py-12 lg:py-16">

    @php
        // Seçili kategori bir seri ise ait olduğu grup açık gelsin
        $openGroupId = $currentCategory ? ($currentCategory->parent_id ?? $currentCategory->id) : null;
    @endphp
    <div x-data="{ group: {{ $openGroupId ?? 'null' }} }">
        {{-- Üst grup pill'leri --}}
        <div class="mb-4 flex flex-wrap items-center gap-2.5" aria-label="{{ __('Kategori grubu') }}">
            <a href="{{ lroute('products.index') }}"
               class="rounded-full px-5 py-2.5 text-sm font-bold transition {{ !$currentCategory ? 'bg-leaf-600 text-white' : 'bg-leaf-500/10 text-leaf-700 hover:bg-leaf-500/20' }}">
                {{ __('Tümü') }}
            </a>
            @foreach($categoryGroups as $groupCat)
                @if($groupCat->children->isEmpty())
                    {{-- Serisi olmayan grup doğrudan linktir --}}
                    <a href="{{ lroute('products.category', $groupCat->slug) }}"
                       class="rounded-full px-5 py-2.5 text-sm font-bold transition {{ ($currentCategory && $currentCategory->id === $groupCat->id) ? 'bg-leaf-600 text-white' : 'bg-leaf-500/10 text-leaf-700 hover:bg-leaf-500/20' }}">
                        {{ $groupCat->translate('name') }}
                    </a>
                @else
                    <button type="button"
                            @click="group = group === {{ $groupCat->id }} ? null : {{ $groupCat->id }}"
                            :class="group === {{ $groupCat->id }} ? 'bg-leaf-600 text-white' : 'bg-leaf-500/10 text-leaf-700 hover:bg-leaf-500/20'"
                            :aria-expanded="(group === {{ $groupCat->id }}).toString()"
                            class="inline-flex items-center gap-1.5 rounded-full px-5 py-2.5 text-sm font-bold transition">
                        {{ $groupCat->translate('name') }}
                        <svg class="h-3.5 w-3.5 transition-transform" :class="group === {{ $groupCat->id }} && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                @endif
            @endforeach
        </div>

        {{-- Seçili grubun seri çipleri --}}
        @foreach($categoryGroups as $groupCat)
            @continue($groupCat->children->isEmpty())
            <div x-cloak x-show="group === {{ $groupCat->id }}" x-transition
                 class="mb-6 flex flex-wrap items-center gap-2 border-s-[3px] border-leaf-300 ps-3.5"
                 aria-label="{{ $groupCat->translate('name') }} {{ __('serileri') }}">
                @foreach($groupCat->children as $serie)
                    <a href="{{ lroute('products.category', $serie->slug) }}"
                       class="rounded-full border px-3.5 py-1.5 text-[13px] font-bold transition {{ ($currentCategory && $currentCategory->id === $serie->id) ? 'border-leaf-600 bg-leaf-600 text-white' : 'border-leaf-200 bg-white text-leaf-700 hover:bg-leaf-50' }}">
                        {{ $serie->translate('name') }}
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>

    {{-- Arama + sıralama + sonuç sayısı (değişmedi) --}}
    <div class="mb-9 flex flex-col gap-4 border-b border-hair pb-6 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-ink-soft"><span class="font-bold text-ink">{{ $products->total() }}</span> {{ __('ürün bulundu') }}</p>
        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ lroute('products.search') }}" method="GET" class="flex">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Ürün ara...') }}"
                       class="w-44 rounded-l-lg border border-hair px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-leaf-300 sm:w-56">
                <button type="submit" class="rounded-r-lg bg-leaf-600 px-4 py-2.5 text-white transition hover:bg-leaf-700" aria-label="{{ __('Ara') }}">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                </button>
            </form>
            <form action="{{ $currentCategory ? lroute('products.category', $currentCategory->slug) : lroute('products.index') }}" method="GET">
                @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                <select name="sort" onchange="this.form.submit()" class="rounded-lg border border-hair px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-leaf-300">
                    @if($currentCategory)
                        <option value="category" {{ (!request('sort') || request('sort') == 'category') ? 'selected' : '' }}>{{ __('Kategoriye Göre') }}</option>
                    @endif
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>{{ __('İsim (A-Z)') }}</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>{{ __('İsim (Z-A)') }}</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('En Yeni') }}</option>
                </select>
            </form>
        </div>
    </div>

    {{-- Ürün grid — kart açıklamasında ad tekrarı savunmacı olarak temizlenir --}}
    <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
        @forelse($products as $product)
            @php
                $productImages = is_array($product->images) ? array_values(array_filter($product->images, 'is_string')) : [];
                $firstValidImage = null;
                foreach ($productImages as $_img) {
                    if (str_starts_with($_img, 'http') || \Illuminate\Support\Facades\Storage::disk('public')->exists($_img)) {
                        $firstValidImage = $_img;
                        break;
                    }
                }
                // WP içe aktarımından gelen "ad + ad + açıklama" tekrarını kırp
                $pName = $product->translate('name');
                $pDesc = trim(strip_tags($product->translate('short_description') ?? ''));
                if ($pDesc !== '' && $pName) {
                    $pDesc = trim(Str::of($pDesc)->replaceFirst($pName, ''));
                    $pDesc = trim(Str::of($pDesc)->replaceFirst(Str::upper($pName), ''));
                }
            @endphp
            <a href="{{ lroute('products.show', $product->slug) }}" class="group block rounded-2xl bg-white p-4 ring-1 ring-hair transition-all hover:-translate-y-1 hover:ring-leaf-400">
                <div class="overflow-hidden rounded-xl bg-gradient-to-b from-leaf-50/70 to-white p-3">
                    <div class="flex aspect-[3/4] items-center justify-center overflow-hidden">
                        @if($firstValidImage)
                            <x-responsive-image :path="$firstValidImage" :alt="$pName"
                                class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-105"
                                sizes="(max-width: 640px) 45vw, 22vw" loading="lazy" decoding="async" />
                        @else
                            <svg class="h-16 w-16 text-leaf-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/></svg>
                        @endif
                    </div>
                </div>
                <span class="mt-4 inline-block text-xs font-bold uppercase tracking-wide text-leaf-600">{{ $product->category?->translate('name') }}</span>
                <h3 class="mt-1 line-clamp-2 font-extrabold text-ink transition-colors group-hover:text-leaf-700">{{ $pName }}</h3>
                @if($pDesc)
                    <p class="mt-0.5 line-clamp-2 text-sm text-ink-soft">{{ Str::limit($pDesc, 80) }}</p>
                @endif
            </a>
        @empty
            <div class="col-span-full py-12 text-center text-ink-soft">{{ __('Ürün bulunamadı.') }}</div>
        @endforelse
    </div>

    {{-- Sayfalama — marka diline uygun özel görünüm --}}
    {{ $products->withQueryString()->onEachSide(2)->links('partials.pagination') }}
</section>

{{-- ═══════════════════════════════════════════════════════════════
   3. AGRONOMİ CTA bandı (değişmedi)
   ═══════════════════════════════════════════════════════════════ --}}
<section class="bg-earth-700">
    <div class="mx-auto flex max-w-6xl flex-col items-center gap-8 px-5 py-14 text-center lg:flex-row lg:justify-between lg:py-16 lg:text-left">
        <div class="max-w-2xl">
            <h2 class="text-2xl font-extrabold text-white lg:text-3xl">{{ __('Hangi ürün size uygun, emin değil misiniz?') }}</h2>
            <p class="mt-3 text-base leading-relaxed text-white/80">{{ __('Toprak analizinizi ve kültürünüzü paylaşın; agronomi ekibimiz size özel bir besleme programı hazırlasın.') }}</p>
        </div>
        <a href="{{ lroute('contact') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded bg-leaf-500 px-7 py-3.5 text-base font-extrabold text-white transition hover:bg-leaf-600">
            {{ __('İletişime Geç') }} <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    </div>
</section>

@endsection
