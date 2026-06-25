{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ config('app.name') }} - Blog</title>
        <link>{{ lroute('blog.index') }}</link>
        <description>{{ config('app.name') }} - Blog</description>
        <language>tr</language>
        <lastBuildDate>{{ $posts->first()?->published_at?->toRssString() ?? now()->toRssString() }}</lastBuildDate>
        <atom:link href="{{ route('blog.rss') }}" rel="self" type="application/rss+xml" />

        @foreach($posts as $post)
        <item>
            <title><![CDATA[{{ $post->title }}]]></title>
            <link>{{ route('blog.show', $post->slug) }}</link>
            <guid isPermaLink="true">{{ route('blog.show', $post->slug) }}</guid>
            <description><![CDATA[{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 300) }}]]></description>
            <pubDate>{{ $post->published_at?->toRssString() ?? $post->created_at->toRssString() }}</pubDate>
            @if($post->category)
            <category><![CDATA[{{ $post->category->name }}]]></category>
            @endif
        </item>
        @endforeach
    </channel>
</rss>
