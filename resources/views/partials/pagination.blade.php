{{-- Markaya uygun sayfalama (Laravel varsayılanının yerine)
     Kullanım: $products->links('partials.pagination') --}}
@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Sayfalama') }}" class="mt-10 flex flex-wrap items-center justify-between gap-4">
    <p class="text-sm text-ink-soft">
        {{ __(':total sonuçtan :first-:last arası gösteriliyor', ['first' => $paginator->firstItem(), 'last' => $paginator->lastItem(), 'total' => $paginator->total()]) }}
    </p>
    <div class="flex flex-wrap items-center gap-1.5">
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" class="grid h-10 min-w-10 place-items-center rounded-lg bg-white text-hair ring-1 ring-hair">«</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('Önceki') }}" class="grid h-10 min-w-10 place-items-center rounded-lg bg-white text-leaf-700 ring-1 ring-hair transition hover:bg-leaf-50">«</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="grid h-10 min-w-10 place-items-center text-ink-soft">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="grid h-10 min-w-10 place-items-center rounded-lg bg-leaf-600 px-1 font-extrabold text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="grid h-10 min-w-10 place-items-center rounded-lg bg-white px-1 font-bold text-leaf-700 ring-1 ring-hair transition hover:bg-leaf-50">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('Sonraki') }}" class="grid h-10 min-w-10 place-items-center rounded-lg bg-white text-leaf-700 ring-1 ring-hair transition hover:bg-leaf-50">»</a>
        @else
            <span aria-disabled="true" class="grid h-10 min-w-10 place-items-center rounded-lg bg-white text-hair ring-1 ring-hair">»</span>
        @endif
    </div>
</nav>
@endif
