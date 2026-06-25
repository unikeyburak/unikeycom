@php
    $activeLanguages = \Illuminate\Support\Facades\Cache::remember('active_languages', 3600, function () {
        return App\Models\Language::getActive();
    });
    $currentLanguage = $activeLanguages->firstWhere('code', app()->getLocale());
@endphp

@if($activeLanguages->count() > 1)
<div class="relative" x-data="{ open: false }">
    <!-- Current Language Button -->
    <button @click="open = !open"
            @click.away="open = false"
            class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition-colors">
        <span class="text-lg">{{ $currentLanguage->flag ?? '🌐' }}</span>
        <span class="hidden sm:inline">{{ $currentLanguage->native_name ?? 'Dil Seç' }}</span>
        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <!-- Language Dropdown -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 @if($currentLanguage && $currentLanguage->isRtl()) left-0 right-auto @endif">
        <div class="py-1">
            @foreach($activeLanguages as $language)
                @php
                    // Mevcut sayfanın hedef dildeki URL'sini hesapla
                    $targetUrl = lroute_for_locale($language->code);
                    // Dil değiştirme rotasına `to` parametresi olarak ilet
                    $switchUrl = route('change.language', [
                        'language' => $language->code,
                        'to'       => $targetUrl,
                    ]);
                @endphp
                <a href="{{ $switchUrl }}"
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 @if($language->code === app()->getLocale()) bg-cyan-50 @endif">
                    <span class="mr-3">{{ $language->flag }}</span>
                    <span>{{ $language->native_name }}</span>
                    @if($language->code === app()->getLocale())
                        <svg class="w-4 h-4 ml-auto text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif
