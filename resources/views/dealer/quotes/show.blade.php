@extends('layouts.dealer')

@section('title', __('Teklif Detayı').' #'.$quote->id)
@section('header', __('Teklif Detayı'))

@section('content')
<div class="bg-white rounded-lg shadow">
    <!-- Üst Bilgi -->
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold">#{{ $quote->id }} - {{ $quote->product->name }}</h3>
            <p class="text-sm text-gray-500">{{ $quote->created_at->format('d.m.Y H:i') }}</p>
        </div>
        <div>
            @php
                $statusClasses = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'processing' => 'bg-blue-100 text-blue-800',
                    'completed' => 'bg-cyan-100 text-cyan-800',
                    'cancelled' => 'bg-red-100 text-red-800'
                ];
                $statusTexts = [
                    'pending' => __('Beklemede'),
                    'processing' => __('İşleniyor'),
                    'completed' => __('Tamamlandı'),
                    'cancelled' => __('İptal')
                ];
            @endphp
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusClasses[$quote->status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $statusTexts[$quote->status] ?? __('Bilinmiyor') }}
            </span>
        </div>
    </div>
    
    <!-- İçerik -->
    <div class="p-6">
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Sol Kolon -->
            <div>
                <h4 class="font-semibold text-gray-900 mb-4">{{ __('Ürün Bilgileri') }}</h4>
                
                <div class="space-y-4">
                    @if($quote->product->image)
                    <div>
                        <img src="{{ Storage::url($quote->product->image) }}" 
                             alt="{{ $quote->product->name }}"
                             class="w-32 h-32 rounded-lg object-cover">
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Ürün Adı') }}</p>
                        <p class="font-medium">{{ $quote->product->name }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Aktif Madde') }}</p>
                        <p class="font-medium">{{ $quote->product->active_ingredient }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Formülasyon') }}</p>
                        <p class="font-medium">{{ $quote->product->formulation }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Sağ Kolon -->
            <div>
                <h4 class="font-semibold text-gray-900 mb-4">{{ __('Teklif Detayları') }}</h4>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Talep Edilen Miktar') }}</p>
                        <p class="font-medium text-lg">{{ $quote->quantity }} {{ $quote->unit }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Teslimat Şehri') }}</p>
                        <p class="font-medium">{{ $quote->delivery_city }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">{{ __('İstenen Teslimat Tarihi') }}</p>
                        <p class="font-medium">
                            {{ $quote->delivery_date ? \Carbon\Carbon::parse($quote->delivery_date)->format('d.m.Y') : __('Belirtilmemiş') }}
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Kullanım Amacı') }}</p>
                        <p class="font-medium">{{ $quote->usage_purpose ?: __('Belirtilmemiş') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Ödeme Şekli') }}</p>
                        <p class="font-medium">{{ $quote->payment_method ?: __('Belirtilmemiş') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        @if($quote->notes)
        <div class="mt-6 pt-6 border-t">
            <h4 class="font-semibold text-gray-900 mb-2">{{ __('Ek Notlar') }}</h4>
            <p class="text-gray-700">{{ $quote->notes }}</p>
        </div>
        @endif
    </div>
    
    <!-- Durum Geçmişi -->
    @if($quote->status_history && count($quote->status_history) > 0)
    <div class="px-6 py-4 border-t">
        <h4 class="font-semibold text-gray-900 mb-4">{{ __('Durum Geçmişi') }}</h4>
        <div class="space-y-3">
            @foreach($quote->status_history as $history)
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">
                        {{ $statusTexts[$history['status']] ?? $history['status'] }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($history['date'])->format('d.m.Y H:i') }}
                        @if(isset($history['note']))
                        - {{ $history['note'] }}
                        @endif
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Alt Butonlar -->
    <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
        <a href="{{ route('dealer.quotes') }}" 
           class="text-gray-600 hover:text-gray-900">
            ← {{ __('Geri Dön') }}
        </a>
        
        @if($quote->status === 'pending')
        <form method="POST" action="{{ route('dealer.quotes.cancel', $quote) }}" 
              onsubmit="return confirm('{{ __('Bu teklif talebini iptal etmek istediğinizden emin misiniz?') }}')">
            @csrf
            @method('PUT')
            <button type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                {{ __('İptal Et') }}
            </button>
        </form>
        @endif
    </div>
</div>
@endsection