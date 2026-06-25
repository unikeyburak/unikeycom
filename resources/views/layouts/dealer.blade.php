<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Bayi Paneli') - {{ $settings['site_name'] ?? '' }}</title>
    
    <!-- Fonts -->
    @if($settings['site_favicon'])
    <link rel="icon" type="image/x-icon" href="{{ Storage::url($settings['site_favicon']) }}">
    @endif
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-sm">
            <div class="p-6">
                <a href="{{ route('dealer.dashboard') }}" class="block">
                    @if($settings['site_logo'])
                        <img src="{{ Storage::url($settings['site_logo']) }}" alt="{{ $settings['site_name'] }}" class="h-10">
                    @else
                        <h1 class="text-xl font-bold text-cyan-700">{{ $settings['site_name'] ?? '' }}</h1>
                    @endif
                </a>
                <p class="text-sm text-gray-600 mt-2">{{ __('Bayi Paneli') }}</p>
            </div>
            
            <nav class="px-4 pb-6">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dealer.dashboard') }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dealer.dashboard') ? 'bg-cyan-50 text-cyan-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('dealer.quotes') }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dealer.quotes*') ? 'bg-cyan-50 text-cyan-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            {{ __('Teklif Taleplerim') }}
                            @if(Auth::guard('dealer')->user()->dealer->quoteRequests()->where('status', 'pending')->count() > 0)
                            <span class="ml-auto bg-cyan-600 text-white text-xs rounded-full px-2 py-0.5">
                                {{ Auth::guard('dealer')->user()->dealer->quoteRequests()->where('status', 'pending')->count() }}
                            </span>
                            @endif
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('dealer.products') }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dealer.products*') ? 'bg-cyan-50 text-cyan-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            {{ __('Ürün Kataloğu') }}
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('dealer.profile') }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dealer.profile*') ? 'bg-cyan-50 text-cyan-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ __('Profil') }}
                        </a>
                    </li>
                    
                    <li class="pt-4 mt-4 border-t">
                        <a href="{{ route('dealer.company') }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dealer.company*') ? 'bg-cyan-50 text-cyan-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            {{ __('Firma Bilgileri') }}
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-xl font-semibold">@yield('header', 'Bayi Paneli')</h2>
                    
                    <div class="flex items-center space-x-4">
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                <span>{{ Auth::guard('dealer')->user()->name }}</span>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('home') }}" 
                                   target="_blank"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('Ana Siteye Git') }}
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('dealer.logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Çıkış Yap') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                <div class="mb-4 bg-cyan-100 border border-cyan-400 text-cyan-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
                @endif
                
                @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
                @endif
                
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t px-6 py-4">
                <p class="text-sm text-gray-600 text-center">
                    © {{ date('Y') }} {{ $settings['site_name'] ?? '' }}. {{ __('Tüm hakları saklıdır') }}.
                </p>
            </footer>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>