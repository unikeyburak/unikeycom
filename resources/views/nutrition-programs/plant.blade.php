@extends('layouts.app')

@section('title', $plant->name . ' Besleme Programları')

@section('content')

@php
    $plantImageUrl = null;
    if (!empty($plant->image)) {
        $plantImageUrl = str_starts_with($plant->image, 'http')
            ? $plant->image
            : \Illuminate\Support\Facades\Storage::url($plant->image);
    }
@endphp
@include('partials.page-header', [
    'title'    => $plant->name . ' ' . __('Besleme Programları'),
    'subtitle' => $plant->scientific_name ?: ($plant->description ? strip_tags($plant->description) : __('Uzman tarafından hazırlanmış besleme programları ile verimi artırın.')),
    'image'    => $plantImageUrl ?? 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=2000&q=80',
    'size'     => 'default',
    'overlay'  => true,
])

{{-- Özet istatistikleri --}}
<section class="bg-white border-b border-gray-100 py-6">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center gap-10">
            <div class="text-center">
                <div class="text-3xl font-bold text-cyan-600">{{ $programs->count() }}</div>
                <div class="text-sm text-gray-600">{{ __('Program') }}</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-cyan-600">
                    {{ $programs->sum(function($p) { return $p->stages->count(); }) }}
                </div>
                <div class="text-sm text-gray-600">{{ __('Aşama') }}</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-cyan-600">
                    {{ $programs->sum(function($p) { return $p->all_products->count(); }) }}
                </div>
                <div class="text-sm text-gray-600">{{ __('Ürün') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Programlar -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            
            @if($programs->count() > 0)
                <h2 class="text-3xl font-bold text-gray-800 mb-8">{{ __('Mevcut Programlar') }}</h2>
                
                <div class="space-y-8">
                    @foreach($programs as $program)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="md:flex">
                            <!-- Sol: Program Bilgileri -->
                            <div class="md:w-2/3 p-8">
                                <div class="flex items-center gap-4 mb-4">
                                    <h3 class="text-2xl font-bold text-gray-800">{{ $program->title }}</h3>
                                    @if($program->is_featured)
                                        <span class="bg-cyan-100 text-cyan-800 text-xs font-semibold px-3 py-1 rounded-full">
                                            {{ __('Önerilen') }}
                                        </span>
                                    @endif
                                </div>
                                
                                @if($program->description)
                                <p class="text-gray-600 mb-6">{{ $program->description }}</p>
                                @endif
                                
                                <!-- Özellikler -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                    @if($program->season)
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <i class="fas fa-calendar-alt text-2xl text-cyan-600 mb-2"></i>
                                        <div class="text-xs text-gray-500">{{ __('Mevsim') }}</div>
                                        <div class="font-semibold">{{ $program->season }}</div>
                                    </div>
                                    @endif
                                    
                                    @if($program->growth_stage)
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <i class="fas fa-chart-line text-2xl text-cyan-600 mb-2"></i>
                                        <div class="text-xs text-gray-500">{{ __('Dönem') }}</div>
                                        <div class="font-semibold">{{ $program->growth_stage }}</div>
                                    </div>
                                    @endif
                                    
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <i class="fas fa-layer-group text-2xl text-cyan-600 mb-2"></i>
                                        <div class="text-xs text-gray-500">{{ __('Aşama') }}</div>
                                        <div class="font-semibold">{{ $program->stages->count() }}</div>
                                    </div>
                                    
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <i class="fas fa-box text-2xl text-cyan-600 mb-2"></i>
                                        <div class="text-xs text-gray-500">{{ __('Ürün') }}</div>
                                        <div class="font-semibold">{{ $program->all_products->count() }}</div>
                                    </div>
                                </div>
                                
                                <!-- Aşamalar -->
                                @if($program->stages->count() > 0)
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-800 mb-3">{{ __('Uygulama Aşamaları') }}</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($program->stages as $stage)
                                        <div class="flex items-center gap-2 bg-cyan-50 px-4 py-2 rounded-full">
                                            <div class="w-6 h-6 bg-cyan-600 text-white rounded-full flex items-center justify-center text-xs font-bold">
                                                {{ $loop->iteration }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">{{ $stage->title }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Buton -->
                                <a href="{{ $program->url }}" 
                                   class="inline-flex items-center gap-2 bg-cyan-600 text-white px-6 py-3 rounded-lg hover:bg-cyan-700 transition font-semibold">
                                    <i class="fas fa-arrow-right"></i>
                                    {{ __('Programı İncele') }}
                                </a>
                            </div>
                            
                            <!-- Sağ: Faydalar -->
                            <div class="md:w-1/3 bg-gradient-to-br from-cyan-50 to-cyan-100 p-8">
                                <h4 class="font-semibold text-gray-800 mb-4">{{ __('Program Faydaları') }}</h4>
                                <div class="space-y-3">
                                    @forelse($program->benefits as $benefit)
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-6 h-6 bg-cyan-600 rounded-full flex items-center justify-center">
                                            @if($benefit->icon)
                                                <i class="{{ $benefit->icon }} text-white text-xs"></i>
                                            @else
                                                <i class="fas fa-check text-white text-xs"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800">{{ $benefit->title }}</div>
                                            @if($benefit->description)
                                            <div class="text-sm text-gray-600">{{ $benefit->description }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-gray-600 text-sm">{{ __('Program faydaları yakında eklenecek.') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-seedling text-6xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-500">{{ __('Bu bitki için henüz program eklenmemiş.') }}</p>
                </div>
            @endif
            
        </div>
    </div>
</section>

<!-- İlgili Diğer Bitkiler -->
@if($relatedPlants->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">{{ __('Diğer Bitkiler') }}</h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6">
            @foreach($relatedPlants as $relatedPlant)
            <a href="{{ route('nutrition-programs.plant', $relatedPlant->slug) }}" 
               class="group text-center">
                <div class="relative mb-4 overflow-hidden rounded-xl bg-white aspect-square">
                    @if($relatedPlant->image)
                        <x-responsive-image
                            :path="$relatedPlant->image"
                            :alt="$relatedPlant->name"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            sizes="120px"
                            loading="lazy"
                            decoding="async"
                        />
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-cyan-50 to-cyan-100">
                            <i class="fas fa-seedling text-4xl text-cyan-600"></i>
                        </div>
                    @endif
                </div>
                <h3 class="font-semibold text-gray-800 group-hover:text-cyan-600 transition-colors">
                    {{ $relatedPlant->name }}
                </h3>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
