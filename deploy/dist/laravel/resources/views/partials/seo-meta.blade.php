{{-- SEO Meta Tags --}}
<meta name="description" content="{{ $meta['description'] ?? '' }}">
<meta name="keywords" content="{{ $meta['keywords'] ?? '' }}">
<meta name="author" content="{{ $settings['site_name'] ?? '' }}">

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $meta['canonical'] ?? request()->url() }}">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="{{ $meta['type'] ?? 'website' }}">
<meta property="og:url" content="{{ $meta['url'] ?? request()->url() }}">
<meta property="og:title" content="{{ $meta['title'] ?? $settings['site_name'] ?? '' }}">
<meta property="og:description" content="{{ $meta['description'] ?? '' }}">
<meta property="og:image" content="{{ $meta['image'] ?? asset('images/og-default.jpg') }}">
<meta property="og:image:alt" content="{{ $meta['title'] ?? $settings['site_name'] ?? '' }}">
@if(!empty($meta['image_width']) && !empty($meta['image_height']))
<meta property="og:image:width" content="{{ $meta['image_width'] }}">
<meta property="og:image:height" content="{{ $meta['image_height'] }}">
@endif
<meta property="og:locale" content="{{ $ogLocales['primary'] ?? $meta['locale'] ?? 'tr_TR' }}">
@foreach(($ogLocales['alternates'] ?? []) as $altLocale)
<meta property="og:locale:alternate" content="{{ $altLocale }}">
@endforeach
<meta property="og:site_name" content="{{ $settings['site_name'] ?? '' }}">

{{-- Twitter (twitter card etiketleri name= ile tanımlanır) --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $meta['url'] ?? request()->url() }}">
<meta name="twitter:title" content="{{ $meta['title'] ?? $settings['site_name'] ?? '' }}">
<meta name="twitter:description" content="{{ $meta['description'] ?? '' }}">
<meta name="twitter:image" content="{{ $meta['image'] ?? asset('images/og-default.jpg') }}">
<meta name="twitter:image:alt" content="{{ $meta['title'] ?? $settings['site_name'] ?? '' }}">
@if(!empty($settings['twitter_handle']))
<meta name="twitter:site" content="{{ $settings['twitter_handle'] }}">
<meta name="twitter:creator" content="{{ $settings['twitter_handle'] }}">
@endif

{{-- Robots --}}
<meta name="robots" content="{{ $meta['robots'] ?? 'index, follow' }}">

{{-- Hreflang (çoklu dil için) — global olarak View Composer ile hesaplanır,
     controller isterse $meta['hreflang'] ile override edebilir --}}
@php($hreflangList = $hreflangLinks ?? ($meta['hreflang'] ?? []))
@if(!empty($hreflangList))
    @foreach($hreflangList as $lang)
        <link rel="alternate" hreflang="{{ $lang['hreflang'] }}" href="{{ $lang['href'] }}">
    @endforeach
@endif

{{-- JSON-LD Schema.org --}}
@if(!empty($schema))
    <script type="application/ld+json">
    {!! $schema !!}
    </script>
@endif

{{-- Multiple Schemas Support --}}
@if(!empty($schemas))
    @foreach($schemas as $schemaItem)
        <script type="application/ld+json">
        {!! json_encode($schemaItem, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endforeach
@endif