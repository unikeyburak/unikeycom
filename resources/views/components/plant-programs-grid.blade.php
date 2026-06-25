@php
    $plants = \Illuminate\Support\Facades\Cache::remember('homepage_plant_programs_grid', 3600, function () {
        return \App\Models\Plant::active()
            ->showOnHomepage()
            ->withCount('nutritionPrograms')
            ->having('nutrition_programs_count', '>', 0)
            ->limit(12)
            ->get();
    });
@endphp

@if($plants->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <!-- Başlık -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                {{ __('Bitki Besleme Programları') }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ __('Tüm bitkiler için özel hazırlanmış besleme programlarımızı keşfedin') }}
            </p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($plants as $plant)
            <a href="{{ route('nutrition-programs.plant', $plant->slug) }}" 
               class="group text-center">
                <!-- Görsel Container -->
                <div class="relative mb-4 overflow-hidden rounded-xl bg-gradient-to-br from-cyan-50 to-cyan-100 aspect-square">
                    @if($plant->image)
                        <x-responsive-image
                            :path="$plant->image"
                            :alt="$plant->name"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            sizes="120px"
                            loading="lazy"
                            decoding="async"
                        />
                    @else
                        <!-- Varsayılan İkon -->
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-seedling text-6xl text-cyan-600 group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                    @endif
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Program Sayısı Badge -->
                    @if($plant->nutrition_programs_count > 0)
                    <div class="absolute top-2 right-2 bg-cyan-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        {{ $plant->nutrition_programs_count }} {{ __('Program') }}
                    </div>
                    @endif
                </div>
                
                <!-- Bitki Adı -->
                <h3 class="font-semibold text-gray-800 group-hover:text-cyan-600 transition-colors">
                    {{ $plant->name }}
                </h3>
                
                <!-- Bilimsel Ad -->
                @if($plant->scientific_name)
                <p class="text-xs text-gray-500 italic mt-1">
                    {{ $plant->scientific_name }}
                </p>
                @endif
            </a>
            @endforeach
        </div>

        <!-- Tüm Bitkiler Butonu -->
        <div class="text-center mt-12">
            <a href="{{ lroute('nutrition-programs.index') }}" 
               class="inline-flex items-center gap-2 bg-cyan-600 text-white px-8 py-3 rounded-lg hover:bg-cyan-700 transition font-semibold shadow-lg hover:shadow-xl">
                <i class="fas fa-th"></i>
                {{ __('Tüm Bitkileri Gör') }}
            </a>
        </div>
    </div>
</section>
@endif
