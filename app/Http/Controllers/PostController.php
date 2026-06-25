<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService
    ) {}

    /**
     * Blog listesi
     */
    public function index(Request $request)
    {
        $categories = $this->postService->getCategories();

        // Hero: featured or latest post
        $featuredPost = $this->postService->getFeaturedPosts(1)->first()
            ?? Post::published()->with(['category'])->latest('published_at')->first();

        // Categories with their latest 3 posts
        $categoryPosts = $this->postService->getCategoriesWithLatestPosts(3);

        $currentCategory = null;
        $currentTag = null;
        $searchQuery = null;

        return view('blog.index', compact(
            'categories', 'featuredPost', 'categoryPosts',
            'currentCategory', 'currentTag', 'searchQuery'
        ));
    }

    /**
     * Blog yazi detay
     */
    public function show(string $slug)
    {
        $post = $this->postService->getPostBySlug($slug);

        if (!$post || !$post->isPublished()) {
            abort(404);
        }

        // Goruntulenme sayacini artir
        $this->postService->incrementViews($post);

        // Ilgili yazilar
        $relatedPosts = $this->postService->getRelatedPosts($post, 4);

        // SEO meta verileri
        $meta = $post->getSeoMeta();

        // Article JSON-LD Schema
        $schema = json_encode($this->buildArticleSchema($post), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        // Breadcrumb: Ana Sayfa › Blog › [Kategori] › Yazı
        $schemas = [
            breadcrumb_schema(array_filter([
                ['name' => __('Ana Sayfa'), 'url' => lroute('home')],
                ['name' => __('Blog'), 'url' => lroute('blog.index')],
                $post->category ? ['name' => $post->category->name, 'url' => lroute('blog.category', $post->category->slug)] : null,
                ['name' => $post->title],
            ])),
        ];

        return view('blog.show', compact('post', 'relatedPosts', 'meta', 'schema', 'schemas'));
    }

    /**
     * Kategoriye gore filtrele
     */
    public function category(string $slug)
    {
        $currentCategory = PostCategory::where('slug', $slug)->active()->firstOrFail();

        $posts = $this->postService->getPublishedPosts(12, $currentCategory->id);
        $categories = $this->postService->getCategories();

        $currentTag = null;
        $searchQuery = null;

        $meta = $currentCategory->getSeoMeta();

        return view('blog.index', compact(
            'posts', 'categories',
            'currentCategory', 'currentTag', 'searchQuery', 'meta'
        ));
    }

    /**
     * Etikete gore filtrele
     */
    public function tag(string $slug)
    {
        $currentTag = PostTag::where('slug', $slug)->firstOrFail();

        $posts = $this->postService->getPublishedPosts(12, null, $currentTag->id);
        $categories = $this->postService->getCategories();

        $currentCategory = null;
        $searchQuery = null;

        $meta = [
            'title' => $currentTag->name . ' - Blog',
            'description' => $currentTag->name . ' etiketli blog yazıları',
            'keywords' => $currentTag->name,
        ];

        return view('blog.index', compact(
            'posts', 'categories',
            'currentCategory', 'currentTag', 'searchQuery', 'meta'
        ));
    }

    /**
     * Arama
     */
    public function search(Request $request)
    {
        $searchQuery = $request->get('q', '');

        $posts = $this->postService->getPublishedPosts(12, null, null, $searchQuery);
        $categories = $this->postService->getCategories();

        $currentCategory = null;
        $currentTag = null;

        return view('blog.index', compact(
            'posts', 'categories',
            'currentCategory', 'currentTag', 'searchQuery'
        ));
    }

    /**
     * RSS Feed
     */
    public function rss()
    {
        $posts = $this->postService->getRssPosts(20);

        return response()
            ->view('blog.rss', compact('posts'))
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

    /**
     * Article JSON-LD Schema olustur
     */
    private function buildArticleSchema($post): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $post->excerpt ?? $post->meta_description ?? '',
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => url(config('seo.schema.organization.logo', '/images/logo.png')),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $post->url,
            ],
        ];

        if ($post->featured_image_url) {
            $schema['image'] = $post->featured_image_url;
        }

        if ($post->category) {
            $schema['articleSection'] = $post->category->name;
        }

        if ($post->tags->isNotEmpty()) {
            $schema['keywords'] = $post->tags->pluck('name')->implode(', ');
        }

        if ($post->reading_time) {
            $schema['timeRequired'] = "PT{$post->reading_time}M";
        }

        return $schema;
    }
}
