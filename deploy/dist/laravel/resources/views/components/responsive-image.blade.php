@props([
    'path',
    'alt' => '',
    'class' => '',
    'sizes' => null,
    'loading' => 'lazy',
    'fetchpriority' => null,
    'decoding' => 'async',
])

@php
    $data = app(\App\Services\MediaService::class)->getResponsiveImageData(
        $path,
        ['sizes' => $sizes]
    );
@endphp

@if($data && !empty($data['src']))
    @php
        $baseAttributes = [
            'class' => $class,
            'loading' => $loading,
            'decoding' => $decoding,
        ];

        if (!empty($fetchpriority)) {
            $baseAttributes['fetchpriority'] = $fetchpriority;
        }
    @endphp
    <img {{ $attributes->merge($baseAttributes) }}
         src="{{ $data['src'] }}"
         @if(!empty($data['srcset'])) srcset="{{ $data['srcset'] }}" @endif
         @if(!empty($data['sizes'])) sizes="{{ $data['sizes'] }}" @endif
         @if(!empty($data['width'])) width="{{ (int) $data['width'] }}" @endif
         @if(!empty($data['height'])) height="{{ (int) $data['height'] }}" @endif
         alt="{{ $alt }}">
@else
    <div class="{{ $class }} flex items-center justify-center bg-gray-100">
        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
    </div>
@endif
