@extends('layouts.dealer')

@section('title', __('Teklif Talebi').' - '.$product->name)
@section('header', __('Teklif Talebi Oluştur'))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <!-- Ürün Bilgisi -->
        <div class="p-6 border-b bg-gray-50">
            <div class="flex items-center">
                @if($product->image)
                <img src="{{ Storage::url($product->image) }}" 
                     alt="{{ $product->name }}"
                     class="w-20 h-20 rounded object-cover mr-4">
                @endif
                <div>
                    <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                    <p class="text-gray-600">{{ $product->active_ingredient }} - {{ $product->formulation }}</p>
                </div>
            </div>
        </div>
        
        <!-- Form -->
        <form method="POST" action="{{ route('dealer.products.quote.submit', $product) }}" class="p-6">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Miktar ve Birim -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Miktar') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="number" 
                               name="quantity" 
                               value="{{ old('quantity') }}"
                               min="1"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('quantity') border-red-500 @enderror"
                               required>
                        <select name="unit"
                                class="w-32 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('unit') border-red-500 @enderror"
                                required>
                            <option value="Adet" {{ old('unit') == 'Adet' ? 'selected' : '' }}>{{ __('Adet') }}</option>
                            <option value="Kg" {{ old('unit') == 'Kg' ? 'selected' : '' }}>{{ __('Kg') }}</option>
                            <option value="Lt" {{ old('unit') == 'Lt' ? 'selected' : '' }}>{{ __('Lt') }}</option>
                            <option value="Ton" {{ old('unit') == 'Ton' ? 'selected' : '' }}>{{ __('Ton') }}</option>
                            <option value="Paket" {{ old('unit') == 'Paket' ? 'selected' : '' }}>{{ __('Paket') }}</option>
                        </select>
                    </div>
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Teslimat Şehri -->
                <div>
                    <label for="delivery_city" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Teslimat Şehri') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="delivery_city" 
                           name="delivery_city" 
                           value="{{ old('delivery_city') }}"
                           placeholder="Örn: İstanbul"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('delivery_city') border-red-500 @enderror"
                           required>
                    @error('delivery_city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- İstenen Teslimat Tarihi -->
                <div>
                    <label for="delivery_date" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('İstenen Teslimat Tarihi') }}
                    </label>
                    <input type="date" 
                           id="delivery_date" 
                           name="delivery_date" 
                           value="{{ old('delivery_date') }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('delivery_date') border-red-500 @enderror">
                    @error('delivery_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Kullanım Amacı -->
                <div>
                    <label for="usage_purpose" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Kullanım Amacı') }}
                    </label>
                    <input type="text" 
                           id="usage_purpose" 
                           name="usage_purpose" 
                           value="{{ old('usage_purpose') }}"
                           placeholder="Örn: Buğday tarlası için"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('usage_purpose') border-red-500 @enderror">
                    @error('usage_purpose')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Ödeme Şekli -->
                <div class="md:col-span-2">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Tercih Edilen Ödeme Şekli') }}
                    </label>
                    <select id="payment_method" 
                            name="payment_method"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('payment_method') border-red-500 @enderror">
                        <option value="">{{ __('Seçiniz') }}</option>
                        <option value="Nakit" {{ old('payment_method') == 'Nakit' ? 'selected' : '' }}>{{ __('Nakit') }}</option>
                        <option value="Vadeli" {{ old('payment_method') == 'Vadeli' ? 'selected' : '' }}>{{ __('Vadeli') }}</option>
                        <option value="Kredi Kartı" {{ old('payment_method') == 'Kredi Kartı' ? 'selected' : '' }}>{{ __('Kredi Kartı') }}</option>
                        <option value="Havale/EFT" {{ old('payment_method') == 'Havale/EFT' ? 'selected' : '' }}>{{ __('Havale/EFT') }}</option>
                    </select>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Notlar -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Ek Notlar') }}
                    </label>
                    <textarea id="notes"
                              name="notes"
                              rows="4"
                              placeholder="{{ __('Varsa özel isteklerinizi belirtebilirsiniz...') }}"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Bilgilendirme -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-blue-700">
                        {{ __('Teklif talebiniz satış ekibimize iletilecek ve en kısa sürede size dönüş yapılacaktır.') }}
                    </p>
                </div>
            </div>
            
            <!-- Butonlar -->
            <div class="mt-6 flex gap-4">
                <button type="submit"
                        class="flex-1 px-6 py-3 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                    {{ __('Teklif Talebini Gönder') }}
                </button>

                <a href="{{ route('dealer.products.show', $product) }}"
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    {{ __('İptal') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection