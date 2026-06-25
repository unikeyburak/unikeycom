@extends('layouts.app')

@section('title', __('Kataloglar') . ' - ' . ($settings['site_name'] ?? config('app.name')))

@section('content')

@include('partials.page-header', [
    'title'    => __('Kataloglar'),
    'subtitle' => __('Ürün kataloglarımızı indirin ve inceleyin.'),
    'image'    => 'https://images.unsplash.com/photo-1481349518771-20055b2a7b24?auto=format&fit=crop&w=2000&q=80',
    'size'     => 'small',
    'overlay'  => true,
])

{{-- ==================== DİL FİLTRESİ ==================== --}}
<section class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4">
        <div class="pt-8 pb-6">

            {{-- Dil Filtresi --}}
            @if($availableLanguages->count() > 1)
                <nav class="flex items-center gap-2 overflow-x-auto pb-1 -mb-px" style="-webkit-overflow-scrolling: touch;">
                    <a href="{{ lroute('catalogs.index') }}"
                       class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-colors
                              {{ !$language ? 'bg-cyan-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ __('Tümü') }}
                    </a>
                    @foreach($availableLanguages as $lang)
                        @php
                            $langLabels = [
                                'tr' => '🇹🇷 Türkçe',
                                'en' => '🇬🇧 English',
                                'fr' => '🇫🇷 Français',
                                'es' => '🇪🇸 Español',
                                'ar' => '🇸🇦 العربية',
                            ];
                        @endphp
                        <a href="{{ lroute('catalogs.index', ['dil' => $lang]) }}"
                           class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-colors
                                  {{ $language === $lang ? 'bg-cyan-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                            {{ $langLabels[$lang] ?? strtoupper($lang) }}
                        </a>
                    @endforeach
                </nav>
            @endif
        </div>
    </div>
</section>

{{-- ==================== KATALOG LİSTESİ ==================== --}}
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">

        @if($catalogs->count() > 0)

            {{-- Sonuç sayısı --}}
            <p class="text-sm text-gray-500 mb-8">
                <span class="font-semibold text-gray-900">{{ $catalogs->count() }}</span> {{ __('katalog bulundu') }}
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($catalogs as $catalog)
                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col">

                        {{-- Kapak Görseli --}}
                        <a href="{{ route('catalogs.show', $catalog->slug) }}" class="relative aspect-[3/4] bg-gradient-to-br from-cyan-50 to-emerald-100 overflow-hidden block">
                            @if($catalog->cover_image)
                                <img src="{{ asset('storage/' . $catalog->cover_image) }}"
                                     alt="{{ $catalog->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                {{-- Placeholder --}}
                                <div class="w-full h-full flex flex-col items-center justify-center p-6">
                                    <svg class="w-16 h-16 text-cyan-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-cyan-400 text-xs font-semibold uppercase tracking-wider">PDF</span>
                                </div>
                            @endif

                            {{-- PDF Rozeti --}}
                            <div class="absolute top-3 right-3">
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md shadow">PDF</span>
                            </div>

                            {{-- Dil Rozeti --}}
                            @php
                                $langLabels = ['tr'=>'TR','en'=>'EN','fr'=>'FR','es'=>'ES','ar'=>'AR'];
                            @endphp
                            <div class="absolute top-3 left-3">
                                <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-semibold px-2 py-1 rounded-md shadow">
                                    {{ $langLabels[$catalog->language] ?? strtoupper($catalog->language) }}
                                </span>
                            </div>
                        </a>

                        {{-- İçerik --}}
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-2 line-clamp-2 group-hover:text-cyan-600 transition-colors">
                                {{ $catalog->translate('title') ?? $catalog->title }}
                            </h3>

                            @if($catalog->description)
                                <p class="text-xs text-gray-500 line-clamp-2 mb-3">
                                    {{ $catalog->translate('description') ?? $catalog->description }}
                                </p>
                            @endif

                            {{-- Meta Bilgiler --}}
                            <div class="flex items-center gap-3 text-xs text-gray-400 mt-auto mb-3">
                                @if($catalog->file_size)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        {{ $catalog->file_size_formatted }}
                                    </span>
                                @endif

                                @if($catalog->download_count > 0)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        {{ number_format($catalog->download_count) }}
                                    </span>
                                @endif
                            </div>

                            {{-- İndir Butonu --}}
                            <a href="{{ route('catalogs.download', $catalog->slug) }}"
                               class="flex items-center justify-center gap-2 w-full bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium py-2.5 px-4 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                {{ __('İndir') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            {{-- Boş Durum --}}
            <div class="text-center py-24">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('Henüz katalog eklenmedi') }}</h3>
                <p class="text-gray-500 text-sm">{{ __('Kataloglar yakında eklenecektir.') }}</p>

                @if($language)
                    <a href="{{ lroute('catalogs.index') }}"
                       class="inline-flex items-center gap-2 mt-6 text-cyan-600 hover:text-cyan-700 font-medium text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ __('Tüm kataloglara dön') }}
                    </a>
                @endif
            </div>
        @endif

    </div>
</section>

@endsection
