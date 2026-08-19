{{-- Ürün kartı — hem ürün listesi hem "Benzer Ürünler" için ortak.
     Beklenen: $product --}}
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
        $pDesc = trim(\Illuminate\Support\Str::of($pDesc)->replaceFirst($pName, ''));
        $pDesc = trim(\Illuminate\Support\Str::of($pDesc)->replaceFirst(\Illuminate\Support\Str::upper($pName), ''));
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
        <p class="mt-0.5 line-clamp-2 text-sm text-ink-soft">{{ \Illuminate\Support\Str::limit($pDesc, 80) }}</p>
    @endif
</a>
