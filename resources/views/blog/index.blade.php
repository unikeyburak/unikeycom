@extends('layouts.app')

@section('title',
    ($currentCategory ? $currentCategory->translate('name') . ' - ' : '') .
    ($currentTag ? $currentTag->name . ' - ' : '') .
    ($searchQuery ? __('Arama') . ': ' . $searchQuery . ' - ' : '') .
    __('Blog') . ' - ' . config('app.name')
)

@section('content')

@php
    $blogHeroTitle = $currentCategory
        ? $currentCategory->translate('name')
        : ($currentTag ? '#' . $currentTag->name : ($searchQuery ? '"' . $searchQuery . '"' : __('Blog')));
    $blogHeroSubtitle = !$currentCategory && !$currentTag && !$searchQuery
        ? __('Tarım dünyasından en güncel haberler ve bilgiler')
        : ($currentCategory ? ($currentCategory->translate('description') ?? null)
        : ($searchQuery ? __('Arama sonuçları') : null));
@endphp
@include('partials.page-header', [
    'title'    => $blogHeroTitle,
    'subtitle' => $blogHeroSubtitle,
    'image'    => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=2000&q=80',
    'size'     => 'small',
    'overlay'  => true,
])

{{-- ==================== BLOG ARA + KATEGORİ TABLARI ==================== --}}
<section class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4">
        <div class="pt-8 pb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div></div>

                {{-- Search Form --}}
                <form action="{{ lroute('blog.search') }}" method="GET" class="flex-shrink-0">
                    <div class="relative">
                        <input type="text" name="q" value="{{ $searchQuery ?? '' }}"
                               placeholder="{{ __('Blog\'da ara...') }}"
                               class="w-full sm:w-64 pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-full bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>
            </div>

            {{-- Category Tabs --}}
            @if(isset($categories) && $categories->count() > 0)
                <nav class="flex items-center gap-2 overflow-x-auto pb-1 -mb-px" style="-webkit-overflow-scrolling: touch;">
                    <a href="{{ lroute('blog.index') }}"
                       class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-colors
                              {{ !$currentCategory && !$currentTag && !$searchQuery
                                  ? 'bg-cyan-600 text-white'
                                  : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ __('Tümü') }}
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('blog.category', $cat->slug) }}"
                           class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-colors
                                  {{ $currentCategory && $currentCategory->id === $cat->id
                                      ? 'bg-cyan-600 text-white'
                                      : 'text-gray-600 hover:bg-gray-100' }}">
                            {{ $cat->translate('name') }}
                        </a>
                    @endforeach
                </nav>
            @endif
        </div>
    </div>
</section>


@if(!$currentCategory && !$currentTag && !$searchQuery)
    {{-- ==================== DEFAULT VIEW: Hero + Category Sections ==================== --}}

    {{-- Hero Featured Post --}}
    @if(isset($featuredPost) && $featuredPost)
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="group block">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    {{-- Image --}}
                    <div class="aspect-[16/10] rounded-2xl overflow-hidden bg-gray-100">
                        @if($featuredPost->featured_image)
                            <img src="{{ asset('storage/' . $featuredPost->featured_image) }}"
                                 alt="{{ $featuredPost->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-cyan-50 to-cyan-100">
                                <svg class="w-20 h-20 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div>
                        @if($featuredPost->category)
                            <span class="inline-block text-sm font-semibold text-cyan-600 uppercase tracking-wide mb-3">
                                {{ $featuredPost->category->name }}
                            </span>
                        @endif
                        <h2 class="text-2xl lg:text-4xl font-bold text-gray-900 mb-4 group-hover:text-cyan-600 transition-colors leading-tight">
                            {{ $featuredPost->title }}
                        </h2>
                        @if($featuredPost->excerpt)
                            <p class="text-gray-500 text-base lg:text-lg mb-6 line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($featuredPost->excerpt), 200) }}
                            </p>
                        @endif
                        <div class="flex items-center gap-4 text-sm text-gray-400">
                            <time datetime="{{ $featuredPost->published_at?->toDateString() }}">
                                {{ $featuredPost->published_at?->format('d.m.Y') ?? $featuredPost->created_at->format('d.m.Y') }}
                            </time>
                            @if($featuredPost->reading_time)
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $featuredPost->reading_time }} dk okuma
                                </span>
                            @endif
                        </div>
                        <div class="mt-6">
                            <span class="inline-flex items-center gap-2 text-cyan-600 font-medium group-hover:gap-3 transition-all">
                                {{ __('Devamını Oku') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>
    @endif

    {{-- Category Sections --}}
    @if(isset($categoryPosts))
        @foreach($categoryPosts as $catSection)
            @if($catSection->latestPosts && $catSection->latestPosts->count() > 0)
            <section class="py-12 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                <div class="container mx-auto px-4">
                    {{-- Section Header --}}
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $catSection->translate('name') }}</h2>
                        @if($catSection->posts_count > 3)
                            <a href="{{ route('blog.category', $catSection->slug) }}"
                               class="text-sm font-medium text-cyan-600 hover:text-cyan-700 flex items-center gap-1 group/link">
                                {{ __('Tümünü Gör') }}
                                <svg class="w-4 h-4 group-hover/link:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif
                    </div>

                    {{-- Post Cards Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($catSection->latestPosts as $post)
                            @include('blog.partials.card', ['post' => $post])
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
        @endforeach
    @endif

    {{-- Empty State --}}
    @if((!isset($featuredPost) || !$featuredPost) && (!isset($categoryPosts) || $categoryPosts->isEmpty()))
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4 text-center">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Henüz yazı bulunamadı') }}</h3>
                <p class="text-gray-500">{{ __('Yakında yeni yazılar eklenecektir.') }}</p>
            </div>
        </section>
    @endif

@else
    {{-- ==================== FILTERED VIEW: Category / Tag / Search ==================== --}}
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            @if(isset($posts))
                {{-- Breadcrumb --}}
                <nav class="mb-6 text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-cyan-600 transition-colors">{{ __('Ana Sayfa') }}</a>
                    <span class="mx-2">/</span>
                    <a href="{{ lroute('blog.index') }}" class="hover:text-cyan-600 transition-colors">{{ __('Blog') }}</a>
                    @if($currentCategory)
                        <span class="mx-2">/</span>
                        <span class="text-gray-900">{{ $currentCategory->translate('name') }}</span>
                    @elseif($currentTag)
                        <span class="mx-2">/</span>
                        <span class="text-gray-900">{{ $currentTag->name }}</span>
                    @elseif($searchQuery)
                        <span class="mx-2">/</span>
                        <span class="text-gray-900">{{ __('Arama') }}</span>
                    @endif
                </nav>

                {{-- Results count --}}
                <div class="mb-8">
                    <p class="text-sm text-gray-500">
                        <span class="font-semibold text-gray-900">{{ $posts->total() }}</span> {{ __('yazı bulundu') }}
                    </p>
                </div>

                @if($posts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($posts as $post)
                            @include('blog.partials.card', ['post' => $post])
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $posts->withQueryString()->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Yazı bulunamadı') }}</h3>
                        <p class="text-gray-500 mb-6">{{ __('Aradığınız kriterlere uygun yazı bulunmuyor.') }}</p>
                        <a href="{{ lroute('blog.index') }}" class="inline-flex items-center gap-2 text-cyan-600 hover:text-cyan-700 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{ __('Tüm yazılara dön') }}
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </section>
@endif

@endsection
