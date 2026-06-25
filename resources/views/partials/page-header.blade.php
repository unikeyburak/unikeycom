{{-- ====================================================================
  Vanipren tarzı sayfa başlığı (oval eğrili alt)

  Parametreler:
   $title        — (string)   H1 başlık (zorunlu)
   $subtitle     — (string)   Alt metin (opsiyonel)
   $image        — (string)   Arka plan görsel URL'si (opsiyonel, yoksa gradient)
   $ctaText      — (string)   CTA buton metni (opsiyonel)
   $ctaUrl       — (string)   CTA buton linki (opsiyonel)
   $videoUrl     — (string)   Oynatma butonu (modal video URL) (opsiyonel)
   $size         — (string)   'large' (anasayfa) | 'default' (içerik) | 'small' (blog/ürün)
   $overlay      — (bool)     Arka plana koyu overlay uygula (default: true)
  ==================================================================== --}}
@php
    $title     = $title     ?? '';
    $subtitle  = $subtitle  ?? null;
    $image     = $image     ?? null;
    $ctaText   = $ctaText   ?? null;
    $ctaUrl    = $ctaUrl    ?? null;
    $videoUrl  = $videoUrl  ?? null;
    $size      = $size      ?? 'default';
    $overlay   = $overlay   ?? true;

    $sizeClass = match($size) {
        'large'   => 'page-header-hero--large',
        'small'   => 'page-header-hero--small',
        default   => 'page-header-hero--default',
    };
@endphp

<header class="page-header-hero {{ $sizeClass }}">
    @if($image)
        <div class="page-header-hero__bg" style="background-image: url('{{ $image }}');"></div>
        @if($overlay)
            <div class="page-header-hero__overlay"></div>
        @endif
    @else
        <div class="page-header-hero__bg page-header-hero__bg--gradient"></div>
    @endif

    <div class="page-header-hero__content">
        <div class="container mx-auto px-4">
            <div class="page-header-hero__inner">

                @if($subtitle && $size === 'large')
                    <span class="page-header-hero__eyebrow">{{ $subtitle }}</span>
                @endif

                <h1 id="page-title" class="page-header-hero__title">{{ $title }}</h1>

                @if($subtitle && $size !== 'large')
                    <p class="page-header-hero__subtitle">{{ $subtitle }}</p>
                @elseif($subtitle && $size === 'large')
                    <p class="page-header-hero__subtitle">{{ $subtitle }}</p>
                @endif

                @if($ctaText && $ctaUrl)
                    <div class="page-header-hero__actions">
                        <a href="{{ $ctaUrl }}" class="page-header-hero__cta">
                            {{ $ctaText }}
                            <svg class="page-header-hero__cta-arrow" width="18" height="12" viewBox="0 0 18 12" fill="none">
                                <path d="M1 6h16m0 0L12 1m5 5l-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>

                        @if($videoUrl)
                            <button type="button" class="page-header-hero__play"
                                    x-data
                                    @click="$dispatch('open-video-modal', { url: '{{ $videoUrl }}' })"
                                    aria-label="{{ __('Videoyu oynat') }}">
                                <span class="page-header-hero__play-circle">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="currentColor">
                                        <path d="M14 8L0 16V0z"/>
                                    </svg>
                                </span>
                                <span class="page-header-hero__play-text">{{ __('Tanıtım Videosu') }}</span>
                            </button>
                        @endif
                    </div>
                @elseif($videoUrl)
                    <div class="page-header-hero__actions">
                        <button type="button" class="page-header-hero__play"
                                x-data
                                @click="$dispatch('open-video-modal', { url: '{{ $videoUrl }}' })"
                                aria-label="{{ __('Videoyu oynat') }}">
                            <span class="page-header-hero__play-circle">
                                <svg width="14" height="16" viewBox="0 0 14 16" fill="currentColor">
                                    <path d="M14 8L0 16V0z"/>
                                </svg>
                            </span>
                            <span class="page-header-hero__play-text">{{ __('Tanıtım Videosu') }}</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
