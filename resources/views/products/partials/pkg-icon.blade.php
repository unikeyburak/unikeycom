{{-- Ambalaj formatı ikonu. Beklenen: $type ∈ bag|bigbag|jerrican|ibc
     currentColor kullanır → dıştan text-* ile renklendirilir. Sadece SVG (build gerektirmez). --}}
@switch($type ?? 'bag')
    @case('bigbag')
        {{-- Big Bag (FIBC) — köşe kaldırma kulplu büyük dökme torba --}}
        <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M7 3.2c.4 1.5-.1 2.6-1.4 3.3M17 3.2c-.4 1.5.1 2.6 1.4 3.3"/>
            <path d="M10 3.2c.2 1.5-.1 2.6-.9 3.3M14 3.2c-.2 1.5.1 2.6.9 3.3"/>
            <path d="M5.6 6.5h12.8v10.9a2.2 2.2 0 0 1-2.2 2.2H7.8a2.2 2.2 0 0 1-2.2-2.2V6.5Z"/>
            <path d="M6.4 10.2h11.2"/>
        </svg>
        @break
    @case('jerrican')
        {{-- Bidon / jerrican — üst köşe ağızlı, yan kulplu sıvı bidonu --}}
        <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M8 7.5h8.2A1.8 1.8 0 0 1 18 9.3v8.4a2.3 2.3 0 0 1-2.3 2.3H8.3A2.3 2.3 0 0 1 6 17.7V9.5A2 2 0 0 1 8 7.5Z"/>
            <path d="M13 7.5V5.4h3.2V7.5"/>
            <path d="M6 8.4H4.7a1 1 0 0 0-1 1v0.6a1 1 0 0 0 1 1H6"/>
            <path d="M9 12.5h6"/>
        </svg>
        @break
    @case('ibc')
        {{-- IBC tote — kafesli küp tank + alt vana --}}
        <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="4" y="5.5" width="16" height="12.5" rx="1"/>
            <path d="M4 9.7h16M4 13.8h16M9.3 5.5v12.5M14.7 5.5v12.5"/>
            <path d="M9.3 3.5h5.4v2H9.3z"/>
            <path d="M10.5 18h3v2.4h-3z"/>
        </svg>
        @break
    @default
        {{-- Torba / sack — katı-toz ürün çuvalı: katlı üst kapak + şişkin gövde --}}
        <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M8.2 3.6h7.6l-1 2.9H9.2l-1-2.9Z"/>
            <path d="M9.2 6.5h5.6c1.8 1.6 3 4 3 6.9A5.8 5.8 0 0 1 12 20.4a5.8 5.8 0 0 1-5.8-7C6.2 10.5 7.4 8.1 9.2 6.5Z"/>
            <path d="M9.4 13h5.2"/>
        </svg>
@endswitch
