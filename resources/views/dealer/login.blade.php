@extends('layouts.app')

@section('title', __('Bayi Girişi') . ' - ' . config('app.name'))
@section('meta_description', config('app.name') . ' ' . __('bayi portalı giriş sayfası'))

@section('content')
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg">
            <div class="p-8">
                <h1 class="text-2xl font-bold text-center mb-6">{{ __('Bayi Girişi') }}</h1>
                
                @if(session('success'))
                <div class="bg-cyan-100 border border-cyan-400 text-cyan-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
                @endif
                
                @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form method="POST" action="{{ route('dealer.login.submit') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('E-posta Adresi') }}
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('email') border-red-500 @enderror"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Şifre') }}
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('password') border-red-500 @enderror"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-cyan-500">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Beni hatırla') }}</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="w-full bg-cyan-600 text-white py-2 px-4 rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                        {{ __('Giriş Yap') }}
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        {{ __('Henüz bayi değil misiniz?') }}
                        <a href="{{ route('dealer.register') }}" class="text-cyan-600 hover:underline font-medium">
                            {{ __('Bayi başvurusu yapın') }}
                        </a>
                    </p>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('dealer.password.forgot') }}" class="text-sm text-gray-600 hover:text-cyan-600 hover:underline">
                        {{ __('Şifremi unuttum') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection