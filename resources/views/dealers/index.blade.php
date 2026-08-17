@extends('layouts.app')

@section('title', __('Bayiler') . ' - ' . config('app.name'))
@section('meta_description', config('app.name') . ' ' . __('bayi ağı.'))

@section('content')
@include('partials.page-header', [
    'title'    => __('Bayiler'),
    'subtitle' => __('Size en yakın Unikeyterra bayisini bulun ve ürünlerimize kolayca ulaşın.'),
    'image'    => 'https://images.unsplash.com/photo-1604223190546-a43e4c9fedaa?auto=format&fit=crop&w=2000&q=80',
    'size'     => 'default',
    'overlay'  => true,
])

<!-- Dealers List -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <!-- Search and Filter -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
            <form action="{{ lroute('dealers.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="Bayi adı veya lokasyon ara..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                
                <!-- City Filter -->
                <div>
                    <select name="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        <option value="">Tüm Şehirler</option>
                        @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-cyan-600 text-white px-6 py-2 rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                        Ara
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Dealers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($dealers as $dealer)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <!-- Company Name -->
                    <h3 class="text-xl font-semibold mb-2">{{ $dealer->company_name }}</h3>
                    
                    <!-- Location -->
                    <p class="text-gray-600 mb-4">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $dealer->district }}, {{ $dealer->city }}
                    </p>
                    
                    <!-- Contact Info -->
                    <div class="space-y-2 text-sm">
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $dealer->phone }}
                        </p>
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $dealer->email }}
                        </p>
                        @if($dealer->website)
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            <a href="https://{{ $dealer->website }}" target="_blank" class="text-cyan-600 hover:text-cyan-700">
                                {{ $dealer->website }}
                            </a>
                        </p>
                        @endif
                    </div>
                    
                    <!-- Address -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            {{ $dealer->address }}
                        </p>
                    </div>
                    
                    <!-- View Details -->
                    <div class="mt-4">
                        <button class="text-cyan-600 hover:text-cyan-700 font-medium text-sm inline-flex items-center">
                            {{ __('Detayları Gör') }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Bayi bulunamadı.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $dealers->withQueryString()->links() }}
        </div>
    </div>
</section>

<!-- Become a Dealer CTA -->
<section class="py-16 bg-cyan-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Bayimiz Olmak İster misiniz?</h2>
            <p class="text-xl text-gray-700 mb-8">
                Güçlü bayi ağımıza katılın ve birlikte büyüyelim
            </p>
            <a href="{{ route('dealer.register') }}" class="bg-cyan-600 text-white px-8 py-3 rounded-lg hover:bg-cyan-700 transition-colors font-medium inline-flex items-center">
                Bayi Başvurusu Yap
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection