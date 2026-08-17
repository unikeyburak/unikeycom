@extends('layouts.dealer')

@section('title', __('Ürün Kataloğu'))
@section('header', __('Ürün Kataloğu'))

@section('content')
<!-- Filtreler -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6">
        <form method="GET" action="{{ route('dealer.products') }}" class="space-y-4">
            <div class="grid md:grid-cols-4 gap-4">
                <!-- Arama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Ürün Ara') }}</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="{{ __('Ürün adı veya aktif madde...') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                
                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Kategori') }}</label>
                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        <option value="">{{ __('Tüm Kategoriler') }}</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Sıralama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Sıralama') }}</label>
                    <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>{{ __('İsim (A-Z)') }}</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>{{ __('İsim (Z-A)') }}</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('En Yeni') }}</option>
                    </select>
                </div>
                
                <!-- Butonlar -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                        {{ __('Filtrele') }}
                    </button>
                    <a href="{{ route('dealer.products') }}" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-center">
                        {{ __('Temizle') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Ürünler -->
<div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($products as $product)
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
        @if($product->image)
        <img src="{{ Storage::url($product->image) }}" 
             alt="{{ $product->name }}"
             class="w-full h-48 object-cover rounded-t-lg">
        @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
            <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        @endif
        
        <div class="p-4">
            <div class="mb-2">
                <span class="text-xs bg-cyan-100 text-cyan-800 px-2 py-1 rounded">
                    {{ $product->category->name }}
                </span>
            </div>
            
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                {{ $product->name }}
            </h3>
            
            <p class="text-sm text-gray-600 mb-1">
                <strong>{{ __('Aktif Madde') }}:</strong> {{ $product->active_ingredient }}
            </p>

            <p class="text-sm text-gray-600 mb-4">
                <strong>{{ __('Formülasyon') }}:</strong> {{ $product->formulation }}
            </p>
            
            <div class="flex gap-2">
                <a href="{{ route('dealer.products.show', $product) }}"
                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-center text-sm">
                    {{ __('Detay') }}
                </a>
                <a href="{{ route('dealer.products.quote', $product) }}"
                   class="flex-1 px-3 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors text-center text-sm">
                    {{ __('Teklif Al') }}
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <p class="text-lg font-medium text-gray-900">{{ __('Ürün bulunamadı.') }}</p>
            <p class="mt-2 text-sm text-gray-500">{{ __('Arama kriterlerinizi değiştirerek tekrar deneyin.') }}</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Sayfalama -->
@if($products->hasPages())
<div class="mt-8">
    {{ $products->withQueryString()->links() }}
</div>
@endif
@endsection