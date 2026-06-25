{{-- Blog Post Card - Minimal Design --}}
<article class="group">
    <a href="{{ route('blog.show', $post->slug) }}" class="block">
        {{-- Image --}}
        <div class="aspect-[16/10] rounded-xl overflow-hidden bg-gray-100 mb-4">
            @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}"
                     alt="{{ $post->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-cyan-50 to-cyan-100">
                    <svg class="w-12 h-12 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Meta --}}
        <div class="flex items-center gap-3 mb-2">
            @if($post->category)
                <span class="text-xs font-semibold text-cyan-600 uppercase tracking-wide">{{ $post->category->name }}</span>
            @endif
            <span class="text-xs text-gray-400">
                {{ $post->published_at?->format('d.m.Y') ?? $post->created_at->format('d.m.Y') }}
            </span>
        </div>

        {{-- Title --}}
        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-cyan-600 transition-colors mb-2 line-clamp-2">
            {{ $post->title }}
        </h3>

        {{-- Excerpt --}}
        @if($post->excerpt)
            <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">
                {{ Str::limit(strip_tags($post->excerpt), 120) }}
            </p>
        @endif

        {{-- Reading time --}}
        @if($post->reading_time)
            <div class="mt-3 flex items-center gap-1 text-xs text-gray-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $post->reading_time }} {{ __('dk okuma') }}
            </div>
        @endif
    </a>
</article>
