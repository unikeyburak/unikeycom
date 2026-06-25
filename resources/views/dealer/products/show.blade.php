@extends('layouts.dealer')

@section('title', $product->name)
@section('header', 'Ürün Detayı')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Sol Kolon - Görsel -->
            <div>
                @if($product->image)
                <img src="{{ Storage::url($product->image) }}" 
                     alt="{{ $product->name }}"
                     class="w-full rounded-lg">
                @else
                <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                    <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
                
                <!-- Dökümanlar -->
                @if($product->brochure || $product->msds || $product->label)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-3">{{ __('Dökümanlar') }}</h3>
                    <div class="space-y-2">
                        @if($product->brochure)
                        <a href="{{ Storage::url($product->brochure) }}" 
                           target="_blank"
                           class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-cyan-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ __('Broşür') }}</span>
                        </a>
                        @endif
                        
                        @if($product->msds)
                        <a href="{{ Storage::url($product->msds) }}" 
                           target="_blank"
                           class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-cyan-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ __('Güvenlik Bilgi Formu') }}</span>
                        </a>
                        @endif
                        
                        @if($product->label)
                        <a href="{{ Storage::url($product->label) }}" 
                           target="_blank"
                           class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-cyan-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ __('Etiket') }}</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Sağ Kolon - Bilgiler -->
            <div>
                <div class="mb-4">
                    <span class="text-sm bg-cyan-100 text-cyan-800 px-3 py-1 rounded">
                        {{ $product->category->name }}
                    </span>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                <div class="space-y-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Aktif Madde') }}</p>
                        <p class="font-semibold">{{ $product->active_ingredient }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Formülasyon') }}</p>
                        <p class="font-semibold">{{ $product->formulation }}</p>
                    </div>
                    
                    @if($product->manufacturer)
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Üretici') }}</p>
                        <p class="font-semibold">{{ $product->manufacturer }}</p>
                    </div>
                    @endif
                    
                    @if($product->license_number)
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Ruhsat No') }}</p>
                        <p class="font-semibold">{{ $product->license_number }}</p>
                    </div>
                    @endif
                </div>
                
                <div class="prose prose-sm text-gray-700 mb-6">
                    {!! $product->description !!}
                </div>
                
                <a href="{{ route('dealer.products.quote', $product) }}" 
                   class="inline-flex items-center px-6 py-3 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    {{ __('Teklif Talebi Oluştur') }}
                </a>
            </div>
        </div>
        
        <!-- Ek Bilgiler -->
        <div class="mt-8 pt-8 border-t">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Kullanım Alanları -->
                @if($product->usage_areas)
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ __('Kullanım Alanları') }}</h3>
                    <div class="prose prose-sm text-gray-700">
                        {!! $product->usage_areas !!}
                    </div>
                </div>
                @endif
                
                <!-- Özellikleri -->
                @if($product->features)
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ __('Özellikleri') }}</h3>
                    <div class="prose prose-sm text-gray-700">
                        {!! $product->features !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- İlgili Ürünler -->
@if($relatedProducts && $relatedProducts->count() > 0)
<div class="mt-8">
    <h2 class="text-2xl font-bold mb-6">{{ __('İlgili Ürünler') }}</h2>
    
    <div class="grid md:grid-cols-4 gap-6">
        @foreach($relatedProducts as $relatedProduct)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
            @if($relatedProduct->image)
            <img src="{{ Storage::url($relatedProduct->image) }}" 
                 alt="{{ $relatedProduct->name }}"
                 class="w-full h-48 object-cover rounded-t-lg">
            @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
                <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            @endif
            
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-2">{{ $relatedProduct->name }}</h3>
                <p class="text-sm text-gray-600 mb-3">{{ $relatedProduct->active_ingredient }}</p>
                
                <a href="{{ route('dealer.products.show', $relatedProduct) }}" 
                   class="text-cyan-600 hover:text-cyan-700 text-sm font-medium">
                    {{ __('Detayları Gör') }} →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection