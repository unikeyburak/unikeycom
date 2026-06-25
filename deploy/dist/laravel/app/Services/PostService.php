<?php

namespace App\Services;

use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class PostService
{
    private const LIST_COLUMNS = [
        'id',
        'post_category_id',
        'created_by',
        'title',
        'slug',
        'excerpt',
        'featured_image',
        'status',
        'is_featured',
        'views',
        'reading_time',
        'published_at',
        'created_at',
    ];

    private const RELATED_COLUMNS = [
        'id',
        'post_category_id',
        'title',
        'slug',
        'excerpt',
        'featured_image',
        'reading_time',
        'published_at',
    ];

    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {}

    /**
     * Get published posts (paginated, filterable)
     */
    public function getPublishedPosts(
        int $perPage = 12,
        ?int $categoryId = null,
        ?int $tagId = null,
        ?string $search = null
    ): LengthAwarePaginator {
        return $this->postRepository->getPublishedPosts(
            $perPage,
            $categoryId,
            $tagId,
            $search,
            self::LIST_COLUMNS
        );
    }

    /**
     * Get post by slug (cached 1 hour)
     */
    public function getPostBySlug(string $slug): ?Post
    {
        return Cache::remember("post_slug_{$slug}", 3600, function () use ($slug) {
            return $this->postRepository->findBySlug($slug);
        });
    }

    /**
     * Get featured posts (cached 1 hour)
     */
    public function getFeaturedPosts(int $limit = 5): Collection
    {
        return Cache::remember('featured_posts_blog', 3600, function () use ($limit) {
            return $this->postRepository->getFeaturedPosts($limit, self::LIST_COLUMNS);
        });
    }

    /**
     * Get popular posts by views (cached 1 hour)
     */
    public function getPopularPosts(int $limit = 5): Collection
    {
        return Cache::remember('popular_posts', 3600, function () use ($limit) {
            return $this->postRepository->getPopularPosts($limit, self::LIST_COLUMNS);
        });
    }

    /**
     * Get related posts (cached 1 hour)
     */
    public function getRelatedPosts(Post $post, int $limit = 4): Collection
    {
        return Cache::remember("related_posts_blog_{$post->id}", 3600, function () use ($post, $limit) {
            return $this->postRepository->getRelatedPosts($post, $limit, self::RELATED_COLUMNS);
        });
    }

    /**
     * Get categories with post count (cached 1 hour)
     */
    public function getCategories(): Collection
    {
        return Cache::remember('blog_categories', 3600, function () {
            return $this->postRepository->getCategoriesWithCount();
        });
    }

    /**
     * Get tag cloud (cached 1 hour)
     */
    public function getTagCloud(): Collection
    {
        return Cache::remember('blog_tag_cloud', 3600, function () {
            return $this->postRepository->getTagCloud();
        });
    }

    /**
     * Get categories with their latest posts (cached 1 hour)
     */
    public function getCategoriesWithLatestPosts(int $postsPerCategory = 3): Collection
    {
        return Cache::remember('blog_categories_with_posts', 3600, function () use ($postsPerCategory) {
            $categories = PostCategory::active()
                ->withCount(['posts' => fn($q) => $q->published()])
                ->having('posts_count', '>', 0)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

            foreach ($categories as $category) {
                $category->setRelation('latestPosts',
                    Post::published()
                        ->where('post_category_id', $category->id)
                        ->with(['category'])
                        ->latest('published_at')
                        ->limit($postsPerCategory)
                        ->get(self::LIST_COLUMNS)
                );
            }

            return $categories;
        });
    }

    /**
     * Increment view count
     */
    public function incrementViews(Post $post): void
    {
        $this->postRepository->incrementViews($post);
    }

    /**
     * Get RSS feed posts (cached 1 hour)
     */
    public function getRssPosts(int $limit = 20): Collection
    {
        return Cache::remember('rss_posts', 3600, function () use ($limit) {
            return $this->postRepository->getRssPosts($limit);
        });
    }
}
