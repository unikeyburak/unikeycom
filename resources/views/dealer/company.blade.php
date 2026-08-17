@extends('layouts.dealer')

@section('title', __('Firma Bilgileri'))
@section('header', __('Firma Bilgileri'))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('dealer.company.update') }}">
            @csrf
            @method('PUT')
            
            <!-- Firma Bilgileri -->
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Firma Bilgileri</h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Firma Adı <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="company_name" 
                               name="company_name" 
                               value="{{ old('company_name', $dealer->company_name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('company_name') border-red-500 @enderror"
                               required>
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="tax_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Vergi Numarası <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="tax_number" 
                               name="tax_number" 
                               value="{{ old('tax_number', $dealer->tax_number) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('tax_number') border-red-500 @enderror"
                               required>
                        @error('tax_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="tax_office" class="block text-sm font-medium text-gray-700 mb-2">
                            Vergi Dairesi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="tax_office" 
                               name="tax_office" 
                               value="{{ old('tax_office', $dealer->tax_office) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('tax_office') border-red-500 @enderror"
                               required>
                        @error('tax_office')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                            Web Sitesi
                        </label>
                        <input type="url" 
                               id="website" 
                               name="website" 
                               value="{{ old('website', $dealer->website) }}"
                               placeholder="https://"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('website') border-red-500 @enderror">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="about" class="block text-sm font-medium text-gray-700 mb-2">
                        Firma Hakkında
                    </label>
                    <textarea id="about" 
                              name="about" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('about') border-red-500 @enderror">{{ old('about', $dealer->about) }}</textarea>
                    @error('about')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Adres Bilgileri -->
            <div class="p-6 border-t">
                <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Adres Bilgileri</h3>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                            İl <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               value="{{ old('city', $dealer->city) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('city') border-red-500 @enderror"
                               required>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                            İlçe <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="district" 
                               name="district" 
                               value="{{ old('district', $dealer->district) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('district') border-red-500 @enderror"
                               required>
                        @error('district')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Posta Kodu
                        </label>
                        <input type="text" 
                               id="postal_code" 
                               name="postal_code" 
                               value="{{ old('postal_code', $dealer->postal_code) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('postal_code') border-red-500 @enderror">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Açık Adres <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" 
                              name="address" 
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('address') border-red-500 @enderror"
                              required>{{ old('address', $dealer->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Durum Bilgisi -->
            <div class="p-6 border-t">
                <h3 class="text-lg font-semibold mb-4">Hesap Durumu</h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Onay Durumu</p>
                        <p class="text-lg font-semibold {{ $dealer->is_verified ? 'text-cyan-600' : 'text-yellow-600' }}">
                            {{ $dealer->is_verified ? 'Onaylı' : 'Onay Bekliyor' }}
                        </p>
                    </div>
                    
                    @if($dealer->credit_limit)
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Kredi Limiti</p>
                        <p class="text-lg font-semibold">₺{{ number_format($dealer->credit_limit, 2) }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Butonlar -->
            <div class="p-6 bg-gray-50 flex justify-end">
                <button type="submit" 
                        class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                    Değişiklikleri Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection