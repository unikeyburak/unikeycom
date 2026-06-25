@extends('layouts.app')

@section('title', ($catalog->translate('title') ?? $catalog->title) . ' - ' . ($settings['site_name'] ?? config('app.name')))

@section('content')

@include('partials.page-header', [
    'title'    => $catalog->translate('title') ?? $catalog->title,
    'subtitle' => $catalog->description
        ? ($catalog->translate('description') ?? $catalog->description)
        : null,
    'image'    => 'https://images.unsplash.com/photo-1481349518771-20055b2a7b24?auto=format&fit=crop&w=2000&q=80',
    'ctaText'  => __('PDF İndir'),
    'ctaUrl'   => route('catalogs.download', $catalog->slug),
    'size'     => 'default',
    'overlay'  => true,
])

{{-- ==================== EK BİLGİ + BUTON ==================== --}}
<section class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-4 text-xs text-gray-400">
                    @if($catalog->file_size)
                        <span>{{ $catalog->file_size_formatted }}</span>
                    @endif
                    @if($catalog->download_count > 0)
                        <span>{{ number_format($catalog->download_count) }} {{ __('indirme') }}</span>
                    @endif
                </div>
            </div>

            {{-- İndir Butonu --}}
            <a href="{{ route('catalogs.download', $catalog->slug) }}"
               class="flex-shrink-0 inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white font-medium px-6 py-3 rounded-xl transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                {{ __('PDF İndir') }}
                @if($catalog->file_size)
                    <span class="text-cyan-200 text-xs">({{ $catalog->file_size_formatted }})</span>
                @endif
            </a>
        </div>
    </div>
</section>

{{-- ==================== PDF GÖRÜNTÜLEYICI ==================== --}}
<section class="bg-gray-100 min-h-screen py-6">
    <div class="container mx-auto px-4">

        @if($catalog->file_path)
        {{-- PDF Görüntüleyici --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="height: 85vh;">
            <iframe
                src="{{ route('catalogs.view', $catalog->slug) }}"
                class="w-full h-full border-0"
                title="{{ $catalog->translate('title') ?? $catalog->title }}">
            </iframe>
        </div>
        <p class="text-center text-sm text-gray-400 mt-3">
            {{ __('PDF görüntülenmiyor mu?') }}
            <a href="{{ route('catalogs.download', $catalog->slug) }}" class="text-cyan-600 hover:underline">
                {{ __('Buradan indirin') }}
            </a>
        </p>
        @else
        {{-- PDF henüz yüklenmedi --}}
        <div class="bg-white rounded-2xl shadow-sm flex flex-col items-center justify-center py-24 text-center">
            <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-gray-500 font-medium mb-1">{{ __('PDF henüz yüklenmedi') }}</h3>
            <p class="text-gray-400 text-sm">{{ __('Lütfen daha sonra tekrar deneyin.') }}</p>
        </div>
        @endif

        {{-- Alt butonlar --}}
        <div class="flex items-center justify-between mt-4">
            <a href="{{ lroute('catalogs.index') }}"
               class="inline-flex items-center gap-2 text-gray-500 hover:text-cyan-600 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('Tüm Kataloglar') }}
            </a>

            <a href="{{ route('catalogs.download', $catalog->slug) }}"
               class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                {{ __('PDF İndir') }}
            </a>
        </div>
    </div>
</section>

@endsection
