@extends('layouts.app')

@section('title', __('Bayi Başvurusu') . ' - ' . config('app.name'))
@section('meta_description', config('app.name') . ' ' . __('bayi başvuru formu.'))

@section('content')
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h1 class="text-3xl font-bold text-center mb-8">{{ __('Bayi Başvurusu') }}</h1>
                <p class="text-gray-600 text-center mb-8">
                    {{ __('Güçlü bayi ağımıza katılmak için aşağıdaki formu doldurun.') }}
                </p>
                
                @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <p class="font-semibold mb-2">{{ __('Lütfen aşağıdaki hataları düzeltin:') }}</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form method="POST" action="{{ route('dealer.register.submit') }}" class="space-y-8">
                    @csrf
                    
                    <!-- Şirket Bilgileri -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 pb-2 border-b">{{ __('Şirket Bilgileri') }}</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Şirket Adı') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="company_name" 
                                       name="company_name" 
                                       value="{{ old('company_name') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('company_name') border-red-500 @enderror"
                                       required>
                            </div>
                            
                            <div>
                                <label for="tax_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Vergi Numarası') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="tax_number" 
                                       name="tax_number" 
                                       value="{{ old('tax_number') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('tax_number') border-red-500 @enderror"
                                       required>
                            </div>
                            
                            <div>
                                <label for="tax_office" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Vergi Dairesi') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="tax_office" 
                                       name="tax_office" 
                                       value="{{ old('tax_office') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('tax_office') border-red-500 @enderror"
                                       required>
                            </div>
                            
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Web Sitesi') }}
                                </label>
                                <input type="url" 
                                       id="website" 
                                       name="website" 
                                       value="{{ old('website') }}"
                                       placeholder="https://"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('website') border-red-500 @enderror">
                            </div>
                        </div>
                    </div>
                    
                    <!-- İletişim Bilgileri -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 pb-2 border-b">{{ __('İletişim Bilgileri') }}</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Yetkili Adı Soyadı') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="contact_name" 
                                       name="contact_name" 
                                       value="{{ old('contact_name') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('contact_name') border-red-500 @enderror"
                                       required>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('E-posta Adresi') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('email') border-red-500 @enderror"
                                       required>
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Telefon') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       placeholder="0XXX XXX XX XX"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('phone') border-red-500 @enderror"
                                       required>
                            </div>
                            
                            <div>
                                <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">
                                    WhatsApp
                                </label>
                                <input type="tel" 
                                       id="whatsapp" 
                                       name="whatsapp" 
                                       value="{{ old('whatsapp') }}"
                                       placeholder="0XXX XXX XX XX"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('whatsapp') border-red-500 @enderror">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Adres Bilgileri -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 pb-2 border-b">{{ __('Adres Bilgileri') }}</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('İl') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="city" 
                                       name="city" 
                                       value="{{ old('city') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('city') border-red-500 @enderror"
                                       required>
                            </div>
                            
                            <div>
                                <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('İlçe') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="district" 
                                       name="district" 
                                       value="{{ old('district') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('district') border-red-500 @enderror"
                                       required>
                            </div>
                            
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Posta Kodu') }}
                                </label>
                                <input type="text" 
                                       id="postal_code" 
                                       name="postal_code" 
                                       value="{{ old('postal_code') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('postal_code') border-red-500 @enderror">
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Açık Adres') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" 
                                      name="address" 
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('address') border-red-500 @enderror"
                                      required>{{ old('address') }}</textarea>
                        </div>
                    </div>
                    
                    <!-- Giriş Bilgileri -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 pb-2 border-b">{{ __('Giriş Bilgileri') }}</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Şifre') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('password') border-red-500 @enderror"
                                       required>
                                <p class="mt-1 text-xs text-gray-500">{{ __('En az 8 karakter') }}</p>
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Şifre Tekrar') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                                       required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Şirket Hakkında -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 pb-2 border-b">{{ __('Ek Bilgiler') }}</h2>
                        <div>
                            <label for="about" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Şirketiniz Hakkında') }}
                            </label>
                            <textarea id="about" 
                                      name="about" 
                                      rows="4"
                                      placeholder="{{ __('Faaliyet alanlarınız, müşteri portföyünüz vb. hakkında bilgi verebilirsiniz...') }}"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('about') border-red-500 @enderror">{{ old('about') }}</textarea>
                        </div>
                    </div>
                    
                    <!-- Submit -->
                    <div>
                        <div class="mb-4">
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       required
                                       class="w-4 h-4 mt-1 text-cyan-600 border-gray-300 rounded focus:ring-cyan-500">
                                <span class="ml-2 text-sm text-gray-600">
                                    <a href="{{ lroute('terms') }}" target="_blank" class="text-cyan-600 hover:underline">{{ __('Kullanım şartlarını') }}</a> {{ __('ve') }}
                                    <a href="{{ lroute('privacy') }}" target="_blank" class="text-cyan-600 hover:underline">{{ __('gizlilik politikasını') }}</a>
                                    {{ __('okudum, kabul ediyorum.') }}
                                </span>
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition-colors font-medium text-lg">
                            {{ __('Başvuruyu Gönder') }}
                        </button>
                    </div>
                </form>
                
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        {{ __('Zaten bayi misiniz?') }}
                        <a href="{{ route('dealer.login') }}" class="text-cyan-600 hover:underline font-medium">
                            {{ __('Giriş yapın') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection