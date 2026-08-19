{{-- Ambalaj formatı ikonu. Beklenen: $type ∈ sachet|sack|bigbag|bottle|jerrican|ibc
     currentColor kullanır → dıştan text-* ile renklendirilir. Sadece SVG (build gerektirmez). --}}
@switch($type ?? 'sack')
    @case('sachet')
        {{-- Poşet — küçük düz stand-up poşet (gr) --}}
        <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M8 4.3h8v1.4H8z"/>
            <path d="M8 5.7h8v12.6a1.6 1.6 0 0 1-1.6 1.6H9.6A1.6 1.6 0 0 1 8 18.3V5.7Z"/>
            <path d="M16 7.4l1.7-.7"/>
            <path d="M10.4 11h3.2"/>
        </svg>
        @break
    @case('bigbag')
        {{-- Big Bag (FIBC) — köşe kaldırma kulplu büyük dökme torba --}}
        <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M7 3.2c.4 1.5-.1 2.6-1.4 3.3M17 3.2c-.4 1.5.1 2.6 1.4 3.3"/>
            <path d="M10 3.2c.2 1.5-.1 2.6-.9 3.3M14 3.2c-.2 1.5.1 2.6.9 3.3"/>
            <path d="M5.6 6.5h12.8v10.9a2.2 2.2 0 0 1-2.2 2.2H7.8a2.2 2.2 0 0 1-2.2-2.2V6.5Z"/>
            <path d="M6.4 10.2h11.2"/>
        </svg>
        @break
    @case('bottle')
        {{-- Şişe — kapak + boyun + omuzlu küçük şişe (cc) --}}
        <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M10.5 3.4h3v1.9h-3z"/>
            <path d="M11 5.3v1.5c0 .8-.3 1.1-.9 1.6-.9.8-1.1 1.6-1.1 2.9V18a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-6.7c0-1.3-.2-2.1-1.1-2.9-.6-.5-.9-.8-.9-1.6V5.3"/>
            <path d="M9 13h6"/>
        </svg>
        @break
    @case('jerrican')
        {{-- Bidon / jerrican — üst köşe ağızlı, yan kulplu sıvı bidonu (L) --}}
        <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M8 7.5h8.2A1.8 1.8 0 0 1 18 9.3v8.4a2.3 2.3 0 0 1-2.3 2.3H8.3A2.3 2.3 0 0 1 6 17.7V9.5A2 2 0 0 1 8 7.5Z"/>
            <path d="M13 7.5V5.4h3.2V7.5"/>
            <path d="M6 8.4H4.7a1 1 0 0 0-1 1v0.6a1 1 0 0 0 1 1H6"/>
            <path d="M9 12.5h6"/>
        </svg>
        @break
    @case('ibc')
        {{-- IBC tote — kafesli küp tank + alt vana (1000 L) --}}
        <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="4" y="5.5" width="16" height="12.5" rx="1"/>
            <path d="M4 9.7h16M4 13.8h16M9.3 5.5v12.5M14.7 5.5v12.5"/>
            <path d="M9.3 3.5h5.4v2H9.3z"/>
            <path d="M10.5 18h3v2.4h-3z"/>
        </svg>
        @break
    @default
        {{-- Torba / sack — katı-toz ürün çuvalı: katlı üst kapak + şişkin gövde (kg) --}}
        <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M8.2 3.6h7.6l-1 2.9H9.2l-1-2.9Z"/>
            <path d="M9.2 6.5h5.6c1.8 1.6 3 4 3 6.9A5.8 5.8 0 0 1 12 20.4a5.8 5.8 0 0 1-5.8-7C6.2 10.5 7.4 8.1 9.2 6.5Z"/>
            <path d="M9.4 13h5.2"/>
        </svg>
@endswitch
