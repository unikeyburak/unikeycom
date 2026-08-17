@extends('layouts.dealer')

@section('title', __('Profil'))
@section('header', __('Profil Bilgilerim'))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('dealer.profile.update') }}">
            @csrf
            @method('PUT')
            
            <!-- Kişisel Bilgiler -->
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Kişisel Bilgiler') }}</h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Ad Soyad') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', Auth::guard('dealer')->user()->name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('E-posta Adresi') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', Auth::guard('dealer')->user()->email) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('email') border-red-500 @enderror"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Telefon') }}
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', Auth::guard('dealer')->user()->phone) }}"
                               placeholder="0XXX XXX XX XX"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Cep Telefonu') }}
                        </label>
                        <input type="tel" 
                               id="mobile" 
                               name="mobile" 
                               value="{{ old('mobile', Auth::guard('dealer')->user()->mobile) }}"
                               placeholder="0XXX XXX XX XX"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('mobile') border-red-500 @enderror">
                        @error('mobile')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Şifre Değiştirme -->
            <div class="p-6 border-t">
                <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Şifre Değiştir') }}</h3>
                <p class="text-sm text-gray-600 mb-4">{{ __('Şifrenizi değiştirmek istemiyorsanız bu alanları boş bırakın.') }}</p>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Mevcut Şifre') }}
                        </label>
                        <input type="password" 
                               id="current_password" 
                               name="current_password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Yeni Şifre') }}
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('password') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">{{ __('En az 8 karakter') }}</p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Yeni Şifre (Tekrar)') }}
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                    </div>
                </div>
            </div>
            
            <!-- Butonlar -->
            <div class="p-6 bg-gray-50 flex justify-end">
                <button type="submit"
                        class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                    {{ __('Değişiklikleri Kaydet') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection