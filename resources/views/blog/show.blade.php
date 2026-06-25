@extends('layouts.app')

@section('title', ($meta['title'] ?? $post->title) . ' - ' . config('app.name'))

@push('styles')
<style>
    .prose img { border-radius: 0.5rem; }
    .prose h2 { margin-top: 2rem; margin-bottom: 1rem; }
    .prose h3 { margin-top: 1.5rem; margin-bottom: 0.75rem; }
</style>
@endpush

@section('content')
<!-- Article JSON-LD Schema -->
@if(isset($schema))
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endif

@php
    $postImageUrl = null;
    if (!empty($post->featured_image)) {
        $postImageUrl = str_starts_with($post->featured_image, 'http')
            ? $post->featured_image
            : \Illuminate\Support\Facades\Storage::url($post->featured_image);
    }
@endphp
@include('partials.page-header', [
    'title'    => $post->title,
    'subtitle' => $post->category ? $post->category->name : ($post->excerpt ?? null),
    'image'    => $postImageUrl ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=2000&q=80',
    'size'     => 'default',
    'overlay'  => true,
])

<!-- Article Content -->
<article class="py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">

            <!-- Header -->
            <header class="mb-8">
                <!-- Kategori Badge -->
                @if($post->category)
                    <a href="{{ route('blog.category', $post->category->slug) }}"
                       class="inline-block text-sm font-medium text-cyan-600 bg-cyan-50 px-3 py-1 rounded-full hover:bg-cyan-100 transition-colors mb-4">
                        {{ $post->category->name }}
                    </a>
                @endif

                <!-- Baslik -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                    {{ $post->title }}
                </h1>

                <!-- Meta bilgiler -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <!-- Tarih -->
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $post->published_at?->format('d F Y') ?? $post->created_at->format('d F Y') }}
                    </span>

                    <!-- Okuma suresi -->
                    @if($post->reading_time)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $post->reading_time }} {{ __('dk okuma') }}
                        </span>
                    @endif

                    <!-- Goruntulenme -->
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($post->views) }} {{ __('görüntülenme') }}
                    </span>

                    <!-- Yazar -->
                    @if($post->creator)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $post->creator->name }}
                        </span>
                    @endif
                </div>
            </header>

            <!-- One Cikan Gorsel -->
            @if($post->featured_image)
                <div class="mb-8 rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-auto max-h-[500px] object-cover">
                </div>
            @endif

            <!-- Icerik -->
            <div class="prose prose-lg prose-cyan max-w-none mb-8">
                {!! $post->content !!}
            </div>

            <!-- Etiketler -->
            @if($post->tags->count() > 0)
                <div class="border-t border-b border-gray-200 py-4 mb-8">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm font-medium text-gray-700">{{ __('Etiketler') }}:</span>
                        @foreach($post->tags as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}"
                               class="text-xs px-3 py-1 rounded-full border border-gray-300 text-gray-600 hover:bg-cyan-50 hover:border-cyan-300 hover:text-cyan-600 transition-colors">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Sosyal Medya Paylasim Butonlari -->
            <div class="mb-12">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ __('Paylaş') }}:</h3>
                <div class="flex flex-wrap gap-3">
                    <!-- Twitter/X -->
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode($post->url) }}&text={{ urlencode($post->title) }}"
                       target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-2 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                        X
                    </a>

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($post->url) }}"
                       target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-2 px-4 py-2 bg-[#1877F2] text-white rounded-lg hover:bg-[#166FE5] transition-colors text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($post->url) }}&title={{ urlencode($post->title) }}"
                       target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-2 px-4 py-2 bg-[#0A66C2] text-white rounded-lg hover:bg-[#004182] transition-colors text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        LinkedIn
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . $post->url) }}"
                       target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-2 px-4 py-2 bg-[#25D366] text-white rounded-lg hover:bg-[#20BD5A] transition-colors text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        WhatsApp
                    </a>

                    <!-- Link Kopyala -->
                    <button onclick="navigator.clipboard.writeText('{{ $post->url }}').then(() => { this.textContent = '{{ __("Kopyalandı!") }}'; setTimeout(() => { this.innerHTML = originalText; }, 2000); })"
                            class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        {{ __('Link Kopyala') }}
                    </button>
                </div>
            </div>

        </div>
    </div>
</article>

<!-- Ilgili Yazilar -->
@if($relatedPosts->count() > 0)
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">{{ __('İlgili Yazılar') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedPosts as $related)
                <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
                    <a href="{{ route('blog.show', $related->slug) }}" class="block aspect-video overflow-hidden bg-gray-100">
                        @if($related->featured_image)
                            <img src="{{ asset('storage/' . $related->featured_image) }}"
                                 alt="{{ $related->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-cyan-50">
                                <svg class="w-12 h-12 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                        @endif
                    </a>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('blog.show', $related->slug) }}" class="hover:text-cyan-600 transition-colors">
                                {{ $related->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-gray-500">
                            {{ $related->published_at?->format('d.m.Y') ?? $related->created_at->format('d.m.Y') }}
                            @if($related->reading_time)
                                &middot; {{ $related->reading_time }} {{ __('dk') }}
                            @endif
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
    // Link kopyalama butonu icin orijinal metin
    const originalText = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg> {{ __("Link Kopyala") }}';
</script>
@endpush
@endsection
