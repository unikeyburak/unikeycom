@extends('layouts.dealer')

@section('title', 'Teklif Taleplerim')
@section('header', 'Teklif Taleplerim')

@section('content')
<div class="bg-white rounded-lg shadow">
    <!-- Filtreler -->
    <div class="p-6 border-b">
        <form method="GET" action="{{ route('dealer.quotes') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Durum') }}</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                    <option value="">{{ __('Tümü') }}</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Beklemede') }}</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('İşleniyor') }}</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Tamamlandı') }}</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('İptal') }}</option>
                </select>
            </div>
            
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Tarih Aralığı') }}</label>
                <div class="flex gap-2">
                    <input type="date" 
                           name="start_date" 
                           value="{{ request('start_date') }}"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                    <input type="date" 
                           name="end_date" 
                           value="{{ request('end_date') }}"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                </div>
            </div>
            
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                    {{ __('Filtrele') }}
                </button>
                <a href="{{ route('dealer.quotes') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    {{ __('Temizle') }}
                </a>
            </div>
        </form>
    </div>
    
    <!-- Tablo -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        #ID
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Ürün') }}
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Miktar') }}
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Durum') }}
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Tarih') }}
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('İşlem') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($quotes as $quote)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        #{{ $quote->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($quote->product->image)
                            <img src="{{ Storage::url($quote->product->image) }}" 
                                 alt="{{ $quote->product->name }}"
                                 class="w-10 h-10 rounded object-cover mr-3">
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $quote->product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $quote->product->active_ingredient }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $quote->quantity }} {{ $quote->unit }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
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
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$quote->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusTexts[$quote->status] ?? __('Bilinmiyor') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div>
                            <p>{{ $quote->created_at->format('d.m.Y') }}</p>
                            <p class="text-xs">{{ $quote->created_at->format('H:i') }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('dealer.quotes.show', $quote) }}" 
                           class="text-cyan-600 hover:text-cyan-900">
                            {{ __('Detay') }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-lg font-medium">{{ __('Henüz teklif talebiniz bulunmuyor') }}</p>
                        <p class="mt-2 text-sm">{{ __('Ürün kataloğundan teklif talebi oluşturabilirsiniz.') }}</p>
                        <a href="{{ route('dealer.products') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                            {{ __('Ürün Kataloğuna Git') }}
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Sayfalama -->
    @if($quotes->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $quotes->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection